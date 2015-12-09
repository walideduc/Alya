<?php

namespace Alyya\Console\Commands\Suppliers;

use Illuminate\Console\Command;
use Alyya\Partners\Suppliers\AbstractSupplier;
use PhpSpec\Console\Application;

class GetCatalog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'supplier:getCatalog
                                {supplier : string used by container to instantiate the supplier object }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'gets the catalog file of the given supplier from the supplier server and place it in the supplier\'s local directory.';

    protected $supplierContainer;

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
        $supplier_input = $this->argument('supplier');
        try{
            $supplier = \App::make($supplier_input);
            $this->info(get_class($supplier));
            //$responsePut = $supplier->putFileTest();
            $this->confirm(" , Do you to continue ?");
            $response = $supplier->getCatalog();
            $this->info('the supplier_id is '.$supplier_input.' and '.$response);
            return true;
        }catch (\ReflectionException $e){
            $this->error('This Supplier does not exist , CdiscountPro or PixmaniaPro ');
            return false;
        }

    }

}