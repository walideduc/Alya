<?php

namespace alyya\Jobs\Resellers\Amazon\Reports;

use alyya\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Artisan;

class GetReportRequestList extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $reportType ;
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
/*        $this->reportType->reportTypeEnumeration ;
        $this->reportType->countryCode;
        $this->reportType->isScheduled;
        $this->reportType->acknowledged;
        $this->reportType->reportRequestId ;
        $this->reportType->shortName ;*/

    /*
    * this job is dispatched from Report@RequestReport , the issue was that I need the ReportObject and his reportRequestId
    * And the country code .
    * I'm using the shortName with the name of the class , the same used in the ICO container .
    * I diced that this job will call a command that call the real function , because I want that the code is organised by a way where I can call every function by a artisan command .
    */

        Artisan::call('amazon:getReportRequestList', [
            'shortName'   =>  $this->reportType->shortName ,
            'reportRequestId' => $this->reportType->reportRequestId ,
            'countryCode'=> $this->reportType->countryCode ,
        ]);

    }
}
