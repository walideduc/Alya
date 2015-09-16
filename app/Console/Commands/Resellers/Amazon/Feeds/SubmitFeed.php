<?php

namespace App\Console\Commands\Resellers\Amazon\Feeds;

use Illuminate\Console\Command;
use App\Partners\Resellers\Resellers\Amazon\AmazonReseller;
use Illuminate\Support\Facades\App;

class SubmitFeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'amazon:submitFeed
                            {feedType : ProductFeed , InventoryFeed , PriceFeed , ...... }
                            {countryCode : fr , uk , it , es , de }
                        ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

    protected $amazonReseller ;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(AmazonReseller $amazonReseller)
    {
        $this->amazonReseller = $amazonReseller ;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $feedTypeInput = $this->argument('feedType');
        $countryCode = $this->argument('countryCode');
        $feedType = App::make($feedTypeInput);
        if($feedType->setCountryCode($countryCode)){
            $res = $this->amazonReseller->feed->SubmitFeed($feedType);
        }else{
            $this->info(" This countryCode is not supported yet ");
        }


        $this->info(" SubmitFeed, type $feedTypeInput , countryCode $countryCode  : ".$res);
        return 1;

        //
    }
}
