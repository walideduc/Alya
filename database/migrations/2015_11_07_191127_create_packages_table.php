<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_id');
            $table->unsignedInteger('supplier_id');
            $table->string('fulfilment_address_name');
            $table->string('fulfilment_address_street_1');
            $table->string('fulfilment_address_street_2');
            $table->string('fulfilment_address_street_3');
            $table->string('fulfilment_address_postalCode');
            $table->string('fulfilment_address_city');
            $table->string('fulfilment_address_stateOrRegion');
            $table->string('fulfilment_address_country');
            $table->string('fulfilment_address_country_code');
            $table->string('fulfilment_phoneNumber');
            $table->unsignedTinyInteger('sent_to_supplier');
            $table->timestamp('sent_to_supplier_at')->nullable();
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
        Schema::drop('packages');
    }
}
