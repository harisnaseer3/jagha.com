<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInPropertyCountByAgencies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('property_count_by_agencies', function (Blueprint $table) {
            $table->string('property_purpose', 225)->index();
            $table->string('property_status', 255)->index();
            $table->string('listing_type', 255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('property_count_by_agencies', function (Blueprint $table) {
            //
        });
    }
}
