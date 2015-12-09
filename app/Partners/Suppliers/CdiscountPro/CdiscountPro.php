<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 27/08/15
 * Time: 16:29
 */
namespace Alyya\Partners\Suppliers\CdiscountPro;
use Alyya\Models\Category;
use Alyya\Models\CdiscountProCategory;
use Alyya\Models\CdiscountProProduct;
use Alyya\Models\Product;
use Alyya\Partners\Suppliers\AbstractSupplier ;
use Illuminate\Support\Facades\DB;
use Psy\Exception\ErrorException;

class CdiscountPro extends AbstractSupplier  {

    // Catalog
    protected $FTP_HOST = 'kfina.net' ;
    protected $FTP_USER = 'cdiscount' ;
    protected $FTP_PASSWORD = 'cdc' ;
    protected $supplier_id = 1 ;
    static $quantity = 20 ;


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
        $i = 0 ;
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
                    'quantity' => self::$quantity ,
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
                    'quantity' => self::$quantity ,
                    'is_new' => 0,
                    'category_id' => $categoryId,
                ]);
            }
            $i++;
            /*if($i > 50)
                dd($cdicountProProductModel->toArray());*/
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
            $kfina_category_id = $productModel->matchCategoryCdiscountPro($cdiscountProProduct->category_id);  // to know the Amazon commission , because I decided to organise the commission according kfina_categories
            $productModel::updateOrCreate(
                ['supplier_id' => $this->supplier_id, 'supplier_ref' => $cdiscountProProduct->ref_sku] ,
                [
                    'supplier_id' => $this->supplier_id,
                    'supplier_ref' => $cdiscountProProduct->ref_sku,
                    'category_id'=> $kfina_category_id,
                    'ref_type' => 'ean',
                    'ref_value' => $cdiscountProProduct->ean,
                    'name' => $cdiscountProProduct->libelle,
                    'brand' => $cdiscountProProduct->marque,
                    'manufacturer' => isset($cdiscountProProduct->manufactuer) ? $cdiscountProProduct->manufactuer : $cdiscountProProduct->marque ,
                    'description' => $cdiscountProProduct->description_principale,
                    'slug'=> str_slug($cdiscountProProduct->libelle, "-"),
                    'quantity' => $cdiscountProProduct->quantity,
                    'price_ttc' => $cdiscountProProduct->prix_ttc ,//is->priceTtcForProduct($cdiscountProProduct),
                    'price_ht' => $cdiscountProProduct->prix_ht ,
                    'eco_tax' => $cdiscountProProduct->eco_taxe,
                    'vat_rate' => $cdiscountProProduct->taux_tva,
                    'image_url' => $cdiscountProProduct->liens_images,

                ] );
            //dd($cdiscountProProduct->toArray());
        }
    }

    public function alyya_firstFeed(){
        $cdiscountProProducts = CdiscountProProduct::all();
        $productModel= new Product();
        foreach($cdiscountProProducts as $cdiscountProProduct){
            //dd($cdiscountProProduct->toArray());

            ###################################  BEGIN Insert categories
            $category_1 = Category::where('name', $cdiscountProProduct->categorie_1)->first();
            if(is_null($category_1)){// if model not found , first return null
                $category_1 = new Category() ;
                $category_1->name = $cdiscountProProduct->categorie_1;
                $category_1->save();
            }
            $category_2 = Category::where('name', $cdiscountProProduct->categorie_2)->where('parent', $category_1->id)->first();
            if(is_null($category_2)){
                $category_2 = new Category() ;
                $category_2->name = $cdiscountProProduct->categorie_2;
                $category_2->parent = $category_1->id;
                $category_2->save();
            }
            $category_3 = Category::where('name', $cdiscountProProduct->categorie_3)->where('parent', $category_2->id)->first();
            if(is_null($category_3)){
                $category_3 = new Category() ;
                $category_3->name = $cdiscountProProduct->categorie_3;
                $category_3->parent = $category_2->id;
                $category_3->save();
            }
            $category_4 = Category::where('name', $cdiscountProProduct->categorie_4)->where('parent', $category_3->id)->first();
            if(is_null($category_4)){
                $category_4 = new Category() ;
                $category_4->name = $cdiscountProProduct->categorie_4;
                $category_4->parent = $category_3->id;
                $category_4->save();
            }
            ###################################  END Insert categories
            ###################################  BEGIN Insert product
            $product = $productModel::updateOrCreate(
                ['supplier_id' => $this->supplier_id, 'supplier_ref' => $cdiscountProProduct->ref_sku] ,
                [
                    'supplier_id' => $this->supplier_id,
                    'supplier_ref' => $cdiscountProProduct->ref_sku,
                    'ref_type' => 'ean',
                    'ref_value' => $cdiscountProProduct->ean,
                    'name' => $cdiscountProProduct->libelle,
                    'brand' => $cdiscountProProduct->marque,
                    'manufacturer' => isset($cdiscountProProduct->manufactuer) ? $cdiscountProProduct->manufactuer : $cdiscountProProduct->marque ,
                    'description' => $cdiscountProProduct->description_principale,
                    'slug'=> str_slug($cdiscountProProduct->libelle, "-"),
                    'quantity' => $cdiscountProProduct->quantity,
                    'price_ttc' => $cdiscountProProduct->prix_ttc ,//is->priceTtcForProduct($cdiscountProProduct),
                    'price_ht' => $cdiscountProProduct->prix_ht ,
                    'eco_tax' => $cdiscountProProduct->eco_taxe,
                    'vat_rate' => $cdiscountProProduct->taux_tva,
                    'image_url' => $cdiscountProProduct->liens_images,

                ] );


            try{
                DB::table('category_product')->insert([
                    ['category_id' => $category_1->id  , 'product_id' => $product->id  , 'position' => 1 ] ,
                    ['category_id' => $category_2->id  , 'product_id' => $product->id  , 'position' => 1 ] ,
                    ['category_id' => $category_3->id  , 'product_id' => $product->id  , 'position' => 1 ] ,
                    ['category_id' => $category_4->id  , 'product_id' => $product->id  , 'position' => 1 ] ,
                ]);
            }catch (\Illuminate\Database\QueryException $e){ // There is a unique(category_id,product_id) constraint
                //dd($e->getMessage());
            }
            try{
                DB::table('categories_code_bare')->insert([
                    ['category_1_id' => $category_1->id  , 'category_1' => $category_1->name ,'category_2_id' => $category_2->id  , 'category_2' => $category_2->name  ,'category_3_id' => $category_3->id  , 'category_3' => $category_3->name  ,'category_4_id' => $category_4->id  , 'category_4' => $category_4->name , 'barcode_type' => 'ean', 'barcode_value' => $cdiscountProProduct->ean ] ,
                ]);
            }catch (\Illuminate\Database\QueryException $e){
                echo $e->getMessage();
            }
        }

    }

}