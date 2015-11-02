<?php

namespace alyya\Jobs\Resellers\Amazon\Feeds;

use alyya\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

class GetFeedSubmissionList extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    protected $parametersFeed ;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($parametersFeed)
    {
        $this->parametersFeed = $parametersFeed ;
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Feed::GetFeedSubmissionList($this->parametersFeed);
        //
    }

    /**
     * Handle a job failure.
     *
     * @return void
     */
    public function failed()
    {
        // Called when the job is failing...
    }
}
