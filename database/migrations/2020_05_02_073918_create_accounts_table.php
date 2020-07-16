<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('message_signature', 4096)->nullable();
            $table->enum('email_notification', ['Subscribe', 'Unsubscribe'])->default('Subscribe');
            $table->enum('newsletter', ['Subscribe', 'Unsubscribe'])->default('Subscribe');
            $table->enum('automated_reports', ['Subscribe', 'Unsubscribe'])->default('Subscribe');
            $table->enum('email_format', ['HTML', 'TEXT'])->default('TEXT');
            $table->string('default_currency');
            $table->string('default_area_unit');
            $table->string('default_language');
            $table->enum('sms_notification', ['On', 'Off'])->default('Off');
            $table->softDeletes();
            $table->timestamps();
        });

        DB::statement('ALTER TABLE `accounts`
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
        Schema::dropIfExists('accounts');
    }
}
