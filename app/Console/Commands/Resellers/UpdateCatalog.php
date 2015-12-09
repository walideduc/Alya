<?php

namespace Alyya\Console\Commands\Resellers;

use Illuminate\Console\Command;

class UpdateCatalog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reseller:updateCatalog
                            { reseller : reseller string }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the catalog of the reseller and triggers the creation .';

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
        $resellerInput = $this->argument('reseller');
        try{
            $this->info('the supplier_id is '.$resellerInput);
            $reseller= \App::make($resellerInput);

            $this->info('The supplier class used is '.get_class($reseller));
            $response = $reseller->updateCatalog();
            $this->info('the supplier_id is '.$resellerInput.' and '.$response);
            return true;

        }catch (\ReflectionException $e ){
            $this->error('This Reseller does not exist , AmazonReseller or AlyyaReseller ');
            return false;
        }
    }
}
