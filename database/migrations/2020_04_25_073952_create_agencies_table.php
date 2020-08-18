<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAgenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agencies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('city_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('title', 225);
            $table->string('description', 4096);
            $table->string('phone', 32)->nullable();
            $table->string('cell', 32)->nullable();
            $table->string('fax', 32)->nullable();
            $table->string('address', 255)->nullable();
            $table->integer('zip_code')->nullable();
            $table->string('country', 255);
            $table->string('email')->unique()->nullable();
            $table->string('website', 1024)->nullable();
            $table->string('logo', 4096)->nullable();
            $table->string('ceo_name', 255)->nullable();
            $table->string('ceo_designation', 255)->nullable();
            $table->string('ceo_message', 1024)->nullable();
            $table->string('ceo_image', 4096)->nullable();
            $table->enum('status', ['verified', 'pending', 'expired', 'deleted', 'rejected'])->default('pending');
            $table->boolean('featured_listing')->default(false);
            $table->boolean('key_listing')->default(false);
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });


        DB::statement('ALTER TABLE `agencies`
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
        Schema::dropIfExists('agencies');
    }
}
