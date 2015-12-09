<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'IndexController@index');
Route::get('catalogue', 'IndexController@catalogue');
Route::get('cart', 'IndexController@cart');
Route::get('category/{slug}_{id}', 'IndexController@category')->where('slug', '^[1-9]\d*$')->where('id', '^[1-9]\d*$');
Route::get('categories', 'IndexController@categories');
Route::get('checkout', 'IndexController@checkout');
Route::get('about', 'IndexController@about');
Route::get('contact', 'IndexController@contact');
Route::get('typography', 'IndexController@typography');
Route::get('product/{slug_id}', [
    'as' => 'product', 'uses' => 'IndexController@product'
]);
Route::get('compare', 'IndexController@compare');
Route::get('login', 'IndexController@login');
Route::get('register', 'IndexController@register');

Route::group(['prefix' => 'cart'], function () {
    //Route::match(['get', 'post'],'add/{product_id?}', 'CartController@add');
    Route::post('add', 'CartController@add');
    Route::get('add', 'CartController@add');
});

//Route::get('add', function(){
//    $res = Cart::add(array(
//        array('id' => '293ad', 'name' => 'Product 1', 'qty' => 1, 'price' => 10.00),
//        array('id' => '4832k', 'name' => 'Product 2', 'qty' => 1, 'price' => 10.00, 'options' => array('size' => 'large'))
//    ));
//    return $res ;
//});



Route::get('pages', function () {
    return view('pages.index');
});
Route::get('blade', function () {
    return view('child',['name'=>'Walid','records' => 0]);
});


Route::get('/getcatalog', function () {
    echo ' url /getcatalog ';
/*    $exitCode = Artisan::call('supplier:getCatalog', [
        'supplier' => 'CdiscountPro'
    ]);
    return $exitCode;*/
});

Route::get('/parsecatalog', function () {
    $exitCode = Artisan::call('supplier:parseCatalog', [
        'supplier' => 'CdiscountPro'
    ]);
    return $exitCode;
});

Route::get('/actualiseProductsTable', function () {
    $exitCode = Artisan::call('supplier:actualiseProductsTable', [
        'supplier' => 'CdiscountPro'
    ]);
    return $exitCode;
});


Route::get('/updateCatalog', function () {
    $exitCode = Artisan::call('reseller:updateCatalog', [
        'reseller' => 'AmazonReseller'
    ]);
    return $exitCode;
});

Route::get('/submitFeed', function () {
    //return \Alyya\Partners\Resellers\Amazon\Feeds\FeedTypes\ProductFeed::triggerOtherFeeds('fr');
  $exitCode = Artisan::call('amazon:submitFeed', [
        'feedType' => 'ProductFeed',
        'countryCode'=>'fr'
    ]);
    return $exitCode;
});

Route::get('/getReport', function () {
    ini_set('max_execution_time', 300);
    //return \Alyya\Partners\Resellers\Amazon\Feeds\FeedTypes\ProductFeed::triggerOtherFeeds('fr');
    $exitCode = Artisan::call('amazon:getReport', [
        'shortName' => 'InventoryReport',
        'reportId' => 987654321 ,
        'countryCode'=>'fr'
    ]);
    return $exitCode;
});

//Route::controller('product','ProductController');

//Route::resource('product', 'ProductController');







