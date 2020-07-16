<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePropertyCountByPropertyTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_count_by_property_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('city_name', 255);
            $table->foreignId('location_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('location_name', 255);
            $table->string('property_type', 255);
            $table->string('property_sub_type', 255);
            $table->unsignedBigInteger('property_count')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });

        DB::statement('ALTER TABLE `property_count_by_property_types`
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
        Schema::dropIfExists('property_count_by_property_types');
    }
}
