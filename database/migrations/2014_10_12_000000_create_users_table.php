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
            $table->string('email')->nullable()->unique();
            $table->string('username')->unique();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('user_image')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->string('sign_up_method')->default('normal');
            $table->boolean('receive_email')->default(true);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
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
