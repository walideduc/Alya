<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCdiscountProProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cdiscount_pro_products', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('ref_sku', 25);
            $table->string('ean', 15);
            $table->string('categorie_1', 500)->nullable();
            $table->string('categorie_2', 500)->nullable();
            $table->string('categorie_3', 500)->nullable();
            $table->string('categorie_4', 500)->nullable();
            $table->string('mode_livraison', 50)->nullable();
            $table->string('marque', 500)->nullable();
            $table->string('libelle', 500)->nullable();
            $table->text('description_principale')->nullable();
            $table->float('prix_barre')->nullable();
            $table->float('prix_ht')->nullable();
            $table->float('prix_ttc')->nullable();
            $table->float('eco_taxe')->nullable();
            $table->float('taux_tva')->nullable();
            $table->string('liens_images',1500)->nullable();
            $table->unsignedInteger('poids')->nullable();
            $table->unsignedInteger('quantity')->nullable();
            $table->boolean('is_new')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::drop('cdiscount_pro_products');
    }
}
