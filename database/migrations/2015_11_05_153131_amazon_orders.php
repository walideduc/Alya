<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AmazonOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amazon_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('documentID',25);
            $table->string('documentID_doubled',25);
            $table->string('amazonOrderID',25)->unique();
            $table->string('amazonSessionID',25);
            $table->dateTime('orderDate');
            $table->dateTime('orderPostedDate');
            $table->string('buyerEmailAddress');
            $table->string('buyerName');
            $table->string('buyerPhoneNumber');
            $table->string('billingName');
            $table->string('billingFormalTitle');
            $table->string('billingGivenName');
            $table->string('billingFamilyName');
            $table->string('billingAddressFieldOne');
            $table->string('billingAddressFieldTwo');
            $table->string('billingAddressFieldThree');
            $table->string('billingCity');
            $table->string('billingCounty');
            $table->string('billingStateOrRegion');
            $table->string('billingPostalCode');
            $table->string('billingCountryCode');
            $table->string('billingPhoneNumber');
            $table->string('fulfillmentMethod');
            $table->string('fulfillmentServiceLevel');
            $table->string('fulfillmentName');
            $table->string('fulfillmentFormalTitle');
            $table->string('fulfillmentGivenName');
            $table->string('fulfillmentFamilyName');
            $table->string('fulfillmentAddressFieldOne');
            $table->string('fulfillmentAddressFieldTwo');
            $table->string('fulfillmentAddressFieldThree');
            $table->string('fulfillmentCity');
            $table->string('fulfillmentCounty');
            $table->string('fulfillmentStateOrRegion');
            $table->string('fulfillmentPostalCode');
            $table->string('fulfillmentCountryCode');
            $table->string('fulfillmentPhoneNumber');
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
        //Schema::drop('amazon_orders');
    }
}
