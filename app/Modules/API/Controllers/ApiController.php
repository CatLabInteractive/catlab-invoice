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

namespace FI\Modules\API\Controllers;

use Illuminate\Routing\Controller;

class ApiController extends Controller
{
    protected $validator;

    public function __construct()
    {
        $this->validator = app('Illuminate\Validation\Factory');
    }
}