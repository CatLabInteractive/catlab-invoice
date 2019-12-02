<?php

namespace FI\Events\Listeners;

use FI\Events\InvoiceEmailing;
use FI\Support\DateFormatter;

class InvoiceEmailingListener
{
    public function handle(InvoiceEmailing $event)
    {
        if (config('fi.resetInvoiceDateEmailDraft') and $event->invoice->status_text == 'draft') {
            $event->invoice->invoice_date = date('Y-m-d');
            $event->invoice->due_at = DateFormatter::incrementDateByDays(date('Y-m-d'), config('fi.invoicesDueAfter'));
            $event->invoice->save();
        }
    }
}
