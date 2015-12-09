<?php

namespace Alyya\Console\Commands\Suppliers;

use Illuminate\Console\Command;

class ParseCatalog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'supplier:parseCatalog
                                {supplier : string used by container to instantiate the supplier object }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse the catalog file already in the supplier\'s local directory and loads products in supplier\'s product table .';

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
        $supplierInput = $this->argument('supplier');
        try{
            $supplier = \App::make($supplierInput);
            $this->info('The supplier class used is '.get_class($supplier));
            $response = $supplier->parseCatalog();
            $this->info('the supplier_id is '.$supplierInput.' and '.$response);
            return true;
        }catch (\ReflectionException $e){
            $this->error('This Supplier does not exist , CdiscountPro or PixmaniaPro ');
            return false;
        }
    }
}
