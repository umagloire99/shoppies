<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->boolean('default_address')->default(false);
            $table->string('name')->nullable();
            $table->string('address_title');
            $table->string('email')->nullable();
            $table->string('phone_one');
            $table->string('phone_two');
            $table->string('zip_code')->nullable();
            $table->string('po_box')->nullable();

            $table->foreignId('city_id')->nullable()->constrained()->on('cities')->cascadeOnDelete();
            $table->foreignId('country_id')->default(1)->constrained()->on('cities')->cascadeOnDelete();
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
        Schema::dropIfExists('user_addresses');
    }
}
