<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AmazonOrderedProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amazon_ordered_products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('amazonOrderID',25);
            $table->string('amazonOrderItemCode',25)->unique();
            $table->unsignedInteger('SKU');
            $table->string('title');
            $table->unsignedInteger('quantity');
            $table->string('productTaxCode');
            $table->float('itemPrice_principal');
            $table->string('itemPrice_principal_currency');
            $table->float('itemPrice_Shipping');
            $table->string('itemPrice_shipping_currency');
            $table->float('itemPrice_tax');
            $table->string('itemPrice_tax_currency');
            $table->float('itemPrice_shippingTax');
            $table->string('itemPrice_shippingTax_currency');
            $table->float('itemFees_commission');
            $table->string('itemFees_commission_currency');
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
        //Schema::drop('amazon_ordered_products');
    }
}
