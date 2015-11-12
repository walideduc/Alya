<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmazonInventory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amazon_inventory', function (Blueprint $table) {
            $table->integer('sku');
            $table->string('asin',25);
            $table->float('price');
            $table->tinyInteger('quantity')->nullable();
            $table->string('countryCode',4);
            $table->string('reportId',25);
            $table->timestamp('created_at')->default(\Illuminate\Support\Facades\DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::drop('amazon_inventory');
    }
}
