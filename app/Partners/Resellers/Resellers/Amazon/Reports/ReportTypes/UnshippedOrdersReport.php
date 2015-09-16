<?php
class AmazonMWS_Reports2014_ReportTypes_UnshippedOrdersReport extends ReportType {
	// ex: reportId = 39941824364 , requestId = 9669031384
	public $reportTypeEnumeration = '_GET_FLAT_FILE_ACTIONABLE_ORDER_DATA_' ;
	public $countryCode ;
	public $isScheduled = 0 ;
	public $reportOptions = 'ShowSalesChannel=true' ;

	function __construct($countryCode = 'fr') {
		parent::__construct($countryCode);
	}

	public  function parseReport($reportContents){
		debug("parseReport");
		$t_inserted = date('Y-m-d H:i:s');
		$reportContents = explode("\r\n", $reportContents);
		//var_dump($reportContents);
		$s = sizeof($reportContents) - 1; // on neglige la premiere ligne .
		for ($i = 1; $i < $s; $i++) {// $i = 1 parce que je la premier ligne ( sku asin price quantity )
			$ligne[$i] = explode("\t", $reportContents[$i]);
			$amazonOrdersNotShipped [$ligne[$i][0]][$ligne[$i][1]] = array('days-past-promise' => $ligne[$i][6],'sku' => $ligne[$i][10],'quantity-purchased' => $ligne[$i][12],'quantity-shipped' =>$ligne[$i][13],'quantity-to-ship' =>$ligne[$i][14]); //$ligne[$i][0] <=>
		}
		//debug($amazonOrdersNotShipped);
		$sql = " SELECT code, carrier_name, shipping_method FROM  `transport_cdpro` WHERE 1 " ;
		$res = db::query($sql) ;
		while ($row = db::fetch_array($res))
		{
			$transport[$row['code']] = array('carrier_name'=>$row['carrier_name'],'shipping_method'=>$row['shipping_method']);
		}
		//debug($transport);
		$amazonOdrderIds = array_keys($amazonOrdersNotShipped);
		//debug($amazonOdrderIds);
		$amazonOdrderIdsString = "'".implode("','", $amazonOdrderIds)."'";
		debug($amazonOdrderIdsString);
		//debug($amazonOdrderIdsString);
		//$amazonOdrderIdsString = "'402-4662110-7072323'"; 
		$table =  " amazon_orders INNER JOIN packages INNER JOIN objects INNER JOIN amazon_ordered_products ON amazon_orders.llr_order_id = packages.order_id AND objects.package_id = packages.package_id AND objects.product_id = amazon_ordered_products.sku AND amazon_orders.AmazonOrderID = amazon_ordered_products.AmazonOrderID ";
		$champs = " amazon_orders.AmazonOrderID, packages.order_id, objects.package_id , product_id ,count(*) as quantity ,packages.t_shipped, packages.transport_trackings, packages.transport_code, AmazonOrderItemCode   ";
		//$where = " amazon_orders.AmazonOrderID in (".$amazonOdrderIdsString.") AND packages.t_shipped IS NOT NULL group by objects.package_id ,product_id  ";
		//  t_sent_to_amazon is used to ditinct the package that was adcknoleged for an order that have many packges .
		//$where = " amazon_orders.AmazonOrderID in (".$amazonOdrderIdsString.") AND packages.t_shipped IS NOT NULL AND t_sent_to_amazon IS NULL group by objects.package_id ,product_id  ";
		$where = " amazon_orders.AmazonOrderID in (".$amazonOdrderIdsString.") AND packages.t_shipped IS NOT NULL group by objects.package_id ,product_id  ";	
		$sql = " SELECT $champs FROM $table WHERE $where "; 
		debug($sql);
		$res = db::query($sql) ;
		while ($row = db::fetch_array($res))
		{	
			$shippedOrders[$row['AmazonOrderID']]['order_id'] = $row['AmazonOrderID'] ;
			$shippedOrders[$row['AmazonOrderID']]['order_id_intern'] = $row['order_id'] ;
			$shippedOrders[$row['AmazonOrderID']]['packages'][$row['package_id']]['package_id'] = $row['package_id'] ;
			$shippedOrders[$row['AmazonOrderID']]['packages'][$row['package_id']]['t_shipped'] = $row['t_shipped'] ;
			$shippedOrders[$row['AmazonOrderID']]['packages'][$row['package_id']]['transport_code'] = $row['transport_code'] ;
			$shippedOrders[$row['AmazonOrderID']]['packages'][$row['package_id']]['carrier_name'] = $transport[$row['transport_code']]['carrier_name'] ;
			$shippedOrders[$row['AmazonOrderID']]['packages'][$row['package_id']]['shipping_method'] = $transport[$row['transport_code']]['shipping_method'] ;	
			$shippedOrders[$row['AmazonOrderID']]['packages'][$row['package_id']]['transport_trackings'] = $row['transport_trackings'] ;
			$shippedOrders[$row['AmazonOrderID']]['packages'][$row['package_id']]['products'][$row['product_id']]= array( 'AmazonOrderItemCode'=>$row['AmazonOrderItemCode'], 'quantity'=>$row['quantity']); 
		}
		debug($shippedOrders);
		if (!empty($shippedOrders)) {
			$orderFulfillmentFeed = new AmazonMWS_Feeds_FeedTypes_OrderFulfillmentFeed($this->countryCode,$shippedOrders);
			$orderFulfillmentFeed->triggerUnshippedOrdersReportId = $this->reportId ;
			$feed_submit_id = AmazonMWS_Feeds_Feeds::SubmitFeed($orderFulfillmentFeed);
			$this->feedSubmitId = $feed_submit_id ;
			echo $orderFulfillmentFeed->formateFeed();			
			debug($orderFulfillmentFeed);
			debug($this);
		}
		return True;

	}

	public  function afterParse(){

	}

}