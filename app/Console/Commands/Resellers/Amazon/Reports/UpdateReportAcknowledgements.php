<?php

namespace alyya\Console\Commands\Resellers\Amazon\Reports;


use alyya\Partners\Resellers\Resellers\Amazon\Reports\Report;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class UpdateReportAcknowledgements extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'amazon:updateReportAcknowledgements
                            { shortName : shortName}
                            { reportId : returned by getReportList function }
                            { acknowledged : Acknowledged }';

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
        $acknowledged = $argument['acknowledged'];
        $this->report->updateReportAcknowledgements($reportType,$acknowledged);
        //dd($reportType);
        //
    }
}
