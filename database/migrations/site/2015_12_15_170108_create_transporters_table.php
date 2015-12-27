<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransportersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transporters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('shipping_method');
            $table->string('shipping_delay');
            $table->string('cost_ht');
            $table->unsignedTinyInteger('active')->default('0');
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::table('transporters')->insert([
            [ 'name' =>  'CDS', 'shipping_method' => 'CDS : Colissimo sans signature' ,'shipping_delay' =>'5 jours ouvrés maximum' , 'cost_ht' => '7', 'active'=>1 ],
            [ 'name' =>  'COL', 'shipping_method' => 'COL : Colissimo avec signature' ,'shipping_delay' =>'5 jours ouvrés maximum' , 'cost_ht' => '9.5' , 'active'=>1 ],
            [ 'name' =>  'TNT', 'shipping_method' => 'TNT : Express avec signature' ,'shipping_delay' =>'3 jours ouvrés maximum', 'cost_ht' => '15' , 'active'=>1 ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('transporters');
    }
}
