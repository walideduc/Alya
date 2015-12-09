<?php

namespace Alyya\Console\Commands;

use Alyya\Partners\Suppliers\CdiscountPro\CdiscountPro;
use Illuminate\Console\Command;

class FeedProductCategoriesTables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alyya:backFirstFeed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
    public function handle(CdiscountPro $cdiscountPro)
    {
        $cdiscountPro->alyya_firstFeed();
    }
}
