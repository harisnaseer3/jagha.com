<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePropertyCountByListingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_count_by_listings', function (Blueprint $table) {
            $table->id();
            $table->string('property_purpose', 225)->index();
            $table->integer('property_count')->unsigned()->index();
            $table->string('listing_type', 255)->index();;
            $table->softDeletes();
            $table->timestamps();
        });

        DB::statement('ALTER TABLE `property_count_by_listings`
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
        Schema::dropIfExists('property_count_by_listing');
    }
}
