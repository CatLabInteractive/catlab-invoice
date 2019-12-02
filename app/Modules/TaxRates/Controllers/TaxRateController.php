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

namespace FI\Modules\TaxRates\Controllers;

use FI\Http\Controllers\Controller;
use FI\Modules\TaxRates\Models\TaxRate;
use FI\Modules\TaxRates\Requests\TaxRateRequest;
use FI\Traits\ReturnUrl;

class TaxRateController extends Controller
{
    use ReturnUrl;

    public function index()
    {
        $this->setReturnUrl();

        $taxRates = TaxRate::sortable(['name' => 'asc'])->paginate(config('fi.resultsPerPage'));

        return view('tax_rates.index')
            ->with('taxRates', $taxRates);
    }

    public function create()
    {
        return view('tax_rates.form')
            ->with('editMode', false);
    }

    public function store(TaxRateRequest $request)
    {
        TaxRate::create($request->all());

        return redirect($this->getReturnUrl())
            ->with('alertSuccess', trans('fi.record_successfully_created'));
    }

    public function edit($id)
    {
        $taxRate = TaxRate::find($id);

        return view('tax_rates.form')
            ->with('editMode', true)
            ->with('taxRate', $taxRate);
    }

    public function update(TaxRateRequest $request, $id)
    {
        $taxRate = TaxRate::find($id);

        $taxRate->fill($request->all());

        $taxRate->save();

        return redirect($this->getReturnUrl())
            ->with('alertInfo', trans('fi.record_successfully_updated'));
    }

    public function delete($id)
    {
        $taxRate = TaxRate::find($id);

        if ($taxRate->in_use) {
            $alert = trans('fi.cannot_delete_record_in_use');
        } else {
            $taxRate->delete();

            $alert = trans('fi.record_successfully_deleted');
        }

        return redirect()->route('taxRates.index')
            ->with('alert', $alert);
    }
}