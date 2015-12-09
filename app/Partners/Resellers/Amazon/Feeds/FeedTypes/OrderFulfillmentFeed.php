<?php
namespace Alyya\Partners\Resellers\Amazon\Feeds\FeedTypes ;
use Alyya\Partners\Resellers\Amazon\Feeds\FeedType;

class OrderFulfillmentFeed extends FeedType {
	public $enumeration = '_POST_ORDER_FULFILLMENT_DATA_';
	public $countryCode;
	public $processingTimeEstimated = 17;

	function __construct() {
	}

	public function formatFeed() {//TODD
        /**  ?????
         *     if (condition) {
        $packages = current($value['packages']); // one package per feed ,file OrderFulfillment.xsd
        }
         */

        $orders = isset($this->data) ? $this->data : $this->getData();
        $messages = '';
        $messageID = 1;
        foreach ( $orders as $order ){
            $this->orderId_sent[] = $order->order_id ;
            $messages .="
						<Message>
					        <MessageID>$messageID</MessageID>
					        <OrderFulfillment>
					        <AmazonOrderID>$amazonOrderId</AmazonOrderID>
					        <MerchantFulfillmentID>".$packages['package_id']."</MerchantFulfillmentID>
					        <FulfillmentDate>".str_replace(" ","T",$packages['t_shipped']."-00:00")."</FulfillmentDate>
						    <FulfillmentData>
						    	<CarrierName>".$packages['carrier_name']."</CarrierName>
						    	<ShippingMethod>".$packages['shipping_method']."</ShippingMethod>
						    	<ShipperTrackingNumber>".$packages['transport_trackings']."</ShipperTrackingNumber>
						    </FulfillmentData>";
            $items = '';
            foreach ($order->items as $item) {
                $items .= "
							<Item>
								<AmazonOrderItemCode>".$item->amazonOrderItemCode."</AmazonOrderItemCode>
								<Quantity>".$item->quantity."</Quantity>
							</Item>";

            }
            $messages .= $items ;
            $messages .= "
							</OrderFulfillment>
					    </Message>";
            ++$messageID;
        }
		$feed = <<<EOD
<?xml version="1.0" encoding="UTF-8"?>
				<AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                				xsi:noNamespaceSchemaLocation="amzn-envelope.xsd">
    				<Header>
        				<DocumentVersion>1.01</DocumentVersion>
        				<MerchantIdentifier>A1VNMKJF5SG27E</MerchantIdentifier>
    				</Header>
   					<MessageType>OrderFulfillment</MessageType>
    				$messages
				</AmazonEnvelope>
EOD;
    				return $feed;
	}

	public function getData(){//TODD
	}

	public function afterFeed(){//TODD
	}
}
