<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 11/11/15
 * Time: 18:31
 */

namespace Alyya\Partners\Resellers\Amazon\Products;

use Alyya\Partners\Resellers\Amazon\AmazonConfig;
use Alyya\Partners\Resellers\Amazon\Products\PricingQualifiers\iGroupListing;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\DB;

require_once(dirname(__FILE__) . '/../config.inc.php');

class Product
{
    use DispatchesJobs;
    static public $serviceUrl = array('EU' => "https://mws-eu.amazonservices.com/Products/2011-10-01", 'NA' => "https://mws.amazonservices.com/Products/2011-10-01");

    public function  getCompetitorsLowestOffers(iGroupListing $pricingQualifier)
    {
        $data = $pricingQualifier->getData();
        $service = self::setServiceClient();
        $service = new \MarketplaceWebServiceProducts_Mock();
        $size = sizeof($data);
        for ($i = 0; $i < $size; $i = $i + 20) {
            $asinArray = array_slice($data, $i, 20);
            $request = new \MarketplaceWebServiceProducts_Model_GetLowestOfferListingsForASINRequest();
            $asinList = new \MarketplaceWebServiceProducts_Model_ASINListType();
            $asinList->setASIN($asinArray);
            $marketplace = AmazonConfig::$marketplaceArray[$pricingQualifier->countryCode];
            $request->setMarketplaceId($marketplace);
            $request->setSellerId(AmazonConfig::getMerchantIdentifier($pricingQualifier->countryCode));
            $request->setASINList($asinList);
            $request->setItemCondition($pricingQualifier->getItemCondition());
            $request->setExcludeMe($pricingQualifier->getExcludeMe());
            //dd($request);
            self::invokeGetLowestOfferListingsForASIN($service, $request, $pricingQualifier);
        }


    }

    /**
     * Get Get Lowest Offer Listings For ASIN Action Sample
     * Gets competitive pricing and related information for a product identified by
     * the MarketplaceId and ASIN.
     *
     * @param MarketplaceWebServiceProducts_Interface $service instance of MarketplaceWebServiceProducts_Interface
     * @param mixed $request MarketplaceWebServiceProducts_Model_GetLowestOfferListingsForASIN or array of parameters
     */

    static function invokeGetLowestOfferListingsForASIN(\MarketplaceWebServiceProducts_Interface $service, $request, $pricingQualifier)
    {
        try {
            $inserted_at = \Carbon\Carbon::now()->toDateTimeString();
            $response = $service->GetLowestOfferListingsForASIN($request);
            $content = new \SimpleXMLElement($response->toXML());
            $content = new \SimpleXMLElement(self::getLowestResponseTest());
            //dd($content->GetLowestOfferListingsForASINResult);
            foreach ($content->GetLowestOfferListingsForASINResult as $getLowestOfferListingsForASINResult) {
                $allOfferListingsConsidered = $getLowestOfferListingsForASINResult->AllOfferListingsConsidered ;
                $marketplaceId = $getLowestOfferListingsForASINResult->Product->Identifiers->MarketplaceASIN->MarketplaceId;
                $asin = $getLowestOfferListingsForASINResult->Product->Identifiers->MarketplaceASIN->ASIN;
                $sellerId = isset($getLowestOfferListingsForASINResult->Product->Identifiers->SKUIdentifier->SellerId) ? $getLowestOfferListingsForASINResult->Product->Identifiers->SKUIdentifier->SellerId : '';
                $SellerSKU = isset($getLowestOfferListingsForASINResult->Product->Identifiers->SKUIdentifier->SellerSKU) ? $getLowestOfferListingsForASINResult->Product->Identifiers->SKUIdentifier->SellerSKU : '';
                $lowestOfferListings = $getLowestOfferListingsForASINResult->Product->LowestOfferListings;
                foreach ($lowestOfferListings->LowestOfferListing as $lowestOfferListing) {
                    DB::table('amazon_competitors_lowest_offers')->insert(
                        [
                            //'inserted_at' => $inserted_at ,
                            'allOfferListingsConsidered' => $allOfferListingsConsidered,
                            'asin' => $asin,
                            'marketplaceId' => $marketplaceId,
                            'sellerId' => $sellerId,
                            'sellerSKU' => $SellerSKU,
                            'itemCondition' =>  $lowestOfferListing->Qualifiers->ItemCondition,
                            'itemSubCondition' =>  $lowestOfferListing->Qualifiers->ItemSubcondition,
                            'fulfillmentChannel' => $lowestOfferListing->Qualifiers->FulfillmentChannel,
                            'shipsDomestically' => $lowestOfferListing->Qualifiers->ShipsDomestically,
                            'shippingTime' => $lowestOfferListing->Qualifiers->ShippingTime->Max,
                            'sellerPositiveFeedbackRating' => $lowestOfferListing->Qualifiers->SellerPositiveFeedbackRating,
                            'numberOfOfferListingsConsidered' => $lowestOfferListing->NumberOfOfferListingsConsidered ,
                            'sellerFeedbackCount' => $lowestOfferListing->SellerFeedbackCount ,
                            'landedPrice_CurrencyCode' => $lowestOfferListing->Price->LandedPrice->CurrencyCode ,
                            'landedPrice_Amount' => $lowestOfferListing->Price->LandedPrice->Amount,
                            'listingPrice_CurrencyCode' => $lowestOfferListing->Price->ListingPrice->CurrencyCode,
                            'listingPrice_Amount' => $lowestOfferListing->Price->ListingPrice->Amount,
                            'shipping_CurrencyCode' => $lowestOfferListing->Price->Shipping->CurrencyCode,
                            'shipping_Amount' => $lowestOfferListing->Price->Shipping->Amount,
                            'multipleOffersAtLowestPrice' => $lowestOfferListing->MultipleOffersAtLowestPrice,
                        ]
                    );
                    $pricingQualifier->afterSuccess($asin,'yes');
                    sleep(5);
                }


            }

            /* $dom = new \DOMDocument();
             $dom->loadXML($response->toXML());
             $dom->preserveWhiteSpace = false;
             $dom->formatOutput = true;
             echo $dom->saveXML();
             echo("ResponseHeaderMetadata: " . $response->getResponseHeaderMetadata() . "\n");*/

        } catch (\MarketplaceWebServiceProducts_Exception $ex) {
            echo("Caught Exception: " . $ex->getMessage() . "\n");
            echo("Response Status Code: " . $ex->getStatusCode() . "\n");
            echo("Error Code: " . $ex->getErrorCode() . "\n");
            echo("Error Type: " . $ex->getErrorType() . "\n");
            echo("Request ID: " . $ex->getRequestId() . "\n");
            echo("XML: " . $ex->getXML() . "\n");
            echo("ResponseHeaderMetadata: " . $ex->getResponseHeaderMetadata() . "\n");
        }
    }


    private static function setServiceClient()
    {
        $service = new \MarketplaceWebServiceProducts_Client(
            AWS_ACCESS_KEY_ID,
            AWS_SECRET_ACCESS_KEY,
            APPLICATION_NAME,
            APPLICATION_VERSION,
            self::getConfig());
        return $service;

    }

    public static function getConfig()
    {
        $countryCode = 'fr';
        $region = ($countryCode === 'us') ? 'NA' : 'EU';
        $config = array('ServiceURL' => self::$serviceUrl[$region],
            'ProxyHost' => null,
            'ProxyPort' => -1,
            'MaxErrorRetry' => 3,
        );
        return $config;
    }

    public static function getLowestResponseTest()
    {
        $xml = '<?xml version="1.0"?>
<GetLowestOfferListingsForASINResponse
  xmlns="http://mws.amazonservices.com/schema/Products/2011-10-01">
<GetLowestOfferListingsForASINResult ASIN="B002KT3XQM" status="Success">
  <AllOfferListingsConsidered>true</AllOfferListingsConsidered>
  <Product xmlns="http://mws.amazonservices.com/schema/Products/2011-10-01"
           xmlns:ns2="http://mws.amazonservices.com/schema/Products/2011-10-01/default.xsd">
    <Identifiers>
      <MarketplaceASIN>
        <MarketplaceId>ATVPDKIKX0DER</MarketplaceId>
        <ASIN>B002KT3XQM</ASIN>
      </MarketplaceASIN>
    </Identifiers>
    <LowestOfferListings>
      <LowestOfferListing>
        <Qualifiers>
          <ItemCondition>Used</ItemCondition>
          <ItemSubcondition>VeryGood</ItemSubcondition>
          <FulfillmentChannel>Merchant</FulfillmentChannel>
          <ShipsDomestically>True</ShipsDomestically>
          <ShippingTime>
            <Max>0-2 days</Max>
          </ShippingTime>
          <SellerPositiveFeedbackRating>90-94%</SellerPositiveFeedbackRating>
        </Qualifiers>
        <NumberOfOfferListingsConsidered>1</NumberOfOfferListingsConsidered>
        <SellerFeedbackCount>762</SellerFeedbackCount>
        <Price>
          <LandedPrice>
            <CurrencyCode>USD</CurrencyCode>
            <Amount>32.99</Amount>
          </LandedPrice>
          <ListingPrice>
            <CurrencyCode>USD</CurrencyCode>
            <Amount>28.00</Amount>
          </ListingPrice>
          <Shipping>
            <CurrencyCode>USD</CurrencyCode>
            <Amount>4.99</Amount>
          </Shipping>
        </Price>
        <MultipleOffersAtLowestPrice>False</MultipleOffersAtLowestPrice>
      </LowestOfferListing>
      <LowestOfferListing>
        <Qualifiers>
          <ItemCondition>New</ItemCondition>
          <ItemSubcondition>New</ItemSubcondition>
          <FulfillmentChannel>Amazon</FulfillmentChannel>
          <ShipsDomestically>True</ShipsDomestically>
          <ShippingTime>
            <Max>0-2 days</Max>
          </ShippingTime>
          <SellerPositiveFeedbackRating>98-100%</SellerPositiveFeedbackRating>
        </Qualifiers>
        <NumberOfOfferListingsConsidered>1</NumberOfOfferListingsConsidered>
        <SellerFeedbackCount>181744</SellerFeedbackCount>
        <Price>
          <LandedPrice>
            <CurrencyCode>USD</CurrencyCode>
            <Amount>34.27</Amount>
          </LandedPrice>
          <ListingPrice>
            <CurrencyCode>USD</CurrencyCode>
            <Amount>34.27</Amount>
          </ListingPrice>
          <Shipping>
            <CurrencyCode>USD</CurrencyCode>
            <Amount>0.00</Amount>
          </Shipping>
        </Price>
        <MultipleOffersAtLowestPrice>False</MultipleOffersAtLowestPrice>
      </LowestOfferListing>
      <LowestOfferListing>
        <Qualifiers>
          <ItemCondition>New</ItemCondition>
          <ItemSubcondition>New</ItemSubcondition>
          <FulfillmentChannel>Amazon</FulfillmentChannel>
          <ShipsDomestically>True</ShipsDomestically>
          <ShippingTime>
            <Max>0-2 days</Max>
          </ShippingTime>
          <SellerPositiveFeedbackRating>95-97%</SellerPositiveFeedbackRating>
        </Qualifiers>
        <NumberOfOfferListingsConsidered>1</NumberOfOfferListingsConsidered>
        <SellerFeedbackCount>13213</SellerFeedbackCount>
        <Price>
          <LandedPrice>
            <CurrencyCode>USD</CurrencyCode>
            <Amount>41.18</Amount>
          </LandedPrice>
          <ListingPrice>
            <CurrencyCode>USD</CurrencyCode>
            <Amount>41.18</Amount>
          </ListingPrice>
          <Shipping>
            <CurrencyCode>USD</CurrencyCode>
            <Amount>0.00</Amount>
          </Shipping>
        </Price>
        <MultipleOffersAtLowestPrice>False</MultipleOffersAtLowestPrice>
      </LowestOfferListing>
    </LowestOfferListings>
  </Product>
</GetLowestOfferListingsForASINResult>
<ResponseMetadata>
  <RequestId>60979901-82af-457b-8bdd-EXAMPLE28478</RequestId>
</ResponseMetadata>
</GetLowestOfferListingsForASINResponse>';
        return $xml;
    }

}