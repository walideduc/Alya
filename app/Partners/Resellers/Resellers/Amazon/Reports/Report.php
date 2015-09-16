<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 15/09/15
 * Time: 13:37
 */

namespace App\Partners\Resellers\Resellers\Amazon\Reports;

use App\Partners\Resellers\Resellers\Amazon\AmazonConfig;
use Illuminate\Foundation\Bus\DispatchesJobs;

require_once(dirname(__FILE__). '/../config.inc.php');
class Report {
    use DispatchesJobs;
    static $queuesCategory = 'default';

    public function requestReport(ReportType $reportType, $startDate = null , $endDate = null ) { //If a report accepts ReportOptions, they will be described in the description of the report in the ReportType enumeration section.Unshipped Orders Report ReportOptions=ShowSalesChannel%3Dtrue
        // $ReportType is created with a good $countryCode ( The verifecation is done in the constrctor of $ReportType )
        // $ReportType contient countryCode, ReportEnumeration , et ReportOptions s'il y en a pour le rapport  .
        $service = self::setServiceClient();
        if ( ( $countryCode = $reportType->countryCode ) != 'all') { // without parenthesis $countryCode = 1 when $ReportType->countryCode  != 'all' .... holy shit :)
            $marketplace = AmazonConfig::$marketplaceArray[$countryCode];
        }
        $marketplaceIdArray = array("Id" => array($marketplace));

        $reportTypeEnumeration = $reportType->getReportTypeEnumeration() ;

        $parameters = array (
            'Merchant' => MERCHANT_ID,
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
        if (isset($reportType->reportRequestId)) {
            // Program a GetReportRequestList job delay 15 mn , This job execute a command ;)
            $reflect = new \ReflectionClass($reportType);
            $reportType->shortName = $reflect->getShortName() ;
            $seconds = 15*60 ;
            $job = (New \App\Jobs\Resellers\Amazon\Reports\GetReportRequestList($reportType))->onQueue(self::$queuesCategory)->delay($seconds);
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
        if ($reportType->isScheduled == false) {
            $reportRequestId = $reportType->reportRequestId;
            $parameters = array ('Merchant' => MERCHANT_ID,);
            $request = new \MarketplaceWebService_Model_GetReportRequestListRequest($parameters);
            $idlist = new \MarketplaceWebService_Model_IdList();
            $idlist->setId($reportRequestId);
            $request->setReportRequestIdList($idlist);
            //dd($request);
            $service = self::setServiceClient();

            $reportProcessingStatus = self::invokeGetReportRequestList( $service, $request , $reportType) ;
            dd($reportProcessingStatus);
            if ($reportProcessingStatus === '_DONE_') {
                // program a GetReportList job because the report is ready . Delay or not as you like man
                //$seconds = 15*60 ;
                $job = (New \App\Jobs\Resellers\Amazon\Reports\GetReportList($reportType))->onQueue(self::$queuesCategory);
                $this->dispatch($job);
                return 1;
            }elseif ($reportProcessingStatus === '_IN_PROGRESS_' || $reportProcessingStatus === '_SUBMITTED_') {
                // program a GetReportRequestList job again because the report is not yet ready with delay of 15 min.
                $seconds = 15*60 ;
                $job = (New \App\Jobs\Resellers\Amazon\Reports\GetReportRequestList($reportType))->onQueue(self::$queuesCategory)->delay($seconds);
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