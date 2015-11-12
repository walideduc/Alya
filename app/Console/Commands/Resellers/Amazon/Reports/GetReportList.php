<?php

namespace alyya\Console\Commands\Resellers\Amazon\Reports;

use alyya\Partners\Resellers\Resellers\Amazon\Reports\Report;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class GetReportList extends Command
{
    protected $report ;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'amazon:getReportList
                            { shortName : ReportType short class name }
                            { countryCode }
                            { reportRequestId=0 : Optional argument returned by RequestReport function }
                            ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'returns a list of reports that were created in the previous 90 days that match the query parameters.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Report $report)
    {
        $this->report = $report;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $argument = $this->argument();
        $reportType = App::make($argument['shortName']);
        $reportType->reportRequestId = $argument['reportRequestId'];
        $reportType->countryCode = $argument['countryCode'] ;
        //dd($reportType);

        # begin testing the coherence of inputs ************************
        if(false==$reportType->reportRequestId){// The default value '0' was assigned to reportRequestId and this means the report is scheduled
            if($reportType->isScheduled==false){
                $this->error('this report is not scheduled , the third optional reportRequestId is needed');
                dd('execution was stop');
            }
        }else{
            if($reportType->isScheduled==true){
                $this->error('this report is scheduled , so no reportRequestId is needed , Make No SENSE ');
                dd('execution was stop');
            }
        }
        # end testing the coherence of inputs ************************

        //dd($reportType);
        $this->report->getReportList($reportType);

    }
}
