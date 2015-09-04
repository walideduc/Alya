<?php

namespace App\Console\Commands\Suppliers;

use Illuminate\Console\Command;

class ActualiseProductsTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'supplier:actualiseProductsTable
                                { supplier : string used by the container to instantiate the supplier object }';

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
        $supplierInput = $this->argument('supplier');
        try{
            $supplier = \App::make($supplierInput);
            $this->info('The supplier class used is '.get_class($supplier));
            $response = $supplier->actualiseProductsTable();
            $this->info('the supplier_id is '.$supplierInput.' and '.$response);
            return true;

        }catch (\ReflectionException $e ){
            $this->error('This Supplier does not exist , CdiscountPro or PixmaniaPro ');
            return false;
        }

    }
        //

}
