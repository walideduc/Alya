<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmazonCategoriesCommissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amazon_categories_commissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category',255);
            $table->unsignedInteger('percentage')->defalut('20');
            $table->unsignedInteger('min')->nullable()->comment('the min commission by article');
            $table->dateTime('valid_until')->default('2020-00-00 00:00:00');
            $table->timestamps();
        });

        DB::table('amazon_categories_commissions')->insert(array(
            array('category' => 'Accessoires pour appareils Amazon', 'percentage' => 45, 'min' => 50 ),
            array('category' => 'Livres, Musique, Vidéos, DVD', 'percentage' =>15 , 'min' => null),
            array('category' => 'Automobile & Moto', 'percentage' => 15, 'min' => 50),
            array('category' => 'Ordinateurs', 'percentage' => 7, 'min' => 50),
            array('category' => 'Accessoires High-Tech', 'percentage' => 12, 'min' => 50),
            array('category' => 'High-Tech', 'percentage' => 7, 'min' => 50),
            array('category' => 'Ordinateurs, Périphériques PC et Téléviseurs', 'percentage' => 5, 'min' => 50),
            array('category' => 'Bricolage', 'percentage' => 12, 'min' => 50),
            array('category' => 'Bijoux', 'percentage' => 20, 'min' => 150),
            array('category' => 'Gros Électroménager', 'percentage' => 7, 'min' => 50),
            array('category' => 'Instruments de musique & Sono', 'percentage' => 12, 'min' => 50),
            array('category' => 'Logiciels', 'percentage' => 15, 'min' => null),
            array('category' => 'Pneus', 'percentage' => 10, 'min' => 50),
            array('category' => 'Jeux Vidéos', 'percentage' => 15, 'min' => null),
            array('category' => 'Consoles de Jeux-Vidéo', 'percentage' => 8, 'min' => null),
            array('category' => 'Montres', 'percentage' => 15, 'min' => 150),
            array('category' => 'Toutes les autres catégories', 'percentage' => 15, 'min' => 50),
    ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::drop('amazon_categories_commissions');
    }
}
