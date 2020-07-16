<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->integer('contact_period_value', false, true);
            $table->enum('contact_period_unit', ['Year', 'Month']);
            $table->integer('rental_price', false, true);
            $table->integer('number_of_cheques', false, true);
            $table->integer('security_deposit', false, true);
            $table->integer('agency_commission_tenant', false, true);
            $table->integer('agency_commission_landlord', false, true);
            $table->integer('advanced_rent', false, true);
            $table->integer('vacating_notice_period', false, true);
            $table->enum('maintenance_paid_by', ['Landlord', 'Tenant']);
            $table->integer('maintenance_fee', false, true);
            $table->softDeletes();
            $table->timestamps();
        });

        DB::statement('ALTER TABLE `rents`
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
        Schema::dropIfExists('rents');
    }
}
