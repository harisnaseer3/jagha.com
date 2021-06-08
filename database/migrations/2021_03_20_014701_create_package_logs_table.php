<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePackageLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('admin_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->string('status', 255);
            $table->softDeletes();
            $table->timestamps();
        });

        DB::statement('ALTER TABLE `package_logs`
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
        Schema::dropIfExists('package_logs');
    }
}
