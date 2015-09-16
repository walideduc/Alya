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

Route::get('/', function () {
    return view('welcome');
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
    //return \App\Partners\Resellers\Resellers\Amazon\Feeds\FeedTypes\ProductFeed::triggerOtherFeeds('fr');
  $exitCode = Artisan::call('amazon:submitFeed', [
        'feedType' => 'ProductFeed',
        'countryCode'=>'fr'
    ]);
    return $exitCode;
});







