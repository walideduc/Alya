<?php

namespace alyya\Console\Commands;

use alyya\Http\Controllers\ProductController;
use Illuminate\Console\Command;

class PricingTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pricing:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $productController = new ProductController();
        $productController->index();
        //
    }
}
