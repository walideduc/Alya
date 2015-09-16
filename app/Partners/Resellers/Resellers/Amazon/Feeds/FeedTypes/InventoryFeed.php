<?php
namespace App\Partners\Resellers\Resellers\Amazon\Feeds\FeedTypes ;
use App\Partners\Resellers\Resellers\Amazon\Feeds\FeedType ;

class InventoryFeed extends FeedType {
	public $enumeration = '_POST_INVENTORY_AVAILABILITY_DATA_';
	public $countryCode;
	public $processingTimeEstimated = 15;

	function __construct($countryCode = 'fr' ,$array = null) {
		if (in_array($countryCode, self::$countryCodes,true)) {
			if (!is_null($array)) {
				if (isset($array[0]['SKU'],$array[0]['Quantity'])) {	//isset($array) && is_array($array) && !empty($array)
					$this->countryCode = $countryCode;
					$this->products = $array;
				}
				else {
					unset($this->products);
					die(" One of required informations is missed, check the fields in the sql query that generated the input array , also it might be the upper or lower case of your field's name ".',look at the class '.__CLASS__. ' in '.__FUNCTION__.' function at line '.__LINE__.'<br/>');
				}
			}
			else {
				$this->countryCode = $countryCode;// for the test of afterfeed I noticed that $this->countryCode have to be set first :)
				$this->products = self::getData($countryCode);
			}
		}
		else {
			die(" This value <b>'.$countryCode.'</b>  of countryCode is unknown ".',look at the class '.__CLASS__. ' in '.__FUNCTION__.' function at line '.__LINE__.'<br/>');
		}
	}


	public function formatFeed(){
		$products = isset($this->products) ? $this->products : self::getData($this->countryCode);
		//die();
		//return $products;
		$nomberProducts = sizeof($products);
		for ($i = 0; $i < $nomberProducts; $i++) {
			$messageID = $i+1;
			$messges .="
						<Message>
					        <MessageID>$messageID</MessageID>
					        <OperationType>Update</OperationType>
					        <Inventory>
					            <SKU>".$products[$i]['SKU']."</SKU>
					            <Quantity>".$products[$i]['Quantity']."</Quantity>	
						    </Inventory>
					       </Message>";
		}
		$feed = <<<EOD
<?xml version="1.0" encoding="UTF-8"?>
				<AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                				xsi:noNamespaceSchemaLocation="amzn-envelope.xsd">
    				<Header>
        				<DocumentVersion>1.01</DocumentVersion>
        				<MerchantIdentifier>A1VNMKJF5SG27E</MerchantIdentifier>
    				</Header>
   					<MessageType>Inventory</MessageType>
    				$messges
				</AmazonEnvelope>
EOD;
    				return $feed;
	}
	public function getData(){

	}

	public function afterFeed() {
	}
}