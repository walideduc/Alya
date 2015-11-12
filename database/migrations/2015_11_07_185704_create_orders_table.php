<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger('shop_id');
            $table->string('shop_order_id');
            $table->string('customer_email');
            $table->string('billing_address_name');
            $table->string('billing_address_street_1');
            $table->string('billing_address_street_2');
            $table->string('billing_address_street_3');
            $table->string('billing_address_postalCode');
            $table->string('billing_address_city');
            $table->string('billing_address_stateOrRegion');
            $table->string('billing_address_country');
            $table->string('billing_address_country_code');
            $table->string('billing_phoneNumber');
            $table->unsignedInteger('total_order_to_pay');
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
        Schema::drop('orders');
    }
}
