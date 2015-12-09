<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlyyaProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alyya_products', function (Blueprint $table) {
            $table->increments('sku');
            $table->timestamps();
            $table->unsignedInteger('category_id');
            $table->string('name',500);
            $table->string('brand',500);
            $table->string('manufacturer',500);
            $table->text('description');
            $table->string('slug');
            $table->string('slug_id');
            $table->unsignedInteger('quantity');
            $table->float('price');
            $table->float('coefficient');
            $table->string('eco_tax')->comment('En TTC');
            $table->string('image_url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('alyya_products');
    }
}
