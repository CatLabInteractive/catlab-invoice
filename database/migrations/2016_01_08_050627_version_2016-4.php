<?php

use FI\Modules\Settings\Models\Setting;
use Illuminate\Database\Migrations\Migration;

class Version20164 extends Migration
{
    public function up()
    {
        Setting::saveByKey('version', '2016-4');
    }

    public function down()
    {
        //
    }
}
