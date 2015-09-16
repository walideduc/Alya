<?php

namespace App\Console\Commands\Resellers\Amazon\Reports;

use App\Partners\Resellers\Resellers\Amazon\Reports\Report;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class GetReportRequestList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'amazon:getReportRequestList
    { shortName : ReportType short class name }
    { reportRequestId : returned by RequestReport function }
    { countryCode }';

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
    public function __construct(Report $report)
    {
        $this->report = $report;// I do this , because I can't dispatch jobs in Report within a static context .
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
        //dd($argument);
        $reportType = App::make($argument['shortName']);
        $reportType->reportRequestId = $argument['reportRequestId'];
        $reportType->countryCode = $argument['countryCode'] ;
        $this->report->getReportRequestList($reportType);
        dd($reportType);
        //
    }
}
