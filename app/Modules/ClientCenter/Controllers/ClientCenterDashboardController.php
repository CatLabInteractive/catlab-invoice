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
use FI\Modules\Payments\Models\Payment;
use FI\Modules\Quotes\Models\Quote;
use FI\Support\Statuses\InvoiceStatuses;
use FI\Support\Statuses\QuoteStatuses;
use Illuminate\Support\Facades\DB;

class ClientCenterDashboardController extends Controller
{
    private $invoiceStatuses;
    private $quoteStatuses;

    public function __construct(
        InvoiceStatuses $invoiceStatuses,
        QuoteStatuses $quoteStatuses)
    {
        $this->invoiceStatuses = $invoiceStatuses;
        $this->quoteStatuses = $quoteStatuses;
    }

    public function index()
    {
        $clientId = auth()->user()->client->id;

        $invoices = Invoice::with(['amount.invoice.currency', 'client'])
            ->where('client_id', $clientId)
            ->orderBy('created_at', 'DESC')
            ->orderBy(DB::raw('length(number)'), 'DESC')
            ->orderBy('number', 'DESC')
            ->limit(5)->get();

        $quotes = Quote::with(['amount.quote.currency', 'client'])
            ->where('client_id', $clientId)
            ->orderBy('created_at', 'DESC')
            ->orderBy(DB::raw('length(number)'), 'DESC')
            ->orderBy('number', 'DESC')
            ->limit(5)->get();

        $payments = Payment::with('invoice.amount.invoice.currency', 'invoice.client')
            ->whereHas('invoice', function ($invoice) use ($clientId) {
                $invoice->where('client_id', $clientId);
            })->orderBy('created_at', 'desc')
            ->limit(5)->get();

        return view('client_center.index')
            ->with('invoices', $invoices)
            ->with('quotes', $quotes)
            ->with('payments', $payments)
            ->with('invoiceStatuses', $this->invoiceStatuses->statuses())
            ->with('quoteStatuses', $this->quoteStatuses->statuses());
    }

    public function redirectToLogin()
    {
        return redirect()->route('session.login');
    }
}