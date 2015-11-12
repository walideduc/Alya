<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 15/09/15
 * Time: 13:37
 */

namespace alyya\Partners\Resellers\Resellers\Amazon\Reports;

use alyya\Partners\Resellers\Resellers\Amazon\AmazonConfig;
use Illuminate\Foundation\Bus\DispatchesJobs;

require_once(dirname(__FILE__). '/../config.inc.php');
class Report {
    use DispatchesJobs;

    public function requestReport(ReportType $reportType, $startDate = null , $endDate = null ) { //If a report accepts ReportOptions, they will be described in the description of the report in the ReportType enumeration section.Unshipped Orders Report ReportOptions=ShowSalesChannel%3Dtrue
        // $ReportType is created with a good $countryCode ( The verifecation is done in the constrctor of $ReportType )
        // $ReportType contient countryCode, ReportEnumeration , et ReportOptions s'il y en a pour le rapport  .
        //dd('fuck');
        $service = self::setServiceClient();
        if ( ( $countryCode = $reportType->countryCode ) != 'all') { // without parenthesis $countryCode = 1 when $ReportType->countryCode  != 'all' .... holy shit :)
            $marketplace = AmazonConfig::$marketplaceArray[$countryCode];
        }
        $marketplaceIdArray = array("Id" => array($marketplace));

        $reportTypeEnumeration = $reportType->getReportTypeEnumeration() ;

        $parameters = array (
            'Merchant' => AmazonConfig::getMerchantIdentifier($reportType->countryCode),
            'MarketplaceIdList' => $marketplaceIdArray,
            'ReportType' => $reportTypeEnumeration
        );

        $request = new \MarketplaceWebService_Model_RequestReportRequest($parameters);
        if (isset($endDate)) {
            $request->setEndDate($endDate);
        }
        if (isset($startDate)) {
            $request->setEndDate($startDate);
        }

        if (isset($reportType->reportOptions)) {
            $request->setReportOptions($reportType->reportOptions);
        }
        //dd(__FILE__.' line '.__LINE__);
        $reportType->reportRequestId = $this->invokeRequestReport($service, $request);
        //dd($reportType);
        if (isset($reportType->reportRequestId)) {
            // Program a GetReportRequestList job delay 15 mn , This job execute a command ;)
            $reflect = new \ReflectionClass($reportType);
            $reportType->shortName = $reflect->getShortName() ;
            $seconds = 1*60 ;
            //dd($reportType);
            $job = (New \alyya\Jobs\Resellers\Amazon\Reports\GetReportRequestList($reportType))->onQueue(AmazonConfig::$reportQueue)->delay($seconds);
            $this->dispatch($job);
            return 1;
        }else {
            return -13;
        }

    }

    private function invokeRequestReport($service, $request) {
        //require 'invokeRequestReport.inc.php';
        $reportRequestId = '123456789';
        return $reportRequestId;
    }


    public function getReportRequestList(ReportType $reportType) {
        //return 1 ;
        if ($reportType->isScheduled == false) {
            $reportRequestId = $reportType->reportRequestId;
            $parameters = array ('Merchant' => AmazonConfig::getMerchantIdentifier($reportType->countryCode),);
            $request = new \MarketplaceWebService_Model_GetReportRequestListRequest($parameters);
            $idlist = new \MarketplaceWebService_Model_IdList();
            $idlist->setId($reportRequestId);
            $request->setReportRequestIdList($idlist);
            //dd($request);
            $service = self::setServiceClient();

            $reportProcessingStatus = self::invokeGetReportRequestList( $service, $request , $reportType) ;
            //dd($reportProcessingStatus);
            if ($reportProcessingStatus === '_DONE_') {
                // program a GetReportList job because the report is ready . Delay or not as you like man
                //$seconds = 15*60 ;
                $job = (New \alyya\Jobs\Resellers\Amazon\Reports\GetReportList($reportType))->onQueue(AmazonConfig::$reportQueue);
                $this->dispatch($job);
                return 1;
            }elseif ($reportProcessingStatus === '_IN_PROGRESS_' || $reportProcessingStatus === '_SUBMITTED_') {
                // program a GetReportRequestList job again because the report is not yet ready with delay of 15 min.
                $seconds = 15*60 ;
                $job = (New \alyya\Jobs\Resellers\Amazon\Reports\GetReportRequestList($reportType))->onQueue(AmazonConfig::$reportQueue)->delay($seconds);
                $this->dispatch($job);
                return 0;
            }else {
                // There is a strange issue
                return -1;
            }
        }else {
            // il y une erreur GetReportRequestList est pour les reports non programm�s  .
        }

    }

    private static function invokeGetReportRequestList(\MarketplaceWebService_Interface $service, $request , $reportType) {
        //require 'invokeGetReportRequestList.inc.php';
        $reportProcessingStatus = '_DONE_' ;
        return $reportProcessingStatus;
    }

    /**
     * @param AmazonMWS_Reports2014_ReportType $reportType
     * @param null $startDate
     * @param null $endDate
     * @return int
     */
    public function getReportList(ReportType $reportType , $startDate = null , $endDate = null ) {
        /* We will prepare the request of GetReportList according to the $reportType->isScheduled .
         * If the $reportType->isScheduled is False that means that I already asked for the  report and I have a reportRequestId which I will use to prepare the request that return the info about the report desired .
         * If the $reportType->isScheduled is True that means I'm trying to get a number >= 0 of scheduled reports , and the response will contain the info about more then one report .
         *        */
        $service = self::setServiceClient();
        $reportRequestId = $reportType->reportRequestId;

        if ($reportType->isScheduled == false && isset($reportRequestId) ) {
            $request = new \MarketplaceWebService_Model_GetReportListRequest();
            $request->setMerchant(AmazonConfig::getMerchantIdentifier($reportType->countryCode));
            $idlist = new \MarketplaceWebService_Model_IdList();
            $idlist->setId($reportRequestId);
            $request->setReportRequestIdList($idlist);
            $reportType->reportId = self::invokeGetReportListToGetReportId($service, $request , $reportType );
            //dd($reportType);
            // program a job of GetReport , do I need a job for this ?
            $job = (New \alyya\Jobs\Resellers\Amazon\Reports\GetReport($reportType))->onQueue(AmazonConfig::$reportQueue)->delay(5*60);
            $this->dispatch($job);
            /*
             * A structured list of ReportRequestId values.
             * If you pass in ReportRequestId values, other query conditions are ignored.
             */
            return 1 ;
        }else { // for the Scheduled report like  alyya/app/Partners/Resellers/Resellers/Amazon/Reports/ReportTypes/ScheduledXMLOrderReport
            if (!$reportRequestId) { // the $reportRequestId of the Scheduled report is 0
                $parameters = array (
                    'Merchant' => AmazonConfig::getMerchantIdentifier($reportType->countryCode),
                    'MaxCount' => 10,
                    'Acknowledged' => $reportType->acknowledged,
                    'ReportTypeList' => array ('Type' => array ($reportType->getReportTypeEnumeration())),
                );
                $request = new \MarketplaceWebService_Model_GetReportListRequest($parameters);
                if (isset($startDate)) {
                    $request->setAvailableFromDate($startDate);
                }
                if (isset($endDate)) {
                    $request->setAvailableToDate($endDate);
                }
                //dd($reportType);
                $reportIdArray = self::invokeGetReportListToGetReportIdArray($service, $request);
                if (isset($reportIdArray)) {
                    self::stock_Reports_Infos($reportIdArray);
                    $i = 1;
                    foreach ($reportIdArray as $reportInfo_object) { // is an object of stdClass class ;)
                        $reportType->reportRequestId = $reportInfo_object->reportRequestId;
                        $reportType->reportId = $reportInfo_object->reportId;
                        //dd($reportType);
                        $delay = $i*1*60 ; // GetReport job for every Report with a delay of 3 minutes
                        $job = (New \alyya\Jobs\Resellers\Amazon\Reports\GetReport($reportType))->onQueue(AmazonConfig::$reportQueue)->delay($delay);
                        $this->dispatch($job);
                        ++$i ;
                    }
                }
                return sizeof($reportIdArray);
            }

        }

    }

     static function stock_Reports_Infos($reportIdArray){

     }
    private static function invokeGetReportListToGetReportId(\MarketplaceWebService_Interface $service, $request , $reportType )  {
        echo ' invokeGetReportListToGetReportId function  ';
        //require 'invokeGetReportList.inc.php';
        $reportId = '987654321';
        return $reportId;
    }

    private static function invokeGetReportListToGetReportIdArray(\MarketplaceWebService_Interface $service, $request)  {
        echo ' invokeGetReportListToGetReportIdArray function  ';
        if (!AmazonConfig::$development){
            require 'invokeGetReportListToGetReportIdArray.inc.php';
            return $reportIdArray;
        }else{
            for ($i = 1 ;$i<=3 ;++$i){
                $reportInfo_object = new \stdClass();
                $reportInfo_object->reportId = $i * 1111111111 ;
                $reportInfo_object->reportType = 'reportType';
                $reportInfo_object->reportRequestId = $i* 11111 ;
                $reportInfo_object->availableDate ='availableDate';
                $reportInfo_object->acknowledged = 'acknowledged';
                $reportInfo_object->acknowledgedDate = 'acknowledgedDate' ;
                $reportIdArray[] = $reportInfo_object;
            }
            return $reportIdArray;
        }

        /*This array contains a number of $reportInfo_object with the fallow structure
            $reportInfo_object->reportId
            $reportInfo_object->reportType
            $reportInfo_object->reportRequestId
            $reportInfo_object->availableDate
            $reportInfo_object->acknowledged
            $reportInfo_object->acknowledgedDate
            $reportIdArray[] = $reportInfo_object;
          */
    }


    public function GetReport(ReportType $reportType) {
        $reportId = $reportType->reportId ;
        $service = self::setServiceClient();
        $request = new \MarketplaceWebService_Model_GetReportRequest();
        $request->setMerchant(AmazonConfig::getMerchantIdentifier($reportType->countryCode));
        $request->setReport(@fopen('php://memory', 'rw+'));
        $request->setReportId($reportId);
        //dd($request);
        return $this->invokeGetReport($service, $request,$reportType);
    }

    private function invokeGetReport($service, $request,ReportType $reportType) {
        ################################ for testing ###############################################################
        //$file = fopen('/home/src/alyya/storage/inventory.txt', 'r'); // InventoryReport
        $file = fopen('/home/src/alyya/storage/order_report.xml', 'r'); // ScheduledXMLOrderReport
        /*
         DB::table('test_jobs')->insert(
            ['note_1' => 'getReport for '.$this->shortName, 'note_2' => 'report_id '.$this->reportId ]
        );
        */

        $reportContents = stream_get_contents($file);
        //dd($reportContents);
        $parsed = $reportType->parseReport($reportContents);
        //dd($parsed);
        return 1;
        if ($parsed === True ) {
            $job = ( new \alyya\Jobs\Resellers\Amazon\Reports\UpdateReportAcknowledgements($reportType,true) )->onQueue(AmazonConfig::$reportQueue)->delay(180);
            $this->dispatch($job);
        }
        ################################ end for testing ###############################################################




        try {
            $response = $service->getReport($request);
            //			$reportRequestId = $reportType->reportRequestId; // peut-etre pas
            //			$reportId = $reportType->reportId;
            //			$countryCode = $reportType->countryCode;
            //			$t_inserted = date('Y-m-d H:i:s');
            if ($response->isSetGetReportResult()) {
                $getReportResult = $response->getGetReportResult();
                if ($getReportResult->isSetContentMd5()) {
                    //echo ("                ContentMd5");
                    //echo ("                " . $getReportResult->getContentMd5() . "\n");
                }
            }
            if ($response->isSetResponseMetadata()) {
                //echo("            ResponseMetadata\n");
                $responseMetadata = $response->getResponseMetadata();
                if ($responseMetadata->isSetRequestId())
                {
                    //echo("                RequestId\n");
                    //echo("                    " . $responseMetadata->getRequestId() . "\n");
                }
            }
            $reportContents = stream_get_contents($request->getReport());
            //var_dump($reportContents);
            $parsed = $reportType->parseReport($reportContents);
            if ($parsed === True ) {
                // je programme une task de UpdateReportAcknowledgements pour laisser une trace que le rapport a bien �t� recue et stock�  ;
                $date = new DateTime();
                //task::push(__CLASS__, 'UpdateReportAcknowledgements',array($reportType,true),$date->format('Y-m-d H:i:s'),2);
            }
            return 15;

        } catch (\MarketplaceWebService_Exception $ex) {

            dd($ex->getMessage());
            $date = new DateTime();
            $period = 'PT15M';
            $date->add(new DateInterval($period));
            $statusCode = $ex->getStatusCode() ;
            if ($statusCode == 503 ) {
                //task::push(__CLASS__, 'GetReport',array($reportType),$date->format('Y-m-d H:i:s'),2);
            }
            //return -15;
            return $statusCode ;
            //echo("Caught Exception: " . $ex->getMessage() . "\n");
            //echo("Response Status Code: " . $ex->getStatusCode() . "\n");
            //echo("Error Code: " . $ex->getErrorCode() . "\n");
            //echo("Error Type: " . $ex->getErrorType() . "\n");
            //echo("Request ID: " . $ex->getRequestId() . "\n");
            //echo("XML: " . $ex->getXML() . "\n");
            //echo("ResponseHeaderMetadata: " . $ex->getResponseHeaderMetadata() . "\n");
        }
    }


    public function updateReportAcknowledgements(ReportType $reportType,$acknowledged = True ) {
        $service = self::setServiceClient();
        $reportId = $reportType->reportId;
        $parameters = array (
            'Merchant' => AmazonConfig::getMerchantIdentifier($reportType->countryCode),
            'ReportIdList' => array ('Id' => array ($reportId)),
            'Acknowledged' => $acknowledged,
        );
        $request = new \MarketplaceWebService_Model_UpdateReportAcknowledgementsRequest($parameters);
        $count =  $this->invokeUpdateReportAcknowledgements($service, $request,$reportType,$acknowledged);
        return $count ;
    }
    private function invokeUpdateReportAcknowledgements(\MarketplaceWebService_Interface $service, $request,$reportType,$acknowledged) {
        require_once 'invokeUpdateReportAcknowledgements.inc.php';
        $count = 1 ;
        return $count;

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