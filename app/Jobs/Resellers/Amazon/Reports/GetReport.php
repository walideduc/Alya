<?php

namespace alyya\Jobs\Resellers\Amazon\Reports;

use alyya\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Artisan;

class GetReport extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $reportType;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($reportType)
    {
        $this->reportType = $reportType ;
        //dd($this);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Artisan::call('amazon:getReport', [
            'shortName'   =>  $this->reportType->shortName ,
            'reportId' => $this->reportType->reportId ,
            'countryCode'=> $this->reportType->countryCode ,
        ]);
    }
}
