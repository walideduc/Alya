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






App::bind('CdiscountPro',function(){
    return new App\Partners\Suppliers\Suppliers\CdiscountPro\CdiscountPro();
});
App::bind('PixmaniaPro',function(){
    return new App\Partners\Suppliers\Suppliers\PixmaniaPro\PixmaniaPro();
});
