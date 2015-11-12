<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TestJobs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('note_1');
            $table->string('note_2');
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
        //Schema::drop('test_jobs');
    }
}
