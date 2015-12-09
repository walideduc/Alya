<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesCodeBareTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories_code_bare', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('category_1_id');
            $table->string('category_1');
            $table->unsignedInteger('category_2_id');
            $table->string('category_2');
            $table->unsignedInteger('category_3_id');
            $table->string('category_3');
            $table->unsignedInteger('category_4_id');
            $table->string('category_4');
            $table->string('barcode_type')->default('ean');
            $table->string('barcode_value');
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
        Schema::drop('categories_code_bare');
    }
}
