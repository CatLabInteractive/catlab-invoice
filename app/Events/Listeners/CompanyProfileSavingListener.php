<?php

namespace FI\Events\Listeners;

use FI\Events\CompanyProfileSaving;

class CompanyProfileSavingListener
{
    public function __construct()
    {
        //
    }

    public function handle(CompanyProfileSaving $event)
    {
        $event->companyProfile->address = strip_tags($event->companyProfile->address);
    }
}
