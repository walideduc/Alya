<?php
namespace alyya\Partners\Resellers\Resellers\Amazon\Reports\ReportTypes;
use alyya\Partners\Resellers\Resellers\Amazon\Reports\ReportType;
use Illuminate\Support\Facades\DB;

class ScheduledXMLOrderReport extends ReportType {

	public $reportTypeEnumeration = '_GET_ORDERS_DATA_' ;
	public $countryCode ;
	public $isScheduled = 1 ;
	public $acknowledged;

	function __construct($countryCode = 'all',$acknowledged = False ) {
		parent::__construct(__CLASS__);
		$this->acknowledged = $acknowledged;
	}

	public  function parseReport($reportContents){
        //dd($reportContents);
		$scheduledXMLOrderReport = new \SimpleXMLElement($reportContents);
        //dd($scheduledXMLOrderReport);
		foreach ($scheduledXMLOrderReport->Message as $message) {
			$orderReport = $message->OrderReport; // exists only once in the Message tag so we don't need a loop here
			$billingData = $orderReport->BillingData;
			$billing_address = $billingData->Address;

			$fulfillmentData = $orderReport->FulfillmentData;
			$fulfillment_address = $fulfillmentData->Address ;
            //dd($fulfillment_address);
			/* Patch pour les zip codes, trop souvent absents dans l'une ou l'autre des adresses */
			if(strtolower($billing_address->City) == strtolower($fulfillment_address->City))
			{
				if(empty($billing_address->PostalCode) && !empty($fulfillment_address->PostalCode))
				$billing_address->PostalCode = $fulfillment_address->PostalCode ;

				if(empty($fulfillment_address->PostalCode) && !empty($billing_address->PostalCode))
				$fulfillment_address->PostalCode = $billing_address->PostalCode ;
			}
			/*fin du patch*/


			$amazonOrderID = $orderReport->AmazonOrderID;
			$amazonSessionID = $orderReport->AmazonSessionID;
			$orderDate = $orderReport->OrderDate;
			$date = new \DateTime($orderDate);
			$orderDate = $date->format('Y-m-d H:i:s');
			$orderPostedDate = $orderReport->OrderPostedDate ;
			$date = new \DateTime($orderPostedDate);
			$orderPostedDate = $date->format('Y-m-d H:i:s');

			foreach ($orderReport->CustomerOrderInfo as $customerOrderInfo ) {//0..10
				DB::table('amazon_customerOrderInfo')->insert(
                    [
                        'amazonOrderID' => $amazonOrderID,
                        'type' => $customerOrderInfo->Type ,
                        'value' => $customerOrderInfo->Value,
                    ]
                );
			}

			// parse billingData
			$buyerEmailAddress = $billingData->BuyerEmailAddress ;
			$buyerName = $billingData->BuyerName ;
			$buyerPhoneNumber = $billingData->BuyerPhoneNumber ;
			$creditCard = isset($billingData->CreditCard) ? $billingData->CreditCard : null ; // 0..1
			if (!is_null($creditCard)){
                DB::table('amazon_order_creditCard')->insert(
                    [
                        'amazonOrderID' => $amazonOrderID,
                        'issuer' => $creditCard->Issuer ,
                        'tail' => $creditCard->Tail,
                        'expirationDate' => $creditCard->ExpirationDate ,
                    ]
                );
			}
			$billing_address_name = $billing_address->Name ;
			$billing_address_formalTitle = $billing_address->FormalTitle ;
			$billing_address_givenName = $billing_address->GivenName ;
			$billing_address_FamilyName = $billing_address->FamilyName ; #
			$billing_address_addressFieldOne = $billing_address->AddressFieldOne ;
			$billing_address_addressFieldTwo =$billing_address->AddressFieldTwo ;
			$billing_address_addressFieldThree = $billing_address->AddressFieldThree ; #
			$billing_address_city = $billing_address->City ;
			$billing_address_county = $billing_address->County ; #
			$billing_address_stateOrRegion = $billing_address->StateOrRegion; #
			$billing_address_postalCode = $billing_address->PostalCode ;
			$billing_address_CountryCode= $billing_address->CountryCode ;
			$billing_address_PhoneNumber = $billing_address->PhoneNumber ;

			// parse fulfillmentData
			$fulfillmentMethod = $fulfillmentData->FulfillmentMethod ;
			$fulfillmentServiceLevel = $fulfillmentData->FulfillmentServiceLevel;
			$fulfillment_address_name = $fulfillment_address->Name;
			$fulfillment_address_formalTitle = $fulfillment_address->FormalTitle;#
			$fulfillment_address_givenName = $fulfillment_address->GivenName;#
			$fulfillment_address_familyName = $fulfillment_address->FamilyName;#
			$fulfillment_address_addressFieldOne = $fulfillment_address->AddressFieldOne ;
			$fulfillment_address_addressFieldTwo= $fulfillment_address->AddressFieldTwo;
			$fulfillment_address_addressFieldThree= $fulfillment_address->AddressFieldThree;#
			$fulfillment_address_city = $fulfillment_address->City ;
			$fulfillment_address_county = $fulfillment_address->County ;#
			$fulfillment_address_stateOrRegion = $fulfillment_address->StateOrRegion ;#
			$fulfillment_address_postalCode = $fulfillment_address->PostalCode;
			$fulfillment_address_countryCode = $fulfillment_address->CountryCode ;
			$fulfillment_address_phoneNumber = $fulfillment_address->PhoneNumber ;
			$documentID = isset($this->reportId) ? $this->reportId : '';
			// there is a unique constraint on AmazonOrderID .
            DB::table('amazon_orders')->insert(
                [
                    'documentID' => $documentID,
                    'amazonOrderID' => $amazonOrderID,
                    'amazonSessionID' => $amazonSessionID,
                    'orderDate' => $orderDate,
                    'orderPostedDate' => $orderPostedDate,
                    'buyerEmailAddress' => $buyerEmailAddress,
                    'buyerName' => $buyerName,
                    'buyerPhoneNumber' => $buyerPhoneNumber,
                    'billingName' => $billing_address_name,
                    'billingFormalTitle' => $billing_address_formalTitle,
                    'billingGivenName' => $billing_address_givenName,
                    'billingFamilyName' => $billing_address_FamilyName,
                    'billingAddressFieldOne' => $billing_address_addressFieldOne,
                    'billingAddressFieldTwo' => $billing_address_addressFieldTwo,
                    'billingAddressFieldThree' => $billing_address_addressFieldThree,
                    'billingCity' => $billing_address_city,
                    'billingCounty' => $billing_address_county,
                    'billingStateOrRegion' => $billing_address_stateOrRegion,
                    'billingPostalCode' => $billing_address_postalCode,
                    'billingCountryCode' => $billing_address_CountryCode,
                    'billingPhoneNumber' => $billing_address_PhoneNumber,
                    'fulfillmentMethod' => $fulfillmentMethod ,
                    'fulfillmentServiceLevel' => $fulfillmentServiceLevel,
                    'fulfillmentName' => $fulfillment_address_name,
                    'fulfillmentFormalTitle' => $fulfillment_address_formalTitle,
                    'fulfillmentGivenName' => $fulfillment_address_givenName,
                    'fulfillmentFamilyName' => $fulfillment_address_familyName,
                    'fulfillmentAddressFieldOne' => $fulfillment_address_addressFieldOne,
                    'fulfillmentAddressFieldTwo' => $fulfillment_address_addressFieldTwo,
                    'fulfillmentAddressFieldThree' => $fulfillment_address_addressFieldThree,
                    'fulfillmentCity' => $fulfillment_address_city,
                    'fulfillmentCounty' => $fulfillment_address_county,
                    'fulfillmentStateOrRegion' => $fulfillment_address_stateOrRegion,
                    'fulfillmentPostalCode' => $fulfillment_address_postalCode,
                    'fulfillmentCountryCode' => $fulfillment_address_countryCode,
                    'fulfillmentPhoneNumber' => $fulfillment_address_phoneNumber,
                ]
            );
			/// items order
			foreach ($orderReport->Item as $item) {
				//print_r($item);
				$itemPrice = $item->ItemPrice ; // array
				$itemFees = $item->ItemFees->Fee ; // array

				$amazonOrderItemCode = $item->AmazonOrderItemCode;
				$sku = $item->SKU ;
				$title = $item->Title ;
				$quantity = $item->Quantity ;
				$productTaxCode = $item->ProductTaxCode;
				$itemPrice_array = array() ;
				foreach($itemPrice->Component as $component)
				{
					// le couple (amazonOrderItemCode,type) est unique dans la table `amazon_ordered_products_prices`
					$type = (string)$component->Type;
					$amount = (string)$component->Amount;
					$currency = (string)$component->Amount['currency'];
					$itemPrice_array[$type] = $amount ;
					$itemPrice_array[$type.'_currency'] = $currency ;
                    DB::table('amazon_ordered_products_prices')->insert(
                        [
                            'amazonOrderID' => $amazonOrderID,
                            'amazonOrderItemCode' => $amazonOrderItemCode ,
                            'type' => $type ,
                            'amount' => $amount ,
                            'currency' => $currency ,
                        ]
                    );
				}
				$principal = $itemPrice_array['Principal'];
				$principal_currency = $itemPrice_array['Principal_currency'];
				$shipping = $itemPrice_array['Shipping'];
				$shipping_currency = $itemPrice_array['Shipping_currency'];
				$tax =  $itemPrice_array['Tax'];
				$tax_currency = $itemPrice_array['Tax_currency'];
				$shippingTax = $itemPrice_array['ShippingTax'];
				$shippingTax_currency = $itemPrice_array['ShippingTax_currency'];

				$itemFees_array = array() ;
				foreach($itemFees as $fee)
				{
					// le couple (amazonOrderItemCode,type) est unique dans la table `amazon_ordered_products_amazon_fees`
					$type = (string)$fee->Type;
					$amount = (string)$fee->Amount ;
					$currency = (string)$fee->Amount['currency'] ;
					$itemFees_array[$type] = $amount ;
					$itemFees_array[$type.'_currency'] = $currency ;
                    DB::table('amazon_ordered_products_amazon_fees')->insert(
                        [
                            'amazonOrderID' => $amazonOrderID,
                            'amazonOrderItemCode' => $amazonOrderItemCode ,
                            'type' => $type ,
                            'amount' => $amount ,
                            'currency' => $currency ,
                        ]
                    );
				}
				$commission = $itemFees_array['Commission'] ;
				$commission_currency = $itemFees_array['Commission_currency'] ;
				// AmazonOrderItemCode est unique
                DB::table('amazon_ordered_products')->insert(
                    [
                        'amazonOrderID' => $amazonOrderID,
                        'amazonOrderItemCode' => $amazonOrderItemCode ,
                        'SKU' => $sku ,
                        'title' => $title ,
                        'quantity' => $quantity ,
                        'productTaxCode' => $productTaxCode ,
                        'itemPrice_principal' => $principal ,
                        'itemPrice_principal_currency' => $principal_currency ,
                        'itemPrice_Shipping' => $shipping ,
                        'itemPrice_shipping_currency' => $shipping_currency ,
                        'itemPrice_tax' => $tax ,
                        'itemPrice_tax_currency' => $tax_currency ,
                        'itemPrice_shippingTax' => $shippingTax ,
                        'itemPrice_shippingTax_currency' => $shippingTax_currency ,
                        'itemFees_commission' => $commission ,
                        'itemFees_commission_currency' => $commission_currency ,
                    ]
                );
			}
		}
		return True;
	}

	public  function afterParse(){

	}

}