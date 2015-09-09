<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('supplier_id');
            $table->string('supplier_ref');
            /*The second param is to manually set the name of the unique index. Use an array as the first param to create a unique key across multiple columns.*/
            $table->unique(['supplier_id','supplier_ref']);
            $table->string('ref_type');
            $table->string('ref_value');
            $table->string('name',500);
            $table->string('brand',500);
            $table->string('manufacturer',500);
            $table->text('description');
            $table->string('slug');
            $table->unsignedInteger('quantity');
            $table->float('price_ttc');
            $table->string('eco_tax')->comment('En TTC');
            $table->string('vat_rate');
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
