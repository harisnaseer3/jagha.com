<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('cnic', 15)->nullable();
            $table->string('phone', 32)->nullable();
            $table->string('cell', 32)->nullable();
            $table->string('fax', 32)->nullable();
            $table->string('address', 255)->nullable();
            $table->integer('zip_code')->nullable();
            $table->string('country', 255)->nullable();
            $table->string('community_nick', 255)->nullable();
            $table->string('about_yourself', 4096)->nullable();
            $table->string('image', 4096)->nullable();
            $table->enum('is_active', ['0', '1'])->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
