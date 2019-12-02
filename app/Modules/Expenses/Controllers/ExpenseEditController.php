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

namespace FI\Modules\Expenses\Controllers;

use FI\Http\Controllers\Controller;
use FI\Modules\CompanyProfiles\Models\CompanyProfile;
use FI\Modules\CustomFields\Models\CustomField;
use FI\Modules\Expenses\Models\Expense;
use FI\Modules\Expenses\Requests\ExpenseRequest;
use FI\Support\DateFormatter;
use FI\Support\NumberFormatter;
use FI\Traits\ReturnUrl;

class ExpenseEditController extends Controller
{
    use ReturnUrl;

    public function edit($id)
    {
        return view('expenses.form')
            ->with('editMode', true)
            ->with('companyProfiles', CompanyProfile::getList())
            ->with('expense', $expense = Expense::defaultQuery()->find($id))
            ->with('customFields', CustomField::forTable('expenses')->get());
    }

    public function update(ExpenseRequest $request, $id)
    {
        $record = request()->except('attachments', 'custom');

        $record['expense_date'] = DateFormatter::unformat($record['expense_date']);
        $record['amount'] = NumberFormatter::unformat($record['amount']);
        $record['tax'] = ($record['tax']) ? NumberFormatter::unformat($record['tax']) : 0;

        $expense = Expense::find($id);

        $expense->fill($record);

        $expense->save();

        $expense->custom->update(request('custom', []));

        return redirect($this->getReturnUrl())
            ->with('alertSuccess', trans('fi.record_successfully_updated'));
    }
}