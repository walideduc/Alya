<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 05/09/15
 * Time: 15:31
 */

namespace Alyya\Partners\Resellers\Alyya;


use Alyya\Models\AlyyaProduct;
use Alyya\Models\Product;
use Alyya\Models\Site\Product as SiteProduct;
use Alyya\Models\Site\Category as SiteCategory;
use Alyya\Partners\Resellers\AbstractReseller;
use Carbon\Carbon;
use Illuminate\Database\QueryException;

class AlyyaReseller extends AbstractReseller {

    public function __construct(){
    }

    public function updateCatalog(){
        $products = Product::updateAlyyaCatalog()->get();
        //dd(sizeof($products));
        foreach($products as $product){
            list($price ,$coefficient) = self::getPrice($product,false);
            ##################################### Begin Product treatment
            if(is_null($siteProduct = SiteProduct::where('id',$product->id)->first())){
                // I will insert the product
                $siteProduct = SiteProduct::create([
                    'id' => $product->id ,
                    'name' => $product->name ,
                    'brand' => $product->brand ,
                    'manufacturer' => $product->manufacturer ,
                    'description' => $product->description ,
                    'slug' => $product->slug ,
                    'slug_id' => $product->slug.'_'.$product->id ,
                    'quantity' => $product->quantity,
                    'price' => $price ,
                    'eco_tax' => $product->eco_tax ,
                    'coefficient' => $coefficient ,
                    'image_url' => $product->image_url ,
                ]);
                $siteProduct = SiteProduct::where('id',$product->id)->first(); // Before I but this line Here ,I always found a product_id = 0 in category_product table ?!
                //dd($siteProduct);
            }else{
                //dd($siteProduct);
                // I will update the product .
                $updateArray =  [
                    'name' => $product->name ,
                    'brand' => $product->brand ,
                    'description' => $product->description ,
                    'manufacturer' => $product->manufacturer ,
                    'quantity' => $product->quantity,
                    'price' => $price ,
                    'eco_tax' => $product->eco_tax ,
                    'coefficient' => $coefficient ,
                    'image_url' => $product->image_url ,
                ];
                $siteProduct->update($updateArray);
            }
            ##################################### End Product treatment

            ##################################### Begin Categories treatment
//            foreach ( $product->categories as $category ){
//                try{ // $siteCategory->id is primary key
//                    $siteCategory = new SiteCategory();
//                    $siteCategory->id = $category->id ;
//                    $siteCategory->name = $category->name ;
//                    $siteCategory->parent = $category->parent ;
//                    $siteCategory = $siteCategory->save();
//                }catch (QueryException $e){
//
////                    $siteCategory = SiteCategory::find($siteCategory->id)->first();
////                    dd($siteCategory);
//
//                }
//                try{ // (category->id,product_id) unique key
//                    $siteProduct->categories()->attach($siteCategory->id ,['position' => 1]);
//                }catch (QueryException $e){
//                    //dd($e->getMessage());
//                }
//            }
            ##################################### Begin Categories treatment
        }
        return sizeof($products);
    }

    public static function getPrice($product,$backOffiece){
        //dd($product);
        $product->selling_price_ttc = $product->price_ttc + 0.07 * $product->price_ttc + $product->eco_tax ;
        $product->coeff = 1 ;
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

        return 1;
    }

    private static function get_transport_cost_ht() {
    }

    private static function get_transport_invoiced_ht() {
    }

}