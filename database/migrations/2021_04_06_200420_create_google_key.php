<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateGoogleKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('google_key', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->softDeletes();
            $table->timestamps();
        });

        DB::statement('ALTER TABLE `google_key`
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
        Schema::dropIfExists('google_key');
    }
}
