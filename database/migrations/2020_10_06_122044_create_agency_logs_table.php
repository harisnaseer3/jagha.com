<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAgencyLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agency_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('agency_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('agency_title', 225);
            $table->string('admin_name', 255);
            $table->string('status', 255);
            $table->string('rejection_reason', 255)->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        DB::statement('ALTER TABLE `agency_logs`
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
        Schema::dropIfExists('agency_logs');
    }
}
