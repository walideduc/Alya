<?php

namespace alyya\Console\Commands\Resellers\Amazon\Reports;

use alyya\Partners\Resellers\Resellers\Amazon\Reports\Report;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class GetReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'amazon:getReport
                            { shortName : ReportType short class name }
                            { reportId : returned by getReportList function }
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
        $argument = $this->argument();
        $reportType = App::make($argument['shortName']);
        $reportType->reportId = $argument['reportId'];
        $reportType->countryCode = $argument['countryCode'] ;
        $this->report->getReport($reportType);
        dd($reportType);
    }
}
