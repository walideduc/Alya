<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 11/11/15
 * Time: 18:31
 */

namespace alyya\Partners\Resellers\Resellers\Amazon\Products;

use alyya\Partners\Resellers\Resellers\Amazon\AmazonConfig;
use Illuminate\Foundation\Bus\DispatchesJobs;

require_once(dirname(__FILE__). '/../config.inc.php');
class Product {
    use DispatchesJobs;

    public function getCompetitorsPrices(){
        $service = new \MarketplaceWebServiceProducts_Mock();
        $request = null;
        self::invokeGetLowestOfferListingsForASIN($service, $request);
        dd($service);
    }

    /**
     * Get Get Lowest Offer Listings For ASIN Action Sample
     * Gets competitive pricing and related information for a product identified by
     * the MarketplaceId and ASIN.
     *
     * @param MarketplaceWebServiceProducts_Interface $service instance of MarketplaceWebServiceProducts_Interface
     * @param mixed $request MarketplaceWebServiceProducts_Model_GetLowestOfferListingsForASIN or array of parameters
     */

    static function invokeGetLowestOfferListingsForASIN(\MarketplaceWebServiceProducts_Interface $service, $request)
    {
        try {
            $response = $service->GetLowestOfferListingsForASIN($request);

            echo ("Service Response\n");
            echo ("=============================================================================\n");

            $dom = new \DOMDocument();
            $dom->loadXML($response->toXML());
            $dom->preserveWhiteSpace = false;
            $dom->formatOutput = true;
            echo $dom->saveXML();
            echo("ResponseHeaderMetadata: " . $response->getResponseHeaderMetadata() . "\n");

        } catch (MarketplaceWebServiceProducts_Exception $ex) {
            echo("Caught Exception: " . $ex->getMessage() . "\n");
            echo("Response Status Code: " . $ex->getStatusCode() . "\n");
            echo("Error Code: " . $ex->getErrorCode() . "\n");
            echo("Error Type: " . $ex->getErrorType() . "\n");
            echo("Request ID: " . $ex->getRequestId() . "\n");
            echo("XML: " . $ex->getXML() . "\n");
            echo("ResponseHeaderMetadata: " . $ex->getResponseHeaderMetadata() . "\n");
        }
    }


}