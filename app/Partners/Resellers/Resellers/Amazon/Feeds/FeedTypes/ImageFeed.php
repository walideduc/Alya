<?php
/**
 * All image feeds in the table below have the same behavior. Image feeds map images to ASINs in the provided
 marketplaces. If no marketplace IDs are specified, the feed is applied to all marketplaces that the seller is registered
 in and that are in the same country as the seller's original marketplace registration.
 */
namespace alyya\Partners\Resellers\Resellers\Amazon\Feeds\FeedTypes ;
use alyya\Partners\Resellers\Resellers\Amazon\AmazonConfig;
use alyya\Partners\Resellers\Resellers\Amazon\Feeds\FeedType;
use Illuminate\Support\Facades\DB;

class ImageFeed extends FeedType {
	public $enumeration = '_POST_PRODUCT_IMAGE_DATA_';
	public $countryCode;
	public $processingTimeEstimated = 45;
	public $products;

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
					        <OperationType>Update</OperationType>
					        <ProductImage>
					            <SKU>".$product->sku.'</SKU>
					            <ImageType>Main</ImageType>
					            <ImageLocation>'.$product->image_url.'</ImageLocation>
					        </ProductImage>
					    </Message>';
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
   					<MessageType>ProductImage</MessageType>
    				$messages
				</AmazonEnvelope>
EOD;
    				return $feed;
	}
	public function getData(){
        $table = self::getTableProductsName($this->countryCode);
        if (AmazonConfig::$development){
            $this->data = DB::table($table)->select('sku','image_url')->whereRaw(' image_changed_at  > image_submitted_at ' )->take(5)->get();
        }else{
            $this->data = DB::table($table)->select('sku','image_url') ->whereRaw(' image_changed_at  > image_submitted_at ' )->get();
        }
        //dd($this->data);

        if(empty($this->data) ){
            return 0;
        }
        return 1;
	}

	public function afterFeed(){
        //dd($this->sku_sent);
        $table = self::getTableProductsName($this->countryCode);
        DB::table($table)->whereIn('sku',$this->sku_sent)->update([
            'image_submitted_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
	}
}

