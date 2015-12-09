<?php

namespace Alyya\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Artisan;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \Alyya\Console\Commands\Inspire::class,
        \Alyya\Console\Commands\LogDemo::class,
        \Alyya\Console\Commands\Suppliers\GetCatalog::class,
        \Alyya\Console\Commands\Suppliers\ParseCatalog::class,
        \Alyya\Console\Commands\Suppliers\ActualiseProductsTable::class,
        \Alyya\Console\Commands\Resellers\UpdateCatalog::class,
        \Alyya\Console\Commands\Resellers\Amazon\Feeds\SubmitFeed::class,
        \Alyya\Console\Commands\Resellers\Amazon\Reports\RequestReport::class,
        \Alyya\Console\Commands\Resellers\Amazon\Reports\GetReportRequestList::class,
        \Alyya\Console\Commands\Resellers\Amazon\Reports\GetReportList::class,
        \Alyya\Console\Commands\Resellers\Amazon\Reports\GetReport::class,
        \Alyya\Console\Commands\Resellers\Amazon\Reports\UpdateReportAcknowledgements::class,
        \Alyya\Console\Commands\PricingTest::class,
        \Alyya\Console\Commands\PixmaniaTest::class,
        \Alyya\Console\Commands\Resellers\Amazon\Products\GetCompetitorsLowestOffers::class,
        \Alyya\Console\Commands\FeedProductCategoriesTables::class,

    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        /*$schedule->command('inspire')
                 ->hourly();
        $schedule->command('log:demo')
            ->everyMinute();
        $schedule->command('supplier:parseCatalog CdiscountPro')
            ->dailyAt('18:47');


        $schedule->command('supplier:parseCatalog CdiscountPro')
            ->dailyAt('18:47');
        */

        // pour tester

         $schedule->command('supplier:actualiseProductsTable CdiscountPro')
            ->dailyAt('19:02')
            ->before(function (Artisan $artisan) {
                $artisan::call('supplier:parseCatalog', [
                    'supplier' => 'CdiscountPro'
                ]);
            })
            ->after(function () {
                // Task is complete...
            });


        // final

       /* $schedule->command('supplier:parseCatalog CdiscountPro')
            ->dailyAt('17:22')
            ->before(function (Artisan $artisan) {
                $artisan::call('supplier:getCatalog', [
                    'supplier' => 'CdiscountPro'
                ]);
            })
            ->after(function (Artisan $artisan) {
                $artisan::call('supplier:actualiseProductsTable', [
                    'supplier' => 'CdiscountPro'
                ]);
            });

       */



    }
}
