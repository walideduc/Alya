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
        dd($reportContents);
        DB::table('test_jobs')->insert(
            ['note_1' => 'getReport for '.$this->shortName, 'note_2' => 'report_id '.$this->reportId ]
        );
        return 1;
        $scheduledXMLOrderReport = new SimpleXMLElement($reportContents);
        foreach ($scheduledXMLOrderReport->Message as $message) {
            $orderReport = $message->OrderReport; // exists only once in the Message tag so we don't need a loop here
            $billingData = $orderReport->BillingData;
            $billing_address = $billingData->Address;

            $fulfillmentData = $orderReport->FulfillmentData;
            $fulfillment_address = $fulfillmentData->Address ;

            /* Patch pour les zip codes, trop souvent absents dans l'une ou l'autre des adresses */
            if(strtolower($billing_address->City) == strtolower($fulfillment_address->City))
            {
                if(empty($billing_address->PostalCode) && !empty($fulfillment_address->PostalCode))
                    $billing_address->PostalCode = $fulfillment_address->PostalCode ;

                if(empty($fulfillment_address->PostalCode) && !empty($billing_address->PostalCode))
                    $fulfillment_address->PostalCode = $billing_address->PostalCode ;
            }
            /*fin du patch*/


            $amazonOrderID = db::tern_filter($orderReport->AmazonOrderID);
            $amazonSessionID = db::tern_filter($orderReport->AmazonSessionID);
            $orderDate = $orderReport->OrderDate;
            $date = new DateTime($orderDate);
            $orderDate = $date->format('Y-m-d H:i:s');
            $orderPostedDate = $orderReport->OrderPostedDate ;
            $date = new DateTime($orderPostedDate);
            $orderPostedDate = $date->format('Y-m-d H:i:s');

            foreach ($orderReport->CustomerOrderInfo as $customerOrderInfo ) {//0..10
                $type = $customerOrderInfo->Type;
                $value = $customerOrderInfo->Value;
                $sql = " INSERT INTO `amazon_customerOrderInfo`(`AmazonOrderID`, `Type`, `Value`) VALUES ('$amazonOrderID','$type','$value') ";
                db::query($sql);
            }

            // parse billingData
            $buyerEmailAddress = db::tern_filter($billingData->BuyerEmailAddress) ;
            $buyerName = db::tern_filter($billingData->BuyerName) ;
            $buyerPhoneNumber = db::tern_filter($billingData->BuyerPhoneNumber) ;
            $creditCard = isset($billingData->CreditCard) ? $billingData->CreditCard : null ; // 0..1
            if (!is_null($creditCard)){
                $issuer = $creditCard->Issuer ;
                $tail = $creditCard->Tail ;
                $expirationDate = $creditCard->ExpirationDate ;
                $sql = " INSERT INTO `amazon_order_creditCard`(`amazonOrderID`, `issuer`, `tail`, `expirationDate`) VALUES ('$amazonOrderID','$issuer','$tail','$expirationDate') ";
                db::query($sql);
            }
            $billing_address_name = db::tern_filter($billing_address->Name) ;
            $billing_address_formalTitle = db::tern_filter($billing_address->FormalTitle) ; #
            $billing_address_givenName = db::tern_filter($billing_address->GivenName) ; #
            $billing_address_FamilyName = db::tern_filter($billing_address->FamilyName) ; #
            $billing_address_addressFieldOne = db::tern_filter($billing_address->AddressFieldOne) ;
            $billing_address_addressFieldTwo = db::tern_filter($billing_address->AddressFieldTwo) ;
            $billing_address_addressFieldThree = db::tern_filter($billing_address->AddressFieldThree) ; #
            $billing_address_city = db::tern_filter($billing_address->City) ;
            $billing_address_county = db::tern_filter($billing_address->County) ; #
            $billing_address_stateOrRegion = db::tern_filter($billing_address->StateOrRegion) ; #
            $billing_address_postalCode = db::tern_filter($billing_address->PostalCode) ;
            $billing_address_CountryCode= db::tern_filter($billing_address->CountryCode) ;
            $billing_address_PhoneNumber = db::tern_filter($billing_address->PhoneNumber) ;

            // parse fulfillmentData
            $fulfillmentMethod = db::tern_filter($fulfillmentData->FulfillmentMethod) ;
            $fulfillmentServiceLevel = db::tern_filter($fulfillmentData->FulfillmentServiceLevel);
            $fulfillment_address_name = db::tern_filter($fulfillment_address->Name);
            $fulfillment_address_formalTitle = db::tern_filter($fulfillment_address->FormalTitle);#
            $fulfillment_address_givenName = db::tern_filter($fulfillment_address->GivenName);#
            $fulfillment_address_familyName = db::tern_filter($fulfillment_address->FamilyName);#
            $fulfillment_address_addressFieldOne = db::tern_filter($fulfillment_address->AddressFieldOne) ;
            $fulfillment_address_addressFieldTwo= db::tern_filter($fulfillment_address->AddressFieldTwo);
            $fulfillment_address_addressFieldThree= db::tern_filter($fulfillment_address->AddressFieldThree);#
            $fulfillment_address_city = db::tern_filter($fulfillment_address->City) ;
            $fulfillment_address_county = db::tern_filter($fulfillment_address->County) ;#
            $fulfillment_address_stateOrRegion = db::tern_filter($fulfillment_address->StateOrRegion) ;#
            $fulfillment_address_postalCode = db::tern_filter($fulfillment_address->PostalCode);
            $fulfillment_address_countryCode = db::tern_filter($fulfillment_address->CountryCode) ;
            $fulfillment_address_phoneNumber = db::tern_filter($fulfillment_address->PhoneNumber) ;
            $documentID = isset($this->reportId) ? $this->reportId : '';
            // there is a unique constraint on AmazonOrderID .
            $sql = " INSERT INTO `amazon_orders`(`documentID`, `AmazonOrderID`, `AmazonSessionID`, `OrderDate`, `OrderPostedDate`, `BuyerEmailAddress`, `BuyerName`, `BuyerPhoneNumber`,
			 `BillingName`, `BillingFormalTitle`, `BillingGivenName`, `BillingFamilyName`, `BillingAddressFieldOne`, `BillingAddressFieldTwo`, `BillingAddressFieldThree`, `BillingCity`, `BillingCounty` , `BillingStateOrRegion`, `BillingPostalCode`, `BillingCountryCode`, `BillingPhoneNumber`,
			 `FulfillmentMethod`, `FulfillmentServiceLevel`, `FulfillmentName`, `FulfillmentFormalTitle`, `FulfillmentGivenName`, `FulfillmentFamilyName`, `FulfillmentAddressFieldOne`, `FulfillmentAddressFieldTwo`, `FulfillmentAddressFieldThree` ,`FulfillmentCity`, `FulfillmentCounty`, `FulfillmentStateOrRegion` ,`FulfillmentPostalCode`, `FulfillmentCountryCode`, `FulfillmentPhoneNumber`)
			VALUES ('$documentID','$amazonOrderID','$amazonSessionID','$orderDate','$orderPostedDate','$buyerEmailAddress','$buyerName','$buyerPhoneNumber',
			'$billing_address_name','$billing_address_formalTitle','$billing_address_givenName','$billing_address_FamilyName','$billing_address_addressFieldOne','$billing_address_addressFieldTwo','$billing_address_addressFieldThree','$billing_address_city','$billing_address_county','$billing_address_stateOrRegion','$billing_address_postalCode','$billing_address_CountryCode','$billing_address_PhoneNumber',
			'$fulfillmentMethod','$fulfillmentServiceLevel','$fulfillment_address_name','$fulfillment_address_formalTitle','$fulfillment_address_givenName','$fulfillment_address_familyName','$fulfillment_address_addressFieldOne','$fulfillment_address_addressFieldTwo','$fulfillment_address_addressFieldThree','$fulfillment_address_city','$fulfillment_address_county','$fulfillment_address_stateOrRegion',
			'$fulfillment_address_postalCode','$fulfillment_address_countryCode','$fulfillment_address_phoneNumber') ON DUPLICATE KEY UPDATE `documentID_doubled` = '$documentID' "; // ON DUPLICATE KEY UPDATE
            db::query($sql);



            /// items order
            foreach ($orderReport->Item as $item) {
                //print_r($item);
                $itemPrice = $item->ItemPrice ; // array
                $itemFees = $item->ItemFees->Fee ; // array

                $amazonOrderItemCode = db::tern_filter($item->AmazonOrderItemCode) ;
                $sku = db::tern_filter($item->SKU) ;
                $title = db::tern_filter($item->Title) ;
                $quantity = db::tern_filter($item->Quantity) ;
                $productTaxCode = db::tern_filter($item->ProductTaxCode);
                $itemPrice_array = array() ;
                foreach($itemPrice->Component as $component)
                {
                    // le couple (amazonOrderItemCode,type) est unique dans la table `amazon_ordered_products_prices`
                    $type = (string)$component->Type;
                    $amount = (string)$component->Amount;
                    $currency = (string)$component->Amount['currency'];
                    $itemPrice_array[$type] = $amount ;
                    $itemPrice_array[$type.'_currency'] = $currency ;
                    $sql = " INSERT INTO `amazon_ordered_products_prices`(`amazonOrderID`, `amazonOrderItemCode`, `type`, `amount`, `currency`)
					VALUES ('$amazonOrderID','$amazonOrderItemCode','$type',$amount,'$currency') ON DUPLICATE KEY UPDATE `AmazonOrderItemCode` = '$amazonOrderItemCode' ";
                    db::query($sql);
                }
                $principal = db::tern_filter($itemPrice_array['Principal']);
                $principal_currency = db::tern_filter($itemPrice_array['Principal_currency']);
                $shipping = db::tern_filter($itemPrice_array['Shipping']);
                $shipping_currency = db::tern_filter($itemPrice_array['Shipping_currency']);
                $tax = db::tern_filter($itemPrice_array['Tax']);
                $tax_currency = db::tern_filter($itemPrice_array['Tax_currency']);
                $shippingTax = db::tern_filter($itemPrice_array['ShippingTax']);
                $shippingTax_currency = db::tern_filter($itemPrice_array['ShippingTax_currency']);

                $itemFees_array = array() ;
                foreach($itemFees as $fee)
                {
                    // le couple (amazonOrderItemCode,type) est unique dans la table `amazon_ordered_products_amazon_fees`
                    $type = (string)$fee->Type;
                    $amount = (string)$fee->Amount ;
                    $currency = (string)$fee->Amount['currency'] ;
                    $itemFees_array[$type] = $amount ;
                    $itemFees_array[$type.'_currency'] = $currency ;
                    $sql = " INSERT INTO `amazon_ordered_products_amazon_fees`(`amazonOrderID`, `amazonOrderItemCode`, `type`, `amount`, `currency`)
					VALUES ('$amazonOrderID','$amazonOrderItemCode','$type',$amount,'$currency') ON DUPLICATE KEY UPDATE `AmazonOrderItemCode` = '$amazonOrderItemCode'  ";
                    echo $sql;
                    db::query($sql);
                }
                $commission = db::tern_filter($itemFees_array['Commission']) ;
                $commission_currency = db::tern_filter($itemFees_array['Commission_currency']) ;
                // AmazonOrderItemCode est unique
                $sql = " INSERT INTO `amazon_ordered_products`(`AmazonOrderID`, `AmazonOrderItemCode`, `SKU`, `Title`, `Quantity`, `ProductTaxCode`, `ItemPrice_Principal`, `ItemPrice_Principal_currency`, `ItemPrice_Shipping`, `ItemPrice_Shipping_currency`, `ItemPrice_Tax`, `ItemPrice_Tax_currency`, `ItemPrice_ShippingTax`, `ItemPrice_ShippingTax_currency`, `ItemFees_Commission`, `ItemFees_Commission_currency`)
														VALUES ('$amazonOrderID','$amazonOrderItemCode','$sku','$title',$quantity,'$productTaxCode','$principal','$principal_currency','$shipping','$shipping_currency','$tax','$tax_currency','$shippingTax','$shippingTax_currency','$commission','$commission_currency') ON DUPLICATE KEY UPDATE `AmazonOrderItemCode` = '$amazonOrderItemCode' " ; //
                db::query($sql);
            }
        }
        return True;
    }

    public  function afterParse(){

    }

}