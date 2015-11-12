<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AmazonOrderCreditCard extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amazon_order_creditCard', function (Blueprint $table) {
            $table->increments('id');
            $table->string('amazonOrderID',25);
            $table->string('issuer');
            $table->string('tail');
            $table->string('expirationDate');
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
        //Schema::drop('amazon_order_creditCard');
    }
}
