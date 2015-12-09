<?php

namespace Alyya\Jobs\Resellers\Amazon\Feeds;

use Alyya\Jobs\Job;
use Alyya\Partners\Resellers\Amazon\Feeds\FeedTypes\ProductFeed;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

class TriggerOtherFeeds extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    protected $countryCode ;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($countryCode)
    {
        $this->countryCode = $countryCode ;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ProductFeed::triggerOtherFeeds($this->countryCode);
    }
}
