<?php

namespace Alyya\Http\Controllers;

use Alyya\Partners\Resellers\Amazon\AmazonReseller;
use Illuminate\Http\Request;

use Alyya\Http\Requests;
use Alyya\Http\Controllers\Controller;
use Alyya\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        ini_set('max_execution_time', 20000); //300 seconds = 5 minutes
        $productModel = new Product();
        //$products = $productModel->skip(10)->take(500)->groupBy('category_id')->groupBy('vat_rate')->orderBy('category_id', 'desc')->get();
        //$products = $productModel->take(50)->groupBy('category_id')->orderBy('category_id', 'desc')->get();
        $products = $productModel->take(40000)->get();
        //dd($products);
        //dd($products[0]->toArray());
        //dd(sizeof($products));
        foreach($products as $product){
            AmazonReseller::getPrice($product,true);
            $table = 'pricing_alya';// Amazon commission 0
            $table = 'pricing_amazon';
            DB::table($table)->insert(
                [
                    'sku' => $product->id,
                    'category_id' => $product->category_id,
                    'supplier_id' => $product->supplier_id,
                    'price_ttc' => $product->price_ttc,
                    'price_ht' => $product->price_ht,
                    'eco_tax' => $product->eco_tax,
                    'marge' => $product->marge,
                    'reseller_id' => 1,
                    'comm' => $product->comm,
                    'purchase_price_ht' => $product->purchase_price_ht,
                    'selling_price_ht' => $product->selling_price_ht,
                    'amazon_commission_ttc' => $product->amazon_commission_ttc,
                    'amazon_commission_ht' => $product->amazon_commission_ht,
                    'cost_price_ht' => $product->cost_price_ht,
                    'vat_rate_dicimal' => $product->vat_rate_dicimal,
                    'selling_price_ttc' => $product->selling_price_ttc,
                    'coeff' => $product->coeff,
                    'cost_price_ttc' => $product->cost_price_ttc,
                    'tva_product' => $product->tva_product,
                    'tva_general' => $product->tva_general,
                ]
            );
        }
        //dd($products[0]->toArray());




        dd(sizeof($products));
        return view('product.show',['products' => $products]);
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
