<?php

namespace Alyya\Console\Commands;

use Illuminate\Console\Command;
use Alyya\Partners\Suppliers\PixmaniaPro\PixmaniaPro;

class PixmaniaTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pixmania:test';

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
        $pixmania = new PixmaniaPro();
        $pixmania->testCatalog();
        //
    }
}
