<?php

namespace Alyya\Jobs\Resellers\Amazon\Reports;

use Alyya\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Artisan;

class UpdateReportAcknowledgements extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($reportType, $acknowledged)
    {
        $this->shortName = $reportType->shortName ;
        $this->reportId = $reportType->reportId ;
        $this->acknowledged = $acknowledged;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Artisan::call('amazon:updateReportAcknowledgements', [
            'shortName' => $this->shortName,
            'reportId'   =>  $this->reportId,
            'acknowledged' => $this->acknowledged ,
        ]);
    }
}
