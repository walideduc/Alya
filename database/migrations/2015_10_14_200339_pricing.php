<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Pricing extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pricing', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer("sku");
            $table->integer("category_id");
            $table->integer("supplier_id");
            $table->float("price_ttc");
            $table->float("price_ht");
            $table->float("eco_tax");
            $table->float("marge");
            $table->integer("reseller_id");
            $table->float("comm");
            $table->float("purchase_price_ht");
            $table->float("selling_price_ht");
            $table->float("amazon_commission_ttc");
            $table->float("amazon_commission_ht");
            $table->float("cost_price_ht");
            $table->float("vat_rate_dicimal");
            $table->float("selling_price_ttc");
            $table->float("cost_price_ttc");
            $table->float("tva_product");
            $table->float("tva_general");
            $table->float("coeff");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::drop('pricing');
    }
}
