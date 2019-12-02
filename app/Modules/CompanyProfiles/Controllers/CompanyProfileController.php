<?php

/**
 * InvoicePlane
 *
 * @package     InvoicePlane
 * @author      InvoicePlane Developers & Contributors
 * @copyright   Copyright (C) 2014 - 2018 InvoicePlane
 * @license     https://invoiceplane.com/license
 * @link        https://invoiceplane.com
 *
 * Based on FusionInvoice by Jesse Terry (FusionInvoice, LLC)
 */

namespace FI\Modules\CompanyProfiles\Controllers;

use FI\Http\Controllers\Controller;
use FI\Modules\CompanyProfiles\Models\CompanyProfile;
use FI\Modules\CompanyProfiles\Requests\CompanyProfileStoreRequest;
use FI\Modules\CompanyProfiles\Requests\CompanyProfileUpdateRequest;
use FI\Modules\CustomFields\Models\CustomField;
use FI\Modules\Invoices\Support\InvoiceTemplates;
use FI\Modules\Quotes\Support\QuoteTemplates;
use FI\Traits\ReturnUrl;

class CompanyProfileController extends Controller
{
    use ReturnUrl;

    public function index()
    {
        $this->setReturnUrl();

        return view('company_profiles.index')
            ->with('companyProfiles', CompanyProfile::orderBy('company')->paginate(config('fi.resultsPerPage')));
    }

    public function create()
    {
        return view('company_profiles.form')
            ->with('editMode', false)
            ->with('invoiceTemplates', InvoiceTemplates::lists())
            ->with('quoteTemplates', QuoteTemplates::lists())
            ->with('customFields', CustomField::forTable('company_profiles')->get());
    }

    public function store(CompanyProfileStoreRequest $request)
    {
        $input = $request->except('custom');

        if ($request->hasFile('logo')) {
            $logoFileName = $request->file('logo')->getClientOriginalName();
            $request->file('logo')->move(storage_path(), $logoFileName);

            $input['logo'] = $logoFileName;
        }

        $companyProfile = CompanyProfile::create($input);

        $companyProfile->custom->update($request->input('custom', []));

        return redirect($this->getReturnUrl())
            ->with('alertSuccess', trans('fi.record_successfully_created'));
    }

    public function edit($id)
    {
        $companyProfile = CompanyProfile::find($id);

        return view('company_profiles.form')
            ->with('editMode', true)
            ->with('companyProfile', $companyProfile)
            ->with('companyProfileInUse', CompanyProfile::inUse($id))
            ->with('invoiceTemplates', InvoiceTemplates::lists())
            ->with('quoteTemplates', QuoteTemplates::lists())
            ->with('customFields', CustomField::forTable('company_profiles')->get());
    }

    public function update(CompanyProfileUpdateRequest $request, $id)
    {
        $input = $request->except('custom');

        if ($request->hasFile('logo')) {
            $logoFileName = $request->file('logo')->getClientOriginalName();
            $request->file('logo')->move(storage_path(), $logoFileName);

            $input['logo'] = $logoFileName;
        }

        $companyProfile = CompanyProfile::find($id);
        $companyProfile->fill($input);
        $companyProfile->save();

        $companyProfile->custom->update($request->input('custom', []));

        return redirect($this->getReturnUrl())
            ->with('alertInfo', trans('fi.record_successfully_updated'));
    }

    public function delete($id)
    {
        if (CompanyProfile::inUse($id)) {
            $alert = trans('fi.cannot_delete_record_in_use');
        } else {
            CompanyProfile::destroy($id);

            $alert = trans('fi.record_successfully_deleted');
        }

        return redirect()->route('companyProfiles.index')
            ->with('alert', $alert);
    }

    public function ajaxModalLookup()
    {
        return view('company_profiles._modal_lookup')
            ->with('id', request('id'))
            ->with('companyProfiles', CompanyProfile::getList())
            ->with('refreshFromRoute', request('refresh_from_route'))
            ->with('updateCompanyProfileRoute', request('update_company_profile_route'));
    }

    public function deleteLogo($id)
    {
        $companyProfile = CompanyProfile::find($id);

        $companyProfile->logo = null;

        $companyProfile->save();

        if (file_exists(storage_path($companyProfile->logo))) {
            try {
                unlink(storage_path($companyProfile->logo));
            } catch (\Exception $e) {

            }
        }
    }
}