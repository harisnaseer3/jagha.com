<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSupportCountsByTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('support_counts_by_types', function (Blueprint $table) {
            $table->id();
            $table->string('inquire_type');
            $table->unsignedBigInteger('count')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });

        DB::statement('ALTER TABLE `support_counts_by_types`
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
        Schema::dropIfExists('support_counts_by_types');
    }
}
