<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingAgenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_agencies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('out_of_town')->default(false);
            $table->unsignedDecimal('cost')->default('0.00');
            $table->boolean('can_pay_on_delivery')->default(true);
            $table->boolean('status')->default(true);
            $table->foreignId('country_id')->default(1)->constrained()->on('countries')
                ->cascadeOnDelete();
            $table->foreignId('city_id')->nullable()->unique()->constrained()->on('cities')
                ->cascadeOnDelete();
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
        Schema::dropIfExists('shipping_companies');
    }
}
