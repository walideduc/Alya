<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 13/11/15
 * Time: 10:44
 */
namespace Alyya\Partners\Resellers\Amazon\Products\PricingQualifiers;
interface iGroupListing {
    public function setCountryCode($countryCode);
    public function getData();
    public function getItemCondition();
    public function getExcludeMe();
    public function afterSuccess($asin,$stockTest);

}