<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 15/09/15
 * Time: 13:47
 */

namespace App\Partners\Resellers\Resellers\Amazon\Reports;


use App\Partners\Resellers\Resellers\Amazon\AmazonConfig;

abstract class ReportType {

    public $reportTypeEnumeration = '_GET_ORDERS_DATA_' ;
    public $countryCode ;
    public $isScheduled = 1 ;
    public $acknowledged;
    public $shortName ;
    function __construct($class) {
        $reflect = new \ReflectionClass($class);
        $this->shortName = $reflect->getShortName() ;

    }

    public function setCountryCode($countryCode) {
        if(in_array($countryCode, AmazonConfig::$countryCodes)){
            $this->countryCode = $countryCode ;
            return 1 ;
        }
        return 0;
    }
    public function getReportTypeEnumeration() {
        return $this->reportTypeEnumeration;
    }
    // return True en cas de succ�s de parser le report afin d'appeler UpdateReportAcknowledgements
    abstract function parseReport($reportContents) ;

    abstract function afterParse() ;

}