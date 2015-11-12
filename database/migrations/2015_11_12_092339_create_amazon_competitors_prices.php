<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmazonCompetitorsPrices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amazon_competitors_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('remote_id',25);
            $table->timestamp('inserted_at')->default(\Illuminate\Support\Facades\DB::raw('CURRENT_TIMESTAMP'));
            $table->string('position');
            $table->string('shop_name');
            $table->string('price');
            $table->string('shipping_price');
            $table->string('status');
            $table->string('allOfferListingsConsidered',25)->comment('indicates whether or not all of the active offer listings for the specified product and ItemCondition were considered when the listings were placed into their corresponding offer listing groups.');
            $table->string('marketplaceId');
            $table->string('sellerId');
            $table->string('sellerSKU');
            $table->string('itemCondition')->comment('(New, Used, Collectible, Refurbished, or Club)');
            $table->string('itemSubCondition')->comment('(New, Mint, Very Good, Good, Acceptable, Poor, Club, OEM, Warranty, Refurbished Warranty, Refurbished, Open Box, or Other)');
            $table->string('fulfillmentChannel')->comment('Amazon or Merchant');
            $table->string('shipsDomestically')->comment('(True, False, or Unknown) – Indicates whether the marketplace specified in the request and the location that the item ships from are in the same country.');
            $table->string('shippingTime')->comment('(0-2 days, 3-7 days, 8-13 days, or 14 or more days) – Indicates the maximum time within which the item will likely be shipped once an order has been placed');
            $table->string('sellerPositiveFeedbackRating')->comment('(98-100%, 95-97%, 90-94%, 80-89%, 70-79%, Less than 70%, or Just launched) ) – Indicates the percentage of feedback ratings that were positive over the past 12 months');
            $table->string('numberOfOfferListingsConsidered')->comment('is the actual number of active offer listings that met the six qualifying criteria of the offer listing group. However if AllOfferListingsConsidered is returned with a value of False, then the actual number might be higher.');
            $table->string('sellerFeedbackCount')->comment('The number of seller feedback ratings that have been submitted for the seller with the lowest-priced offer listing in the group.');
            $table->string('landedPrice_CurrencyCode');
            $table->string('landedPrice_Amount');
            $table->string('listingPrice_CurrencyCode');
            $table->string('listingPrice_Amount');
            $table->string('shipping_CurrencyCode');
            $table->string('shipping_Amount');
            $table->string('multipleOffersAtLowestPrice')->comment('True – There is more than one listing with the lowest listing price in the group.');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('amazon_competitors_prices');
    }
}
