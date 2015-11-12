<?php

namespace alyya\Console\Commands\Resellers\Amazon\Products;

use alyya\Partners\Resellers\Resellers\Amazon\Products\Product;
use Illuminate\Console\Command;

class GetCompetitorsPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'amazon:getCompetitorsPrices';

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
    public function __construct(Product $product)
    {
        $this->product = $product ;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->product->getCompetitorsPrices();
        //
    }
}
