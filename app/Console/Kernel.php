<?php

namespace alyya\Console;

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
        \alyya\Console\Commands\Inspire::class,
        \alyya\Console\Commands\LogDemo::class,
        \alyya\Console\Commands\Suppliers\GetCatalog::class,
        \alyya\Console\Commands\Suppliers\ParseCatalog::class,
        \alyya\Console\Commands\Suppliers\ActualiseProductsTable::class,
        \alyya\Console\Commands\Resellers\UpdateCatalog::class,
        \alyya\Console\Commands\Resellers\Amazon\Feeds\SubmitFeed::class,
        \alyya\Console\Commands\Resellers\Amazon\Reports\RequestReport::class,
        \alyya\Console\Commands\Resellers\Amazon\Reports\GetReportRequestList::class,
        \alyya\Console\Commands\Resellers\Amazon\Reports\GetReportList::class,
        \alyya\Console\Commands\Resellers\Amazon\Reports\GetReport::class,
        \alyya\Console\Commands\Resellers\Amazon\Reports\UpdateReportAcknowledgements::class,
        \alyya\Console\Commands\PricingTest::class,
        \alyya\Console\Commands\PixmaniaTest::class,

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
