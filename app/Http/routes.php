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



Route::get('/', [
    'as' => 'home', 'uses' => 'IndexController@index'
]);
Route::get('catalogue', 'IndexController@catalogue');
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
Route::get('/user/profile', 'UserController@profile');
Route::get('/user/logout', 'UserController@logout');


//Route::match(['get', 'post'],'add/{product_id?}', 'CartController@add');

Route::group(['prefix' => 'cart'], function () {
    Route::post('add', 'CartController@add');
    Route::get('add', 'CartController@add');
});
Route::group(['prefix' => 'order'], function () {
    Route::get('cart', [
        'as' => 'order_cart', 'uses' => 'OrderController@show'
    ]);
    Route::match(['get', 'post'],'shipping', [
        'as' => 'order_shipping', 'uses' => 'OrderController@shipping', 'middleware' => 'auth'
    ]);
    Route::match(['get', 'post'],'transporter', [
        'as' => 'order_transporter', 'uses' => 'OrderController@transporter', 'middleware' => 'auth'
    ]);
});



Route::get('pages', function () {
    return view('pages.index');
});



Route::get('/getcatalog', function () {
    echo base_path('storage/') ;
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


// Authentication routes...
//Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::get('auth/login', 'Auth\AuthController@getRegister');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');







