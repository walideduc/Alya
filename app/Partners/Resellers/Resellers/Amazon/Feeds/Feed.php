<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 09/09/15
 * Time: 19:18
 */

namespace App\Partners\Resellers\Resellers\Amazon\Feeds ;

use App\Partners\Resellers\Resellers\Amazon\AmazonConfig;
use Illuminate\Foundation\Bus\DispatchesJobs ;

require_once(dirname(__FILE__). '/../config.inc.php');

class Feed {
    use DispatchesJobs ;
    static $queuesCategory = 'feeds';
    public function SubmitFeed(FeedType $feedType) {

        /********* Begin creation the request Block *********/
        if (!$feedType->getData()) { // return 0 , if there is no thing to submit .
            return -1; // there is nothing to submit
        }
        $marketplace = AmazonConfig::$marketplaceArray[$feedType->countryCode];
        //dd($marketplace);
        $marketplaceIdArray = array("Id" =>$marketplace);
        $feed = $feedType->formatFeed();
        //dd($feed);
        $feedType_string = $feedType->getEnumeration();
        //dd($feedType_string);
        $feedHandle = @fopen('php://temp', 'rw+');
        fwrite($feedHandle, $feed);
        //echo 'ok'.$feed;
        rewind($feedHandle);
        $parameters = array (
            'Merchant' => AmazonConfig::getMerchantIdentifier($feedType->countryCode),
            'MarketplaceIdList' => $marketplaceIdArray,
            'FeedType' => "$feedType_string",
            'FeedContent' => $feedHandle,
            'PurgeAndReplace' => false,
            'ContentMd5' => base64_encode(md5(stream_get_contents($feedHandle), true)),
        );
        rewind($feedHandle);
        $request = new \MarketplaceWebService_Model_SubmitFeedRequest($parameters);
         //dd($request);

        /********* End creation the request Block *********/
        $service = self::setServiceClient();
        $submissionId = $this->invokeSubmitFeed($service, $request);
        debug_kfina($submissionId);
        if (isset($submissionId)) { // the feed was well sent :)
            $feedType->afterFeed(); // I will do what needed after the feed was sent
            ## I program the GetFeedSubmissionList job
            $parametersFeed = New \stdClass();
            $parametersFeed->submissionId = $submissionId ;
            $parametersFeed->feedType_string = $feedType_string;
            $parametersFeed->countryCode  = $feedType->countryCode;
            $parametersFeed->class  = get_class($feedType);
            $seconds = $feedType->getProcessingTimeEstimated() * 60 ;
            $job = (new \App\Jobs\Resellers\Amazon\Feeds\GetFeedSubmissionList($parametersFeed))->onQueue(self::$queuesCategory)->delay($seconds);
            //var_dump(app('Illuminate\Contracts\Bus\Dispatcher'));

            $this->dispatch($job);
            return $submissionId;
        }
    }

    private function invokeSubmitFeed(\MarketplaceWebService_Interface $service, $request){
        //require 'invokeSubmitFeed.inc.php';
        //return $submissionId;
        return '123456789';
    }

    public static function GetFeedSubmissionList($parametersFeed) {
        $parametersFeed->submissionId;
        $parametersFeed->feedType_string;
        $parametersFeed->countryCode;
        $parametersFeed->class;
        debug_kfina($parametersFeed);
        return $parametersFeed->submissionId ;

        /*
         * To be completed from $parmsFeed array to $parametersFeed object .
         * I will be back after finishing with Reports :)
         */

        $service = self::setServiceClient();
        $request = new \MarketplaceWebService_Model_GetFeedSubmissionListRequest();
        $request->setMerchant(AmazonConfig::getMerchantIdentifier($parametersFeed->countryCode));
        //$statusList = new MarketplaceWebService_Model_StatusList();
        $submissionIdList = new \MarketplaceWebService_Model_IdList();
        $submissionIdList->setId($parmsFeed['submissionId']);
        $request->setFeedSubmissionIdList($submissionIdList);
        self::invokeGetFeedSubmissionList($service, $request,$parmsFeed);
    }


    private static function setServiceClient() {
        $service = new \MarketplaceWebService_Client(
            AWS_ACCESS_KEY_ID,
            AWS_SECRET_ACCESS_KEY,
            AmazonConfig::$serviceConfig,
            APPLICATION_NAME,
            APPLICATION_VERSION);

        return $service;
    }
}