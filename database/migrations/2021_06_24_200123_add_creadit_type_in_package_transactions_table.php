<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreaditTypeInPackageTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('package_transactions', function (Blueprint $table) {
            $table->enum('credit_type', ['complementary', 'purchased']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('package_transactions', function (Blueprint $table) {
            $table->dropColumn(['body']);
        });
    }
}
