<?php

namespace FI\Events;

use FI\Modules\Quotes\Models\Quote;
use Illuminate\Queue\SerializesModels;

class QuoteCreated extends Event
{
    use SerializesModels;

    public function __construct(Quote $quote)
    {
        $this->quote = $quote;
    }
}