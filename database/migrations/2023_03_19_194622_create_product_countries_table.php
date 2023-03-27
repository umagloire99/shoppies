<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_countries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->on('products')->cascadeOnDelete();
            $table->foreignId('country_id')->constrained()->on('countries')->cascadeOnDelete();
            $table->float('price')->default(0.0);
            $table->integer('quantity')->nullable();

            $table->unique(['product_id', 'country_id']);
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
        Schema::dropIfExists('product_countries');
    }
}
