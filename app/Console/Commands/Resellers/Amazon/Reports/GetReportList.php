<?php

namespace App\Console\Commands\Resellers\Amazon\Reports;

use App\Partners\Resellers\Resellers\Amazon\Reports\Report;
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
                            { reportRequestId : returned by RequestReport function }
                            { countryCode }';

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
        debug_kfina($reportType);
        $reportType->reportRequestId = $argument['reportRequestId'];
        $reportType->countryCode = $argument['countryCode'] ;
        $this->report->getReportList($reportType);
        dd($reportType);
    }
}
