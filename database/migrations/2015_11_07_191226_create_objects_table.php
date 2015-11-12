<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('objects', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id');
            $table->string('supplier_ref');
            $table->unsignedInteger('order_id');
            $table->unsignedInteger('package_id');
            $table->string('shop_item_id')->nullable();;
            $table->unsignedInteger('price_purchased_ht');
            $table->unsignedInteger('price_ttc');
            $table->unsignedInteger('vat_rate');
            $table->string('name');
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
        Schema::drop('objects');
    }
}
