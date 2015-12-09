<?php

namespace Alyya\Partners\Resellers\Amazon\Feeds\FeedTypes ;
use Alyya\Partners\Resellers\Amazon\AmazonConfig;
use Alyya\Partners\Resellers\Amazon\Feeds\FeedType ;
use Illuminate\Support\Facades\DB;

class PricingFeed extends FeedType {
	public $enumeration = '_POST_PRODUCT_PRICING_DATA_';
	public $countryCode;
	public $processingTimeEstimated = 10;

	function __construct() {
	}

	public function formatFeed(){
        $products = isset($this->data) ? $this->data : $this->getData();
        $messages = '';
        $messageID = 1;
        //dd($this->data);
        foreach ( $products as $product ){
            $this->sku_sent[] = $product->sku ;
            $messages .="
						<Message>
					        <MessageID>$messageID</MessageID>
					        <Price>
						        <SKU>".$product->sku."</SKU>
						        <StandardPrice currency=\"$product->currency\">".$product->price."</StandardPrice>
					        </Price>
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
					
					<MessageType>Price</MessageType>
					$messages
					</AmazonEnvelope>
EOD;
					return $feed;
	}
	
	
	public function getData(){
        $table = self::getTableProductsName($this->countryCode);
        if (AmazonConfig::$development){
            $this->data = DB::table($table)->select('sku','price','currency')->whereRaw(' price_changed_at  > price_submitted_at ' )->take(5)->get();
        }else{
            $this->data = DB::table($table)->select('sku','price','currency')->whereRaw(' price_changed_at  > price_submitted_at ' )->get();
        }
        //dd($this->data);

        if(empty($this->data) ){
            return 0;
        }
        return 1;
	}

	public function afterFeed(){
        $table = self::getTableProductsName($this->countryCode);
        DB::table($table)->whereIn('sku',$this->sku_sent)->update([
            'price_submitted_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
	}

}