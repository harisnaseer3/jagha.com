<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSaleAndRentCountInTotalPropertyCount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('total_property_count', function (Blueprint $table) {
            $table->bigInteger('sale_property_count',false, true)->after('property_count')->default(0);
            $table->bigInteger('rent_property_count',false, true)->after('property_count')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('total_property_count', function (Blueprint $table) {
            //
        });
    }
}
