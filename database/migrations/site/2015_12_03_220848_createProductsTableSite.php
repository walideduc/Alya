<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTableSite extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->primary('id');
            $table->timestamps();
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
        Schema::drop('products');
    }
}
