<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('address_name');
            $table->string('title',4)->default('Mr');
            $table->string('name');
            $table->string('street_one');
            $table->string('street_tow');
            $table->string('street_three');
            $table->string('city');
            $table->string('county');
            $table->string('stateOrRegion');
            $table->string('postalCode');
            $table->string('countryCode');
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
        Schema::drop('address');
    }
}
