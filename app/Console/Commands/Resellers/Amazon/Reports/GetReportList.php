<?php

namespace App\Console\Commands\Resellers\Amazon\Reports;

use Illuminate\Console\Command;

class GetReportList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'amazon:getReportList
                            { shortName : ReportType short class name }
                            { reportRequestId : returned by RequestReport function }
                            { countryCode }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'The GetReportList operation returns a list of reports that were created in the previous 90 days that match the
query parameters.';

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
        //
    }
}
