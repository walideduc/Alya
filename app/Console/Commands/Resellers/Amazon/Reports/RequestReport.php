<?php

namespace App\Console\Commands\Resellers\Amazon\Reports;

use App\Partners\Resellers\Resellers\Amazon\AmazonReseller;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;


class RequestReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'amazon:requestReport
                            {reportType : reportType }
                            {countryCode : countryCode }
                            {startDate? : start from }
                            {endDate? : end in } ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'The RequestReport operation creates a report request. Amazon MWS processes the report request and when
the report is completed, sets the status of the report request to _DONE_.';

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
        $reportTypeInput = $this->argument('reportType');
        $countryCode = $this->argument('countryCode');
        $reportType = App::make($reportTypeInput);
        if($reportType->setCountryCode($countryCode)){
            $res = $this->amazonReseller->report->requestReport($reportType);
        }else{
            $this->info(" This countryCode is not supported yet ");
        }
        $this->info(" The reportType is $reportTypeInput , for $countryCode");

        //
    }
}
