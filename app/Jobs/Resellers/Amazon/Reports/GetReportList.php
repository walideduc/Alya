<?php

namespace Alyya\Jobs\Resellers\Amazon\Reports;

use Alyya\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Artisan;

class GetReportList extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($reportType)
    {
        $this->reportType = $reportType ;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Artisan::call('amazon:getReportList', [
            'shortName'   =>  $this->reportType->shortName ,
            'reportRequestId' => $this->reportType->reportRequestId ,
            'countryCode'=> $this->reportType->countryCode ,
        ]);
    }
}
