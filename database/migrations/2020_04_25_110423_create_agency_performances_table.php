<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAgencyPerformancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agency_performances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('views')->default(0);
            $table->unsignedBigInteger('visits')->default(0);
            $table->unsignedBigInteger('click_through_rate')->default(0);
            $table->unsignedBigInteger('email')->default(0);
            $table->unsignedBigInteger('phone')->default(0);
            $table->unsignedBigInteger('sms')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });

        DB::statement('ALTER TABLE `agency_performances`
            CHANGE `created_at` `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
            CHANGE `updated_at` `updated_at` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NULL DEFAULT NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agency_performances');
    }
}
