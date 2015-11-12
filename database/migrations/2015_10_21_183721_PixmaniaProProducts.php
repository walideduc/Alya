<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PixmaniaProProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pixmania_pro_products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category');
            $table->string('market');
            $table->string('segment');
            $table->string('PIXpro_SKU');
            $table->string('brand');
            $table->string('label');
            $table->text('description');
            $table->float('PIXpro_price');
            $table->float('delivery');
            $table->float('price');
            $table->string('picture');
            $table->string('availability');
            $table->float('weight');
            $table->float('weight_volume');
            $table->float('express_Delivery');
            $table->string('EAN');
            $table->string('Manufacturer_Reference');
            $table->string('WEEE');
            $table->string('Reprography');
            $table->float('Private_Copying');
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
        //Schema::drop('pixmania_pro_products');
    }
}
