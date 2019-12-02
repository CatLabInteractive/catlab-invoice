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

namespace FI\Modules\Currencies\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CurrencyStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function attributes()
    {
        return [
            'name' => trans('fi.name'),
            'code' => trans('fi.code'),
            'symbol' => trans('fi.symbol'),
            'placement' => trans('fi.symbol_placement'),
        ];
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'code' => 'required|unique:currencies',
            'symbol' => 'required',
            'placement' => 'required',
        ];
    }
}