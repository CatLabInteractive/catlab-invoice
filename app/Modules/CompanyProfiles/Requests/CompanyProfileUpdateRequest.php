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

namespace FI\Modules\CompanyProfiles\Requests;

class CompanyProfileUpdateRequest extends CompanyProfileStoreRequest
{
    public function rules()
    {
        return ['company' => 'required|unique:company_profiles,company,' . $this->route('id')];
    }
}