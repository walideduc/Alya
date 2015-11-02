<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 12/09/15
 * Time: 14:35
 */
namespace alyya\Partners\Resellers\Resellers\Amazon;

class AmazonConfig {

    public static $development = true ;
    public static $feedQueue = 'feeds' ;
    public static $reportQueue = 'feeds' ;

    public static $countryCodes = array('fr');//,'de','uk','es','it','fba_fr');
    public static $marketplaceArray = array(
        'fr' => 'A13V1IB3VIYZZH',
        'de' => 'A1PA6795UKMFR9',
        'uk' => 'A1F83G8C2ARO7P',
        'es' => 'A1RKKUPIHCS9HS',
        'it' => 'APJ6JRA9NG5V4',
        'fba_fr' => 'A13V1IB3VIYZZH',
    ) ;

    public static $serviceConfig = array (
        'ServiceURL' => "https://mws.amazonservices.fr",
        'ProxyHost' => null,
        'ProxyPort' => -1,
        'MaxErrorRetry' => 3,
    );

   public static function getMerchantIdentifier($countryCode){
       return $countryCode.'_MerchantIdentifier';
   }
}