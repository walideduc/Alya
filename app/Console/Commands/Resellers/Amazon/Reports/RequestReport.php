<?php

namespace Alyya\Console\Commands\Resellers\Amazon\Reports;


use Alyya\Partners\Resellers\Amazon\Reports\Report;
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
    protected $description = 'Creates a report request to Amazon';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Report $report)
    {
        $this->report = $report ;
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
            $res = $this->report->requestReport($reportType);
        }else{
            $this->info(" This countryCode is not supported yet ");
        }
        $this->info(" The reportType is $reportTypeInput , for $countryCode");

        //
    }
}
