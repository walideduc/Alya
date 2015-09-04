<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 27/08/15
 * Time: 16:29
 */
namespace App\Partners\Suppliers\Suppliers\CdiscountPro;
use App\Models\CdiscountProCategory;
use App\Models\CdiscountProProduct;
use App\Models\Product;
use App\Partners\Suppliers\AbstractSupplier ;
use Psy\Exception\ErrorException;

class CdiscountPro extends AbstractSupplier  {

    // Catalog
    protected $FTP_HOST = 'kfina.net' ;
    protected $FTP_USER = 'cdiscount' ;
    protected $FTP_PASSWORD = 'cdc' ;
    protected $supplier_id = 1 ;
    //protected const $quantity = 20 ;


    protected $referenceList = array(
    'CATALOG' =>  array(    'local_dir' 		=> '/home/src/kfina-market/storage/',
        'local_archive_dir' => '/home/cdiscount_pro/archive/catalog/',
        'remote_dir' 		=> '/home/cdiscount/remote_server/',
        'file_name' 		=> 'catalogue_CdiscountPro.CSV',
    ));

    // Orders
/*    const ORDER_FTP_USER = 'sananttechnologies1' ;
    const ORDER_FTP_PASSWORD = '5y313KHJ' ;*/

 /*   const LOCAL_INBOX_DIR = 'cdiscount_pro/inbox/' ;
    const LOCAL_OUTBOX_DIR = 'cdiscount_pro/outbox/' ;*/



    public function getCatalog(){
        return  $this->ftp_load();
    }
    public function parseCatalog(){
        $fileName = $this->referenceList['CATALOG']['file_name'] ;
        $filePath = $this->referenceList['CATALOG']['local_dir'] . $fileName ;
        $fp = fopen($filePath, 'r') ;
        if(!$fp)
        {
            return -2 ;
        }

        $fieldNames = array('ref_sku',
            'ean',
            'categorie_1',
            'categorie_2',
            'categorie_3',
            'categorie_4',
            'mode_livraison',
            'marque',
            'libelle',
            'description_principale',
            'prix_barre',
            'prix_ht',
            'prix_ttc',
            'eco_taxe',
            'taux_tva',
            'liens_images',
            'poids');

        $cdicountProProductModel = new CdiscountProProduct();
        // Rest table
        $cdicountProProductModel::resetTable()->update(['quantity' => 0  , 'is_new' => 0]);

        $entete = $this->readline1($fp, $fieldNames);
        while($dataLine = $this->readline1($fp, $fieldNames))
        {
            $categoryId = $this->getCdiscountProCategory_id($dataLine->categorie_1);
            if( is_null($cdicountProProductModel::productAlreadyExist($dataLine->ref_sku)->first()) ){
                // Product does not exist , I will create it .
                $cdicountProProductModel::create([
                    'ref_sku' => $dataLine->ref_sku,
                    'ean' => $dataLine->ean,
                    'categorie_1' => $dataLine->categorie_1,
                    'categorie_2' => $dataLine->categorie_2,
                    'categorie_3' => $dataLine->categorie_3,
                    'categorie_4' => $dataLine->categorie_4,
                    'mode_livraison' => $dataLine->mode_livraison,
                    'marque' => $dataLine->marque,
                    'libelle' => $dataLine->libelle,
                    'description_principale' => $dataLine->description_principale,
                    'prix_barre' => $dataLine->prix_barre,
                    'prix_ht' => $dataLine->prix_ht,
                    'prix_ttc' => $dataLine->prix_ttc,
                    'eco_taxe' => $dataLine->eco_taxe,
                    'taux_tva' => $dataLine->taux_tva,
                    'liens_images' => $dataLine->liens_images,
                    'poids' => $dataLine->poids,
                    'quantity' => 20 ,
                    'is_new' => 1,
                    'category_id' => $categoryId,
                ]);
            }else{
                // Product exist , I will update it .
                $cdicountProProductModel::where('ref_sku', $dataLine->ref_sku)->update([
                    'ean' => $dataLine->ean,
                    'categorie_1' => $dataLine->categorie_1,
                    'categorie_2' => $dataLine->categorie_2,
                    'categorie_3' => $dataLine->categorie_3,
                    'categorie_4' => $dataLine->categorie_4,
                    'mode_livraison' => $dataLine->mode_livraison,
                    'marque' => $dataLine->marque,
                    'libelle' => $dataLine->libelle,
                    'description_principale' => $dataLine->description_principale,
                    'prix_barre' => $dataLine->prix_barre,
                    'prix_ht' => $dataLine->prix_ht,
                    'prix_ttc' => $dataLine->prix_ttc,
                    'eco_taxe' => $dataLine->eco_taxe,
                    'taux_tva' => $dataLine->taux_tva,
                    'liens_images' => $dataLine->liens_images,
                    'poids' => $dataLine->poids,
                    'quantity' => 20 ,
                    'is_new' => 0,
                    'category_id' => $categoryId,
                ]);
            }
        }
        // TODO étape n: fin de transaction
        return 1 ;

    }

    private function readLine1($fp, $fieldNames)
    {
        try{
            $res = @fgetcsv($fp, 0, ';') ;
            if(!$res)
                return false ;
            $line = new \stdClass() ;
            foreach($fieldNames as $id => $fieldName)
            {
                $line->$fieldName = utf8_encode(trim($res[$id])) ; // Les fichiers sont encodés en ISO-8859-1, mais notre système accèpte uniquement du UTF-8
            }
        }catch (\ErrorException $e){
            echo $e->getMessage();
            dd($res);
        }

        return $line ;
    }
    public function getCdiscountProCategory_id($category1Name){
        $cdiscountProCategoryModel =  new CdiscountProCategory();
        if(is_null($categoryId = $cdiscountProCategoryModel::where('name',$category1Name)->first())){
            $categoryId = $cdiscountProCategoryModel::create(['name'=>$category1Name]);
        }
        return $categoryId->id;
    }

    public function actualiseProductsTable(){
        $cdiscountProProductModel =  new CdiscountProProduct();
        $cdiscountProProducts = $cdiscountProProductModel::actualiseProductsTable()->get();
        $productModel = new Product();
        foreach($cdiscountProProducts as $cdiscountProProduct){
            $productModel::updateOrCreate(['supplier_id' => $this->supplier_id, 'supplier_ref' => $cdiscountProProduct->ref_sku] ,
                [
                    'supplier_id' => $this->supplier_id,
                    'supplier_ref' => $cdiscountProProduct->ref_sku,
                    'type_id' => 'ean',
                    'type_value' => $cdiscountProProduct->ean,
                    'name' => $cdiscountProProduct->libelle,
                    'brand' => $cdiscountProProduct->marque,
                    'manufacturer' => isset($cdiscountProProduct->manufactuer) ? $cdiscountProProduct->manufactuer : $cdiscountProProduct->marque ,
                    'description' => $cdiscountProProduct->description_principale,
                    'quantity' => $cdiscountProProduct->quantity,
                    'price_ttc' => $cdiscountProProduct->prix_ttc ,//is->priceTtcForProduct($cdiscountProProduct),
                    'eco_tax' => $cdiscountProProduct->eco_taxe,
                    'vat_rate' => $cdiscountProProduct->taux_tva,
                    'image_url' => $cdiscountProProduct->liens_images,

                ] );
            //dd($cdiscountProProduct->toArray());
        }
    }
/*
    public static function getPriceFromFormula($prix_achat_ht , $sku = null , $eco_taxe , $vat_rate  , $supplier_id ,$supplier_ref , $resellers_id){
        $marge = self::getMarge();
        $comm = self::getCommession($supplier_id ,  $supplier_ref , $resellers_id );
        $tva_general = self::$tva_general ;
        $expotrtation_ht = self::getExpotrtationHorsTaxe(); // celle de cdiscount
        $Transport_facture_ht = self::get_Transport_facture_ht();
        $prix_achat_avec_eco_taxe_inclu_ht = $prix_achat_ht + $eco_taxe / ( 1 + $tva_general ) ; // pour avoir le cout ttc d'eco_taxe => $eco_taxe / ( 1 + self::$tva_general )
        //$prix_vente_ht = ($prix_achat_avec_eco_taxe_inclu_ht + $expotrtation_ht + $Transport_facture_ht * ( 1 - $comm * ( 1 + $tva_general ))   ) / ( 1 - $marge - $comm / (1 + $tva_general) ) ;
        $prix_vente_ht = ($prix_achat_avec_eco_taxe_inclu_ht + $expotrtation_ht + $Transport_facture_ht * ( 1 - $comm * ( 1 + $tva_general ))   ) / ( 1 - $marge - $comm * (1 + $tva_general) ) ;
        $prix_vente_ttc = ( 1 + $vat_rate ) * $prix_vente_ht ; // vat_rate celle de produit
        //$coeff = ( $prix_vente_ttc - $expotrtation_ht * (1 + $tva_general) ) / $prix_achat_avec_eco_taxe_inclu_ht ;
        $expotrtation_ttc = $expotrtation_ht * (1 + $tva_general);
        $coeff = ( $prix_vente_ttc - $expotrtation_ttc ) / $prix_achat_avec_eco_taxe_inclu_ht ;
        debug('<font size="3" color="red">sku : </font>' .  $sku .'  <br/><font size="3" color="red">supplier_id : </font>' .$supplier_id .'  <br/><font size="3" color="red">supplier_ref : </font>' .$supplier_ref.' <br/><font size="3" color="red">marge : </font>'.$marge.' <br/><font size="3" color="red">comm : </font>'.$comm .' <br/><font size="3" color="red">tva_general : </font>'.$tva_general.' <br/><font size="3" color="red">Expotrtation_ht </font>: '.$expotrtation_ht.' <br/><font size="3" color="red">Transport_facture_ht :</font> '.$Transport_facture_ht.'  <br/><font size="3" color="red">vate_rate:</font> ' .$vat_rate. '  <br/><font size="3" color="red">eco_taxe :</font> ' . $eco_taxe
            .' <br/><font size="3" color="red">expotrtation_ttc :</font>'.$expotrtation_ttc.' <br/><font size="3" color="red">coeff :</font>'.$coeff.' <br/><font size="3" color="red">achat_ht :</font> '. $prix_achat_ht.' <br/><font size="3" color="red">prix_achat_avec_eco_taxe_inclu_ht :</font> '.$prix_achat_avec_eco_taxe_inclu_ht .' <br/><font size="3" color="red">prix_vente_ttc :</font>'.$prix_vente_ttc);
        return array($prix_vente_ttc,$coeff) ;

    }

*/
}