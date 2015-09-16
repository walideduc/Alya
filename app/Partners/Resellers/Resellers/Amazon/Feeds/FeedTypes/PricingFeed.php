<?php

namespace App\Partners\Resellers\Resellers\Amazon\Feeds\FeedTypes ;
use App\Partners\Resellers\Resellers\Amazon\Feeds\FeedType ;

class PricingFeed extends FeedType {
	public $enumeration = '_POST_PRODUCT_PRICING_DATA_';
	public $countryCode;
	public $processingTimeEstimated = 10;

	function __construct() {
	}

	public function formatFeed(){
		$products = isset($this->products) ? $this->products : self::getData($this->countryCode);
		$nomberProducts = sizeof($products);
		for ($i = 0; $i < $nomberProducts; $i++) {
			$price = $products[$i]['StandardPrice_currency'];
			$messageID = $i+1;
			$messges .="
						<Message>
					        <MessageID>$messageID</MessageID>
					        <Price>
						        <SKU>".$products[$i]['SKU']."</SKU>
						        <StandardPrice currency=\"$price\">".$products[$i]['StandardPrice']."</StandardPrice>					        
					        </Price>    
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
					
					<MessageType>Price</MessageType>
					$messges
					</AmazonEnvelope>
EOD;
					return $feed;
	}
	
	
	public function getData(){
		$table = self::getTableNameFromCountryCode($countryCode);
		$what	= '`SKU` ,  `StandardPrice` , `StandardPrice_currency` ';
		$where	= " t_price_changed > t_price_submitted AND StandardPrice  != 0 AND price_lock = 0 LIMIT 20000 ";
		//echo ' $table  === '.$table,' $what  === '.$what,' $where  === '.$where;
		$products = AmazonMWS_Feeds_Feeds::getProducts($table ,$what , $where);
		return $products;
	}

	public function afterFeed(){
		$table = self::getTableNameFromCountryCode($this->countryCode);
		foreach ($this->products as $product) {
			$products_sku[] = $product['SKU'];
		}
		$date = new DateTime();
		$now = $date->format('Y-m-d H:i:s');
		$where = "SKU IN ('".implode("','", $products_sku)."')" ;
		$sql = " UPDATE `$table` SET  `t_price_submitted` =  '$now' WHERE ".$where ;
		db::query($sql);
	}

}