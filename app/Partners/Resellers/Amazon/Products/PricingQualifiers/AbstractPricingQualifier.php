<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 13/11/15
 * Time: 10:43
 */
namespace Alyya\Partners\Resellers\Amazon\Products\PricingQualifiers;
abstract class AbstractPricingQualifier implements iGroupListing {
    public $countryCode ;
    public $excludeMe = true ;
    public $itemCondition = 'New'; //(New, Used, Collectible, Refurbished, or Club)
    //public $itemSubCondition = 'New' ; (New, Mint, Very Good, Good, Acceptable, Poor, Club, OEM, Warranty, Refurbished Warranty, Refurbished, Open Box, or Other)
    //public $fulfillmentChannel ; (Amazon or Merchant)
    /*public $shipsDomestically ;(True, False, or Unknown) – Indicates whether the marketplace specified in
    the request and the location that the item ships from are in the same country.*/
    /* public $shippingTime ; (0-2 days, 3-7 days, 8-13 days, or 14 or more days) – Indicates the maximum time
within which the item will likely be shipped once an order has been placed */
    /* public $SellerPositiveFeedbackRating ; (98-100%, 95-97%, 90-94%, 80-89%, 70-79%, Less than 70%, or
    Just launched) ) – Indicates the percentage of feedback ratings that were positive over the past 12 months. */

    public function setCountryCode($countryCode){
        $this->countryCode = $countryCode ;
    }
    abstract public function getData();
    public function getItemCondition(){
        return $this->itemCondition ;
    }
    public function getExcludeMe(){
        return $this->excludeMe;
    }
    abstract public function afterSuccess($asin,$stockTest);

}