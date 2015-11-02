<?php
namespace alyya\Partners\Resellers\Resellers\Amazon\Feeds\FeedTypes ;
use alyya\Partners\Resellers\Resellers\Amazon\AmazonConfig;
use alyya\Partners\Resellers\Resellers\Amazon\Feeds\FeedType ;
use Illuminate\Support\Facades\DB;

class InventoryFeed extends FeedType {
	public $enumeration = '_POST_INVENTORY_AVAILABILITY_DATA_';
	public $countryCode;
	public $processingTimeEstimated = 15;

	function __construct() {
    }


	public function formatFeed(){
        $products = isset($this->data) ? $this->data : $this->getData();
        $messages = '';
        $messageID = 1;
        foreach ( $products as $product ){
            $this->sku_sent[] = $product->sku ;
            $messages .="
						<Message>
					        <MessageID>$messageID</MessageID>
					        <OperationType>Update</OperationType>
					        <Inventory>
					            <SKU>".$product->sku."</SKU>
					            <Quantity>".$product->quantity."</Quantity>
						    </Inventory>
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
   					<MessageType>Inventory</MessageType>
    				$messages
				</AmazonEnvelope>
EOD;
    				return $feed;
	}
	public function getData(){
        $table = self::getTableProductsName($this->countryCode);
        if (AmazonConfig::$development){
            $this->data = DB::table($table)->select('sku','quantity')->whereRaw(' stock_changed_at  > stock_submitted_at ' )->take(5)->get();
        }else{
            $this->data = DB::table($table)->select('sku','quantity')->whereRaw(' stock_changed_at  > stock_submitted_at ' )->get();
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
            'stock_submitted_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
	}
}