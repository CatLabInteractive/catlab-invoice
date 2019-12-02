<?php

namespace FI\Events;

use FI\Modules\Expenses\Models\Expense;
use Illuminate\Queue\SerializesModels;

class ExpenseSaving extends Event
{
    use SerializesModels;

    public function __construct(Expense $expense)
    {
        $this->expense = $expense;
    }
}