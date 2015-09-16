<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 09/09/15
 * Time: 19:24
 */

namespace App\Partners\Resellers\Resellers\Amazon\Feeds\FeedTypes ;
use App\Partners\Resellers\Resellers\Amazon\AmazonConfig;
use App\Partners\Resellers\Resellers\Amazon\Feeds\FeedType ;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\DB;

class ProductFeed extends FeedType {
    use DispatchesJobs ;

    public $enumeration = '_POST_PRODUCT_DATA_';
    public $countryCode;
    public $processingTimeEstimated = 30;
    static $queuesCategory = 'feeds' ;

    function __construct() {
    }

    public function formatFeed(){
        $products = isset($this->data) ? $this->data : $this->getData();
        $messages = '';
        $i = 0;
        foreach ( $products as $product ){
            $this->sku_sent[] = $product->sku ;
            //dd($product);
            $messageID = $i+1;
            $messages .="
						<Message>
					        <MessageID>$messageID</MessageID>
					        <OperationType>PartialUpdate</OperationType>
					        <Product>
					            <SKU>".$product->sku.'</SKU>
					            <StandardProductID>
					                <Type>'.$product->ref_type.'</Type>
					                <Value>'.$product->ref_value.'</Value>
					            </StandardProductID>
					            <Condition>
					                <ConditionType>'.htmlspecialchars($product->condition_type).'</ConditionType>
					                <ConditionNote>'.htmlspecialchars($product->condition_note).'</ConditionNote>
					            </Condition>
					            <DescriptionData>
                					<Title>'.htmlspecialchars($product->name,ENT_QUOTES).'</Title>
                					<Brand>'.htmlspecialchars($product->brand,ENT_QUOTES).'</Brand>
                					<Description>'.htmlspecialchars($product->description,ENT_QUOTES).'</Description>
                					<Manufacturer>'.htmlspecialchars($product->manufacturer,ENT_QUOTES).'</Manufacturer>
            					</DescriptionData>
					        </Product>
					    </Message>';
        }
        $merchantIdentifier = AmazonConfig::getMerchantIdentifier($this->countryCode);
        $feed = <<<EOD
<?xml version="1.0" encoding="UTF-8"?>
				<AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                				xsi:noNamespaceSchemaLocation="amzn-envelope.xsd">
    				<Header>
        				<DocumentVersion>1.01</DocumentVersion>
        				<MerchantIdentifier>$merchantIdentifier</MerchantIdentifier>
    				</Header>
   					<MessageType>Product</MessageType>
    				$messages
				</AmazonEnvelope>
EOD;
        return $feed;

    }

    public function getData(){
        $table = self::getTableProductsName($this->countryCode);
        $this->data = DB::table($table)->whereRaw(' data_changed_at  > data_submitted_at ' )->take(1)->get();
        if(empty($this->data) ){
            return 0;
        }
        return 1;
    }

    /**
     * This function does the follow :
     * Set the data_submitted_at for the products sent in the feed.
     * Trigger the other required feed for the creation of the products.
     * Ask for an inventory report .
    */
    public function afterFeed(){
        //dd($this->sku_sent);
        $table = self::getTableProductsName($this->countryCode);
        DB::table($table)->whereIn('sku',$this->sku_sent)->update([
            'data_submitted_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'creation_failed' => 0 ,
        ]);

        $seconds = ($this->getProcessingTimeEstimated()+30) * 60 ;// For waiting that the creation failed in the table be set by the rest of the feeds functions
        $job = (new \App\Jobs\Resellers\Amazon\Feeds\TriggerOtherFeeds($this->countryCode))->onQueue(self::$queuesCategory)->delay($seconds);
        $this->dispatch($job);



    }
    public static function triggerOtherFeeds($countryCode){
        $table = self::getTableProductsName($countryCode);
        $now = \Carbon\Carbon::now();
        if($countryCode=='fr') // I know that the inventory, pricing , image feeds are handled on the same table .
        {
            $nowDateTime = $now->toDateTimeString();
            $yesterday = $now->subDay(1)->toDateTimeString();
            $res = DB::table($table)->whereRaw( " '$yesterday' < data_submitted_at < '$nowDateTime' " )
                ->where('creation_failed',0)->update([
                    'price_changed_at' =>  $nowDateTime,
                    'stock_changed_at' =>  $nowDateTime,
                    'image_changed_at' =>  $nowDateTime,
                ]);
            return $res;
        }else{
            // @Todo when adding the other amazon market place
        }

    }

}