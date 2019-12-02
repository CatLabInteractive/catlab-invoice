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

namespace FI\Modules\ClientCenter\Controllers;

use FI\Http\Controllers\Controller;
use FI\Modules\Invoices\Models\Invoice;
use FI\Support\Statuses\InvoiceStatuses;
use Illuminate\Support\Facades\DB;

class ClientCenterInvoiceController extends Controller
{
    private $invoiceStatuses;

    public function __construct(InvoiceStatuses $invoiceStatuses)
    {
        $this->invoiceStatuses = $invoiceStatuses;
    }

    public function index()
    {
        $invoices = Invoice::with(['amount.invoice.currency', 'client'])
            ->where('client_id', auth()->user()->client->id)
            ->orderBy('created_at', 'DESC')
            ->orderBy(DB::raw('length(number)'), 'DESC')
            ->orderBy('number', 'DESC')
            ->paginate(config('fi.resultsPerPage'));

        return view('client_center.invoices.index')
            ->with('invoices', $invoices)
            ->with('invoiceStatuses', $this->invoiceStatuses->statuses());
    }
}