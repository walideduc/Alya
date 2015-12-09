<?php

namespace Alyya\Http\Controllers;

use Alyya\Models\Site\Category;
use Alyya\Models\Site\Product;
use Illuminate\Http\Request;

use Alyya\Http\Requests;
use Alyya\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class IndexController extends Controller
{
    public function index(){
        $products = Category::find(1)->products()->take(6)->get();
        $categories_products[]= ['category' => 'DECO - LINGE - LUMINAIRE','products' => $products];
        $products = Category::find(34)->products()->take(6)->get();
        $categories_products[]= ['category' => 'JOUET' , 'products'=> $products];
        $products = Category::find(16)->products()->take(6)->get();
        $categories_products[]= ['category' => 'VIN - ALCOOL - LIQUIDES' , 'products' => $products];
        $products = Category::find(8)->products()->take(4)->get();
        $categories_products[]= ['category' => 'BRICOLAGE - OUTILLAGE - QUINCAILLERIE','products' => $products];
        return view('front.index',['categories_products' => $categories_products]);
    }










    public function catalogue(){
        $products = Product::where('id','>','0')->paginate(15);
        return view('front.catalogue',['products' => $products]);
    }

    public function category($slug,$id){
        $products = Category::find($id)->products()->paginate(15);
        return view('front.categories',['products' => $products]);
    }public function cart(){
        return view('front.cart');
    }
    public function checkout(){
        return view('front.checkout');
    }
    public function about(){
        return view('front.about');
    }
    public function contact(){
        return view('front.contact');
    }
    public function typography(){
        return view('front.typography');
    }
    public function product($slug_id){
        $slug_id_Array = (explode('_',$slug_id));
        $slug = $slug_id_Array[0];
        $id = $slug_id_Array[1];
        $product= Product::where('id','=',$id)->first();
//        $product->options = 1 ;
//        $product->checkbox = 1 ;
//        $product->radio = 1 ;
        $product->detail = 1 ;
        $product->review = 1 ;
        $product->new = 1 ;
        $product->occasion = 1 ;
        $lastCategoryWithproducts = $product->categories->last(function($key , $category ){
            return $category->products->count() > 1 ;
        });
        if(!is_null($lastCategoryWithproducts)){ //the product is not categorized
            $related_products = $lastCategoryWithproducts->products()->where('id','<>', $product->id)->take(3)->get() ;
            if($related_products->isEmpty()){ // the product is a alone in this category .
                $related_products = [] ;
            }
        }else{
            $related_products = [] ;
        }
//        $categories = $product->categories->sortBy('id');
//        dd($categories->toArray());
        return view('front.product',['product' => $product ,'related_products' => $related_products]);
    }


    public function categories(){
        $categoriesLevel_1 = Category::whereNull('parent')->get();
        return view('front.menu_categories',['categoriesLevel_1' => $categoriesLevel_1]);
    }
    public function compare(){
        return view('front.compare');
    }
    public function login(){
        return view('front.login');
    }
    public function register(){
        return view('front.register');
    }

}
