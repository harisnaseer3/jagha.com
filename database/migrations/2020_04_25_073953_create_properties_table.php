<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
//            TODO: add unique feature after seeder
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('reference')->unique();
            $table->foreignId('city_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('location_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('agency_id')->nullable();
            $table->enum('purpose', ['Sale', 'Rent', 'Wanted']);
            $table->enum('sub_purpose', ['Buy', 'Rent'])->nullable();
            $table->string('type', 255);
            $table->string('sub_type', 255);
            $table->string('title', 255);
            $table->string('description', 6144);
            $table->bigInteger('price', false, true);
            $table->unsignedTinyInteger('call_for_inquiry', false)->default(0);;
            $table->decimal('land_area', 12, 2, true);
            $table->enum('area_unit', ['Square Feet', 'Square Yards', 'Square Meters', 'Marla', 'Kanal']);
            $table->decimal('area_in_sqft', 12, 2, true);
            $table->decimal('area_in_sqyd', 12, 2, true);
            $table->decimal('area_in_sqm', 12, 2, true);
            $table->decimal('area_in_marla', 12, 2, true);
            $table->decimal('area_in_new_marla', 12, 2, true);
            $table->decimal('area_in_kanal', 12, 2, true);
            $table->decimal('area_in_new_kanal', 12, 2, true);
            $table->unsignedTinyInteger('bedrooms')->default(0);
            $table->unsignedTinyInteger('bathrooms')->default(0);
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->json('features')->nullable();
            $table->boolean('premium_listing')->default(false);
            $table->boolean('super_hot_listing')->default(false);
            $table->boolean('hot_listing')->default(false);
            $table->boolean('magazine_listing')->default(false);
            $table->unsignedTinyInteger('basic_listing')->default(0);
            $table->unsignedTinyInteger('bronze_listing')->default(0);
            $table->unsignedTinyInteger('silver_listing')->default(0);
            $table->unsignedTinyInteger('golden_listing')->default(0);
            $table->unsignedTinyInteger('platinum_listing')->default(0);
            $table->string('contact_person', 255)->nullable();
            $table->string('reviewed_by', 255)->nullable();
            $table->string('phone', 32)->nullable()->nullable();
            $table->string('cell', 32)->nullable()->nullable();
            $table->string('fax', 32)->nullable();
            $table->string('email', 255)->nullable();
            $table->unsignedBigInteger('favorites')->default(0);
            $table->unsignedBigInteger('views')->default(0);
            $table->unsignedBigInteger('visits')->default(0);
            $table->decimal('click_through_rate')->default(0);
            $table->enum('status', ['active', 'edited', 'pending', 'expired', 'uploaded', 'hidden', 'deleted', 'rejected'])->default('pending');
            $table->string('rejection_reason', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->dateTime('expired_at');
            $table->dateTime('activated_at');
            $table->softDeletes();
            $table->timestamps();
        });

        DB::statement('ALTER TABLE `properties`
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
        Schema::dropIfExists('properties');
    }
}
