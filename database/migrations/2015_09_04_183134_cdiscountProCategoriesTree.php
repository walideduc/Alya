<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CdiscountProCategoriesTree extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cdiscount_pro_categories_tree', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category_1',500);
            $table->string('category_2',500);
            $table->string('category_3',500);
            $table->string('category_4',500);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cdiscount_pro_categories_tree'); //
    }
}
