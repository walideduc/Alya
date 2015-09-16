<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 09/09/15
 * Time: 19:21
 */
namespace App\Partners\Resellers\Resellers\Amazon\Feeds ;
use App\Partners\Resellers\Resellers\Amazon\AmazonConfig;

abstract class FeedType {

    public $countryCode;
    public $data = array();

    public function getEnumeration() {
        return $this->enumeration;
    }

    public function setCountryCode($countryCode) {
        if(in_array($countryCode, AmazonConfig::$countryCodes)){
            $this->countryCode = $countryCode ;
            return 1 ;
        }
        return 0;
    }

    public function getProcessingTimeEstimated() {
        return $this->processingTimeEstimated;
    }

    abstract public function formatFeed();
    abstract public function getData();
    abstract public function afterFeed();
    static protected function getTableProductsName($countryCode){
        if($countryCode == 'fr')
            return 'amazon_products';
        return null ;
    }
}