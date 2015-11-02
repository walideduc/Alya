<?php
//http://support.selro.com/customer/portal/articles/912412-missing-attributes-standard_product_id-sku-does-not-match-any-asin
namespace alyya\Partners\Resellers\Resellers\Amazon\Feeds\FeedTypes ;
use alyya\Partners\Resellers\Resellers\Amazon\AmazonConfig;
use alyya\Partners\Resellers\Resellers\Amazon\Feeds\FeedType;
use Illuminate\Support\Facades\DB;

class DeleteProductFeed extends FeedType {
	public $enumeration = '_POST_PRODUCT_DATA_'; // it has the same value as AmazonMWS_Feeds_FeedTypes_ProductFeed but the <OperationType> tag in the feed is set to Delete
	public $countryCode;
	public $processingTimeEstimated = 15;

	function __construct() {
	}

	public function formatFeed() {
        $products = isset($this->data) ? $this->data : $this->getData();
        $messages = '';
        $messageID = 1;
        foreach ( $products as $product ){
            $this->sku_sent[] = $product->sku ;
            $messages .="
						<Message>
					        <MessageID>$messageID</MessageID>
					        <OperationType>Delete</OperationType>
					        <Product>
					            <SKU>".$product->sku.'</SKU>
					        </Product>
					    </Message>';
            ++$messageID;
        }
		$feed = <<<EOD
<?xml version="1.0" encoding="UTF-8"?>
				<AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                				xsi:noNamespaceSchemaLocation="amzn-envelope.xsd">
    				<Header>
        				<DocumentVersion>1.01</DocumentVersion>
        				<MerchantIdentifier>A278TDZ3N8K3EM</MerchantIdentifier>
    				</Header>
   					<MessageType>Product</MessageType>
    				$messages
				</AmazonEnvelope>
EOD;
    				//die($feed);
    				return $feed;
	}
	public function getData(){
        $table = self::getTableProductsName($this->countryCode);
        if (AmazonConfig::$development){
            $this->data = DB::table($table)->select('sku')->whereRaw(' to_delete = 1 ' )->take(5)->get();
        }else{
            $this->data = DB::table($table)->select('sku')->whereRaw(' to_delete = 1 ' )->get();
        }
        //dd($this->data);

        if(empty($this->data) ){
            return 0;
        }
        return 1;
	}
	public function afterFeed() {
        //dd($this->sku_sent);
        $table = self::getTableProductsName($this->countryCode);
        DB::table($table)->whereIn('sku',$this->sku_sent)->update([
            'to_delete' => 2 ,
        ]);
	}
}

