<?php

use FI\Modules\Settings\Models\Setting;
use Illuminate\Database\Migrations\Migration;

class Version201611 extends Migration
{
    public function up()
    {
        Setting::saveByKey('version', '2016-11');
    }

    public function down()
    {
        //
    }
}
