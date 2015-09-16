<?php
namespace App\Partners\Resellers\Resellers\Amazon\Reports\ReportTypes;
use App\Partners\Resellers\Resellers\Amazon\Reports\ReportType;

class InventoryReport extends ReportType {

	public $reportTypeEnumeration = '_GET_FLAT_FILE_OPEN_LISTINGS_DATA_' ;
	public $countryCode ;
	public $isScheduled = 0 ;

	function __construct() {
        parent::__construct(__CLASS__);
	}

	public  function parseReport($reportContents){		

		return True;
	}

	public  function afterParse(){

	}

	public static function update_catalog_from_inventory_report($countryCode) {
		if (in_array($countryCode, self::$countryCodes,true)) {
			$table = 'amazon_catalog_'.$countryCode;
			if ($countryCode === 'fr') {
				$table = 'amazon_catalog';
			}
		}else {
			die(' This value <b>'.$countryCode.'</b>  of countryCode is unknown  ,look at the class '.__CLASS__. ' in '.__FUNCTION__.' function at line '.__LINE__.'<br/>') ;
		}
		$today = date('Y-m-d 00:00:00');
		$sql = "UPDATE `$table` SET existence = 'non' ";
		db::query($sql);
		$sql = "UPDATE `$table` as c JOIN `amazon_inventory` as i ON c.`sku` = i.`sku` AND `existence` LIKE  'non' AND i.`t_inserted` >  '$today'
				AND  `countryCode` LIKE  '$countryCode' SET existence = 'oui' ";
		db::query($sql);
		$sql = "SELECT i.`sku` inventory_sku, i.`asin` inventory_asin, c.`sku` , c.`asin` , t_data_submitted,  `countryCode`
				FROM  `amazon_inventory` AS i
				JOIN `$table` AS c ON c.`sku` = i.`sku` 
				AND (i.`asin` <> c.`asin` OR c.`asin` IS NULL ) 
				AND  i.`t_inserted` >  '$today'
				AND  `countryCode` LIKE  '$countryCode'
				ORDER BY c.`sku` DESC ";
		echo $sql;
		$res = db::query($sql);
		$rows = array();
		while ($row = db::fetch_array($res))
		{
			$rows[] = $row;
		}
		print_r($rows);
		if (!empty($rows)) {
			$sql = " INSERT INTO `amazon_inventory_changed_asin`( `inventory_sku`, `new_asin`, `sku`, `old_asin`, `t_asin_changed`, `countryCode`) SELECT i.`sku` inventory_sku, i.`asin` inventory_asin, c.`sku` , c.`asin` , '$today',  `countryCode`
					FROM  `amazon_inventory` AS i
					JOIN `$table` AS c ON c.`sku` = i.`sku` 
					AND (i.`asin` <> c.`asin` OR c.`asin` IS NULL ) 
					AND  i.`t_inserted` >  '$today'
					AND  `countryCode` LIKE '$countryCode' ORDER BY c.`sku` DESC ";
			if (db::query($sql)) {
				$sql = "UPDATE `$table` as c JOIN `amazon_inventory` as i ON c.`sku` = i.`sku` AND (c.`asin` <> i.`asin` OR c.`asin` IS NULL ) AND i.`t_inserted` >  '$today'
				AND  `countryCode` LIKE  '$countryCode' SET c.`asin` = i.`asin`, existence = 'oui' ";
				db::query($sql);
				return 1;
			}else {
				return -2;
			}
		}else {
			return -1;
		}

		;
	}
}