<?php

namespace Alyya\Console\Commands\Resellers\Amazon\Products;

use Alyya\Partners\Resellers\Amazon\Products\PricingQualifiers\PricingQualifier;
use Alyya\Partners\Resellers\Amazon\Products\Product;
use Illuminate\Console\Command;

class GetCompetitorsLowestOffers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'amazon:getCompetitorsLowestOffers
                            { countryCode :  countryCode }
                            { categoryId= 0 : Optional argument }'; // be careful for the space between the categoryCode and the '=' , it a key for the argument array .

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
    public function __construct(Product $product , PricingQualifier $pricingQualifier)
    {
        $this->product = $product ;
        $this->pricingQualifier = $pricingQualifier ;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $argument =$this->argument();        ;
        $this->pricingQualifier->setCountryCode($argument['countryCode']);
        //$argument['categoryId'];
        //dd($argument);
        $this->product->getCompetitorsLowestOffers($this->pricingQualifier);
        //
    }
}
