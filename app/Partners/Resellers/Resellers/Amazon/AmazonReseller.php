<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 05/09/15
 * Time: 15:31
 */

namespace alyya\Partners\Resellers\Resellers\Amazon;


use alyya\Models\AmazonProduct;
use alyya\Models\Product;
use alyya\Partners\Resellers\AbstractReseller;
use alyya\Partners\Resellers\Resellers\Amazon\Reports\Report;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use alyya\Partners\Resellers\Resellers\Amazon\Feeds\Feed ;

class AmazonReseller extends AbstractReseller {

    public $feed ;
    public $report ;

    static $euroVersCentimes = 100;
    static $marge = 0.07 ; // 7%
    static $comm = 0.20 ; // 15%
    //static $expotrtation_hors_taxe = 5.42 ; // 5.41666666667= 6.5 /1.2 ;
    static $transport_cost_ht = 9.5 ; // COL : Colissimo avec signature (< 1 000 commandes)
    static $tva_general = 0.20 ; // utilis� pour le frais de transport toutes chages comprises .
    static $transport_invoiced_ht = 0 ;  // 0 pour le moment


    public function __construct(Feed $feed,Report $report){
        $this->feed = $feed;
        $this->report = $report ;
    }

    public function updateCatalog(){
        $productModel = new Product();
        //$products = $productModel::updateAmazonCatalog()->get();
        $products = $productModel->take(40000)->get(); //for testing
        $amazonModel = new AmazonProduct();
        $now = Carbon::now()->toDateTimeString();
        foreach($products as $product){
            //dd($product->toArray());
            list($price ,$coefficient) = self::getPrice($product,false);
            if(is_null($existingAmazonModel = $amazonModel::where('sku',$product->id)->first())){
                // I will insert the product
                $amazonModel::create([
                    'sku' => $product->id ,
                    'existence' => 0 ,
                    'locked' => 0 ,
                    'category_id' => $product->category_id ,
                    'ref_type' => $product->ref_type ,
                    'ref_value' => $product->ref_value ,
                    'name' => $product->name ,
                    'brand' => $product->brand ,
                    'description' => $product->description ,
                    'manufacturer' => $product->manufacturer ,
                    'item_type' => 'item_type' ,
                    'quantity' => $product->quantity,
                    'price' => $price ,
                    'coefficient' => $coefficient ,
                    'price_ttc_supplier' => $product->price_ttc ,
                    'image_url' => $product->image_url ,
                    'data_changed_at' => $now,
                ]);
            }else
            {
                // I will update the product .
                $updateArray =  [
                    'category_id' => $product->category_id ,
                    'ref_type' => $product->ref_type ,
                    'ref_value' => $product->ref_value ,
                    'name' => $product->name ,
                    'brand' => $product->brand ,
                    'description' => $product->description ,
                    'manufacturer' => $product->manufacturer ,
                    'item_type' => 'item_type' ,
                    'quantity' => $product->quantity,
                    'price' => $price ,
                    'coefficient' => $coefficient ,
                    'price_ttc_supplier' => $product->price_ttc ,
                    'image_url' => $product->image_url ,
                    'price_changed_at' => $now,
                    'stock_changed_at' => $now,
                    'image_changed_at' => $now,
                ];
                if (!$existingAmazonModel->existence) // If we have the product but existence is 0 , it may that the creation of the product was failed and we want to try again .
                    $updateArray['data_changed_at'] =  $now;
                $amazonModel::where('sku',$product->id)->update($updateArray);
            }
        }
    }

    public static function getPrice($product,$backOffiece){

        $product->marge = self::getMarge($product);
        $product->comm = self::getCommission($product)/100;
        $transport_cost_ht = self::get_transport_cost_ht(); // 9.5 invoiced by cdiscountPro
        $transport_invoiced_ht = self::get_transport_invoiced_ht(); // (0 pour le moment ) , ce que on va facturer pour gagner encore plus je pense
        $tva_general = self::$tva_general ;
        $product->purchase_price_ht     = $product->price_ht + $product->eco_tax / ( 1 + $tva_general ) ;
        $product->numerator =  ( $product->purchase_price_ht + $transport_cost_ht + $transport_invoiced_ht * ( 1 - $product->comm * ( 1 + $tva_general )) ) ;
        $product->denominator = ( 1 - $product->marge - $product->comm * (1 + $tva_general) ) ;
        $product->selling_price_ht = $product->numerator / $product->denominator ;
        $product->amazon_commission_ht = $product->selling_price_ht * $product->comm;
        $product->amazon_commission_ttc = $product->selling_price_ht * $product->comm * (1 + $tva_general) ;
        $product->cost_price_ht = $product->numerator +  $product->selling_price_ht * $product->comm * (1 + $tva_general)  ; //prix de revient
        $product->vat_rate_dicimal = $product->vat_rate /100 ;
        $product->selling_price_ttc = $product->selling_price_ht * (1 +  $product->vat_rate_dicimal );
        $product->cost_price_ttc = $product->cost_price_ht * (1 +  $product->vat_rate_dicimal );
        $product->tva_product = $product->vat_rate_dicimal ;
        $product->tva_general = $tva_general;
        $transport_cost_ttc = $transport_cost_ht * (1 + $tva_general) ;
        $product->coeff =  ( $product->selling_price_ttc - $transport_cost_ttc ) /  $product->purchase_price_ht  ;
        //dd($product->toArray());
        if($backOffiece){
            return $product;
        }
        return [$product->selling_price_ttc, $product->coeff];
    }


    private static function getMarge($product) {
        $product ;
        //dd($product->category_id);
        $arrayMarge = [
                25 => 0.07,
                24 => 0.07,
                23 => 0.07,
                22 => 0.07,
                21 => 0.07,
                20 => 0.07,
                19 => 0.07,
                18 => 0.07,
                17 => 0.20, // PUERICULTURE (6
                16 => 0.07,
                15 => 0.07, // INFORMATIQUE (5
                14 => 0.07,
                13 => 0.07,
                12 => 0.07,
                11 => 0.07,
                10 => 0.07,
                9 => 0.07,
                8 => 0.07,
                7 => 0.15, // JOUET (NEW) (4
                6 => 0.07,
                5 => 0.07,
                4 => 0.20, // Alcool   (1
                3 => 0.07,
                2 => 0.15, // BRICOLAGE - OUTILLAGE - QUINCAILLERIE (3
                1 => 0.20, // DECO - LINGE - LUMINAIRE   (2
    ];
        if(isset($arrayMarge[$product->category_id])){
            return $arrayMarge[$product->category_id] ;
        }
        return self::$marge;
    }

    private static function getCommission($product){
        $commissionInfo = DB::table('categories')->join('amazon_categories_commissions','categories.amazon_categories_commission_id','=','amazon_categories_commissions.id')->select('categories.id' , 'amazon_categories_commissions.percentage' , 'amazon_categories_commissions.min','amazon_categories_commissions.min','amazon_categories_commissions.valid_until')->where('categories.id',$product->category_id)->first();
    /*    +"id": "17"
        +"percentage": "15"
        +"min": "50"
        +"valid_until": "2020-00-00 00:00:00"*/
        // for the moment , we have to consider the min info , the min commission by article .

        //return 0; // pricing alya
        return $commissionInfo->percentage;
    }

    private static function get_transport_cost_ht() {
        return self::$transport_cost_ht;
    }

    private static function get_transport_invoiced_ht() {
        return self::$transport_invoiced_ht ;
    }




    public static function getPriceFromFormula($prix_achat_ht , $sku = null , $eco_taxe , $vat_rate  , $supplier_id ,$supplier_ref , $resellers_id){
        $marge = self::getMarge();
        $comm = self::getCommession($supplier_id ,  $supplier_ref , $resellers_id );
        $tva_general = self::$tva_general ;
        $expotrtation_ht = self::getExpotrtationHorsTaxe(); // celle de cdiscount
        $Transport_facture_ht = self::get_Transport_facture_ht();
        $prix_achat_avec_eco_taxe_inclu_ht = $prix_achat_ht + $eco_taxe / ( 1 + $tva_general ) ; // pour avoir le cout ttc d'eco_taxe => $eco_taxe / ( 1 + self::$tva_general )
        //$prix_vente_ht = ($prix_achat_avec_eco_taxe_inclu_ht + $expotrtation_ht + $Transport_facture_ht * ( 1 - $comm * ( 1 + $tva_general ))   ) / ( 1 - $marge - $comm / (1 + $tva_general) ) ;
        $prix_vente_ht = (  $prix_achat_avec_eco_taxe_inclu_ht + $expotrtation_ht + $Transport_facture_ht * ( 1 - $comm * ( 1 + $tva_general ))   ) / ( 1 - $marge - $comm * (1 + $tva_general) ) ;
        $prix_vente_ttc = ( 1 + $vat_rate ) * $prix_vente_ht ; // vat_rate celle de produit
        //$coeff = ( $prix_vente_ttc - $expotrtation_ht * (1 + $tva_general) ) / $prix_achat_avec_eco_taxe_inclu_ht ;
        $expotrtation_ttc = $expotrtation_ht * (1 + $tva_general);
        $coeff = ( $prix_vente_ttc - $expotrtation_ttc ) / $prix_achat_avec_eco_taxe_inclu_ht ;
        debug('<font size="3" color="red">sku : </font>' .  $sku .'  <br/><font size="3" color="red">supplier_id : </font>' .$supplier_id .'  <br/><font size="3" color="red">supplier_ref : </font>' .$supplier_ref.' <br/><font size="3" color="red">marge : </font>'.$marge.' <br/><font size="3" color="red">comm : </font>'.$comm .' <br/><font size="3" color="red">tva_general : </font>'.$tva_general.' <br/><font size="3" color="red">Expotrtation_ht </font>: '.$expotrtation_ht.' <br/><font size="3" color="red">Transport_facture_ht :</font> '.$Transport_facture_ht.'  <br/><font size="3" color="red">vate_rate:</font> ' .$vat_rate. '  <br/><font size="3" color="red">eco_taxe :</font> ' . $eco_taxe
            .' <br/><font size="3" color="red">expotrtation_ttc :</font>'.$expotrtation_ttc.' <br/><font size="3" color="red">coeff :</font>'.$coeff.' <br/><font size="3" color="red">achat_ht :</font> '. $prix_achat_ht.' <br/><font size="3" color="red">prix_achat_avec_eco_taxe_inclu_ht :</font> '.$prix_achat_avec_eco_taxe_inclu_ht .' <br/><font size="3" color="red">prix_vente_ttc :</font>'.$prix_vente_ttc);
        return array($prix_vente_ttc,$coeff) ;

    }


    public  static function getCommession_old( $supplier_id ,  $supplier_ref , $resellers_id  ) {
        //$comm = db::select_one_field('commission_supplier_sku', 'comm' , " supplier_sku LIKE '$supplier_ref' AND supplier_id = $supplier_id AND reseller_id = $resellers_id ") ;
        //debug($comm);
        if (isset($comm)) {
            return $comm;
        }
        // $sql = " INSERT INTO `commission_anomali`( `supplier_id`, `supplier_ref`, `resellers_id`) VALUES ( $supplier_id,'$supplier_ref',$resellers_id)" ;
        // db::query($sql);
        return self::$comm;

    }




}