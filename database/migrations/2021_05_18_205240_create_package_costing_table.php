<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePackageCostingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_costings', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['Gold','Platinum']);
            $table->enum('package_for', ['properties', 'agency']);
            $table->integer('price_per_unit');

            $table->softDeletes();
            $table->timestamps();
        });

        DB::statement('ALTER TABLE `package_costings`
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
        Schema::dropIfExists('package_costing');
    }
}
