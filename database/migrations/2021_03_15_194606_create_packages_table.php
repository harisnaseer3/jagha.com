<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->enum('type', ['Gold', 'Silver']);
            $table->enum('package_for', ['properties', 'agency']);
            $table->integer('admin_id')->nullable();
            $table->integer('property_count');
            $table->enum('status', ['active', 'pending', 'rejected','deactivate','deleted']);
            $table->dateTime('activated_at')->nullable();
            $table->dateTime('expired_at')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        DB::statement('ALTER TABLE `packages`
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
        Schema::dropIfExists('packages');
    }
}
