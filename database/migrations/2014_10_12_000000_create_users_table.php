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
            $table->string('name', 100);

            $table->string('first_name', 25)->nullable(false);
            $table->string('last_name', 75)->nullable(false);
            $table->string('username', 25)->nullable(false);
            $table->integer('level')->default(1);
            $table->string('gender', 1);
            $table->string('photo')->nullable();
            $table->fullText(['first_name', 'last_name', 'username', 'email']);

            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
