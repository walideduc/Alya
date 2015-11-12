<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AmazonOrderedProductsAmazonFees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amazon_ordered_products_amazon_fees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('amazonOrderID',25);
            $table->string('amazonOrderItemCode',25);
            $table->string('type');
            $table->float('amount');
            $table->string('currency');
            $table->unique(['amazonOrderItemCode','type'],'unique_amazonOrderItemCode_type' );
            $table->timestamp('inserted_at')->default(\Illuminate\Support\Facades\DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::drop('amazon_ordered_products_amazon_fees');
    }
}
