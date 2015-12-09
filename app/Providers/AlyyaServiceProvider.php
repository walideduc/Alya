<?php

namespace Alyya\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class AlyyaServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        ############################### Suppliers ########################################
        $this->app->bind('CdiscountPro', function () {
            return new \Alyya\Partners\Suppliers\CdiscountPro\CdiscountPro();
        });
        $this->app->bind('PixmaniaPro', function () {
            return new \Alyya\Partners\Suppliers\PixmaniaPro\PixmaniaPro();
        });

        ############################### Resellers ########################################

        $this->app->bind('AlyyaReseller', function () {
            //return new \Alyya\Partners\Resellers\Amazon\AmazonReseller(App::make('Feed'),App::make('Report'));
            return new \Alyya\Partners\Resellers\Alyya\AlyyaReseller();
        });

        $this->app->bind('AmazonReseller', function () {
            //return new \Alyya\Partners\Resellers\Amazon\AmazonReseller(App::make('Feed'),App::make('Report'));
            return new \Alyya\Partners\Resellers\Amazon\AmazonReseller(App::make('Feed'),App::make('Report'));
        });

        $this->app->singleton('AmazonConfig', function () {
            return new \Alyya\Partners\Resellers\Amazon\AmazonConfig();
        });

        ############################### Feeds ########################################
        $this->app->bind('Feed', function () {
            return new \Alyya\Partners\Resellers\Amazon\Feeds\Feed();
        });
        $this->app->bind('ProductFeed', function (){
            return new \Alyya\Partners\Resellers\Amazon\Feeds\FeedTypes\ProductFeed();
        });

        $this->app->bind('InventoryFeed', function (){
            return new \Alyya\Partners\Resellers\Amazon\Feeds\FeedTypes\InventoryFeed();
        });

        $this->app->bind('PricingFeed', function (){
            return new \Alyya\Partners\Resellers\Amazon\Feeds\FeedTypes\PricingFeed();
        });

        $this->app->bind('ImageFeed', function (){
            return new \Alyya\Partners\Resellers\Amazon\Feeds\FeedTypes\ImageFeed();
        });
        $this->app->bind('DeleteProductFeed', function (){
                    return new \Alyya\Partners\Resellers\Amazon\Feeds\FeedTypes\DeleteProductFeed();
        });



        ############################### Reports ########################################
        $this->app->bind('Report', function () {
            return new \Alyya\Partners\Resellers\Amazon\Reports\Report();
        });

        $this->app->bind('InventoryReport', function () {
            return new \Alyya\Partners\Resellers\Amazon\Reports\ReportTypes\InventoryReport();
        });

        $this->app->bind('UnshippedOrdersReport', function () {
            return new \Alyya\Partners\Resellers\Amazon\Reports\ReportTypes\UnshippedOrdersReport();
        });

        $this->app->bind('ScheduledXMLOrderReport', function () {
            return new \Alyya\Partners\Resellers\Amazon\Reports\ReportTypes\ScheduledXMLOrderReport();
        });

        ############################### Products ########################################
        $this->app->bind('Product', function () {
            return new \Alyya\Partners\Resellers\Amazon\Products\Product();
        });
        $this->app->bind('PricingQualifier', function () {
            return new \Alyya\Partners\Resellers\Amazon\Products\PricingQualifiers\PricingQualifier();
        });









    }
        /**
         * Get the services provided by the provider.
         *
         * @return array
         */
   public function provides()
    {
        return ['CdiscountPro','PixmaniaPro','AmazonReseller','ProductFeed'];
    }
}
