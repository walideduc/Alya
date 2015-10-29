<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmazonProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amazon_products', function (Blueprint $table) {
            $table->unsignedInteger('sku');
            $table->primary('sku');
            $table->timestamps();
            $table->string('asin',25)->nullable();
            $table->tinyInteger('existence')->default(0);
            $table->tinyInteger('locked');
            $table->tinyInteger('category_id');
            $table->string('ref_type');
            $table->string('ref_value');
            $table->string('name',500);
            $table->string('brand',500);
            $table->text('description');
            $table->string('manufacturer',500);
            $table->string('item_type');
            $table->string('condition_note')->default(' Vendeur profissionel ');
            $table->string('condition_type')->default('New');
            $table->unsignedInteger('quantity');
            $table->float('price');
            $table->float('coefficient');
            $table->float('price_ttc_supplier');
            $table->string('image_url');
            $table->dateTime('data_changed_at');
            $table->dateTime('data_submitted_at');
            $table->integer('creation_failed')->default(0);
            $table->dateTime('price_changed_at');
            $table->dateTime('price_submitted_at');
            $table->dateTime('stock_changed_at');
            $table->dateTime('stock_submitted_at');
            $table->dateTime('image_changed_at');
            $table->dateTime('image_submitted_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('amazon_products');
    }
}
