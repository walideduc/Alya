<?php
      try {
              $response = $service->getLowestOfferListingsForASIN($request);
              $table = 'amazon_catalog_'.$countryCode;
              if ($countryCode == 'fr') {
              	$table = 'amazon_catalog';
              }
              $t_inserted = date("Y-m-d H:i:s"); //'2013-06-18 00:00:00'
                $getLowestOfferListingsForASINResultList = $response->getGetLowestOfferListingsForASINResult();
                foreach ($getLowestOfferListingsForASINResultList as $getLowestOfferListingsForASINResult) {
                if ($getLowestOfferListingsForASINResult->isSetStatus()) {
                   $r['status'] = $getLowestOfferListingsForASINResult->getStatus();
                	if ($r['status'] === 'ServerError') {
                		$d = date('Y-m-d');
						$sql = " INSERT INTO `zz_pricewatch_amazon_error_$countryCode`(`type`, `num`, `t_inserted`) VALUES ('ServerError',1,'$d') ON DUPLICATE KEY UPDATE `num` = `num`+ 1 ";
						debug($getLowestOfferListingsForASINResult);
						db::query($sql);
						
					}
                    if ($r['status'] === 'ClientError') {
                    	$d = date('Y-m-d 00:30:00');
						$sql = "INSERT INTO `zz_pricewatch_amazon_error_$countryCode`(`type`, `num`, `t_inserted`) VALUES ('ClientError',1,'$d') ON DUPLICATE KEY UPDATE `num` = `num`+ 1 ";
						db::query($sql);
						debug($getLowestOfferListingsForASINResult);
						//echo '<br/>'.' ClientError ';
						
					}
                } 
                    if ($getLowestOfferListingsForASINResult->isSetAllOfferListingsConsidered()) 
                    {
                    	$r['allOfferListingsConsidered'] = $getLowestOfferListingsForASINResult->getAllOfferListingsConsidered();
                    }
                    if ($getLowestOfferListingsForASINResult->isSetProduct()) { 
                        //echo("                Product\n");
                        $product = $getLowestOfferListingsForASINResult->getProduct();
                        if ($product->isSetIdentifiers()) { 
                            //echo("                    Identifiers\n");
                            $identifiers = $product->getIdentifiers();
                            if ($identifiers->isSetMarketplaceASIN()) { 
                                //echo("                        MarketplaceASIN\n");
                                $marketplaceASIN = $identifiers->getMarketplaceASIN();
                                if ($marketplaceASIN->isSetMarketplaceId()) 
                                {
                                    $r['product']['Identifiers']['MarketplaceASIN']['MarketplaceId'] = $marketplaceASIN->getMarketplaceId();
                                }
                                if ($marketplaceASIN->isSetASIN()) 
                                {
                                    $r['product']['Identifiers']['MarketplaceASIN']['ASIN'] = $marketplaceASIN->getASIN();
                                    $asin_to_find_sku =	$r['product']['Identifiers']['MarketplaceASIN']['ASIN'];
                                    $sku_found = $asin_vs_sku[trim($asin_to_find_sku)];
                                }
                            } 
                            if ($identifiers->isSetSKUIdentifier()) { 
                                //echo("                        SKUIdentifier\n");
                                $SKUIdentifier = $identifiers->getSKUIdentifier();
                                if ($SKUIdentifier->isSetMarketplaceId()) 
                                {
                                    $r['product']['Identifiers']['SKUIdentifier']['MarketplaceId'] = $SKUIdentifier->getMarketplaceId(); 
                                }
                                if ($SKUIdentifier->isSetSellerId()) 
                                {
                                    $r['product']['Identifiers']['SKUIdentifier']['SellerId'] = $SKUIdentifier->getSellerId();
                                }
                                if ($SKUIdentifier->isSetSellerSKU()) 
                                {
                                    $r['product']['Identifiers']['SKUIdentifier']['SellerSKU'] = $SKUIdentifier->getSellerSKU();
                                }
                            } 
                        } 
                        if ($product->isSetCompetitivePricing()) { 
                            //echo("                    CompetitivePricing\n");
                            $competitivePricing = $product->getCompetitivePricing();
                            if ($competitivePricing->isSetCompetitivePrices()) { 
                                //echo("                        CompetitivePrices\n");
                                $competitivePrices = $competitivePricing->getCompetitivePrices();
                                $competitivePriceList = $competitivePrices->getCompetitivePrice();
                                foreach ($competitivePriceList as $competitivePrice) {
                                    //echo("                            CompetitivePrice\n");
                                if ($competitivePrice->isSetCondition()) {
                                } 
                                if ($competitivePrice->isSetSubcondition()) {
                                } 
                                if ($competitivePrice->isSetBelongsToRequester()) {
                                } 
                                    if ($competitivePrice->isSetCompetitivePriceId()) 
                                    {
                                    }
                                    if ($competitivePrice->isSetPrice()) { 
                                        //echo("                                Price\n");
                                        $price = $competitivePrice->getPrice();
                                        if ($price->isSetLandedPrice()) { 
                                            //echo("                                    LandedPrice\n");
                                            $landedPrice = $price->getLandedPrice();
                                            if ($landedPrice->isSetCurrencyCode()) 
                                            {
                                            }
                                            if ($landedPrice->isSetAmount()) 
                                            {
                                            }
                                        } 
                                        if ($price->isSetListingPrice()) { 
                                            //echo("                                    ListingPrice\n");
                                            $listingPrice = $price->getListingPrice();
                                            if ($listingPrice->isSetCurrencyCode()) 
                                            {
                                            }
                                            if ($listingPrice->isSetAmount()) 
                                            {
                                                //echo("                                        Amount\n");
                                                //echo("                                            " . $listingPrice->getAmount() . "\n");
                                            }
                                        } 
                                        if ($price->isSetShipping()) { 
                                            //echo("                                    Shipping\n");
                                            $shipping = $price->getShipping();
                                            if ($shipping->isSetCurrencyCode()) 
                                            {
                                                //echo("                                        CurrencyCode\n");
                                                //echo("                                            " . $shipping->getCurrencyCode() . "\n");
                                            }
                                            if ($shipping->isSetAmount()) 
                                            {
                                                //echo("                                        Amount\n");
                                                //echo("                                            " . $shipping->getAmount() . "\n");
                                            }
                                        } 
                                    } 
                                }
                            } 
                            if ($competitivePricing->isSetNumberOfOfferListings()) { 
                                //echo("                        NumberOfOfferListings\n");
                                $numberOfOfferListings = $competitivePricing->getNumberOfOfferListings();
                                $offerListingCountList = $numberOfOfferListings->getOfferListingCount();
                                foreach ($offerListingCountList as $offerListingCount) {
                                    //echo("                            OfferListingCount\n");
                                if ($offerListingCount->isSetCondition()) {
                                    //echo("                        condition");
                                    //echo("\n");
                                    //echo("                                " . $offerListingCount->getCondition() . "\n");
                                } 
                                if ($offerListingCount->isSetValue()) {
                                    //echo("                        Value");
                                    //echo("\n");
                                    //echo("                                " . $offerListingCount->getValue() . "\n");
                                } 
                                }
                            } 
                            if ($competitivePricing->isSetTradeInValue()) { 
                                //echo("                        TradeInValue\n");
                                $tradeInValue = $competitivePricing->getTradeInValue();
                                if ($tradeInValue->isSetCurrencyCode()) 
                                {
                                    //echo("                            CurrencyCode\n");
                                    //echo("                                " . $tradeInValue->getCurrencyCode() . "\n");
                                }
                                if ($tradeInValue->isSetAmount()) 
                                {
                                    //echo("                            Amount\n");
                                    //echo("                                " . $tradeInValue->getAmount() . "\n");
                                }
                            } 
                        } 
                        if ($product->isSetSalesRankings()) { 
                            //echo("                    SalesRankings\n");
                            $salesRankings = $product->getSalesRankings();
                            $salesRankList = $salesRankings->getSalesRank();
                            foreach ($salesRankList as $salesRank) {
                                //echo("                        SalesRank\n");
                                if ($salesRank->isSetProductCategoryId()) 
                                {
                                    //echo("                            ProductCategoryId\n");
                                    //echo("                                " . $salesRank->getProductCategoryId() . "\n");
                                }
                                if ($salesRank->isSetRank()) 
                                {
                                    //echo("                            Rank\n");
                                    //echo("                                " . $salesRank->getRank() . "\n");
                                }
                            }
                        } 
                        if ($product->isSetLowestOfferListings()) { 
                            //echo("                    LowestOfferListings\n");
                            $lowestOfferListings = $product->getLowestOfferListings();
                            $lowestOfferListingList = $lowestOfferListings->getLowestOfferListing();
                            $lols = array();
                            $i = 0 ;
                            foreach ($lowestOfferListingList as $lowestOfferListing) {
                                //echo("                        LowestOfferListing\n");
                                if ($lowestOfferListing->isSetQualifiers()) { 
                                    //echo("                            Qualifiers\n");
                                    $qualifiers = $lowestOfferListing->getQualifiers();
                                    if ($qualifiers->isSetItemCondition()) 
                                    {
                                        //echo("                                ItemCondition\n");
                                        //echo("                                    " . $qualifiers->getItemCondition() . "\n");
                                        $lols[$i]['Qualifiers']['ItemCondition'] = $qualifiers->getItemCondition();
                                    }
                                    if ($qualifiers->isSetItemSubcondition()) 
                                    {
                                        //echo("                                ItemSubcondition\n");
                                        //echo("                                    " . $qualifiers->getItemSubcondition() . "\n");
                                        $lols[$i]['Qualifiers']['ItemSubcondition'] = $qualifiers->getItemSubcondition();
                                    }
                                    if ($qualifiers->isSetFulfillmentChannel()) 
                                    {
                                        //echo("                                FulfillmentChannel\n");
                                        //echo("                                    " . $qualifiers->getFulfillmentChannel() . "\n");
                                        $lols[$i]['Qualifiers']['FulfillmentChannel'] = $qualifiers->getFulfillmentChannel();
                                    }
                                    if ($qualifiers->isSetShipsDomestically()) 
                                    {
                                        //echo("                                ShipsDomestically\n");
                                        //echo("                                    " . $qualifiers->getShipsDomestically() . "\n");
                                        $lols[$i]['Qualifiers']['ShipsDomestically'] = $qualifiers->getShipsDomestically();
                                    }
                                    if ($qualifiers->isSetShippingTime()) { 
                                        //echo("                                ShippingTime\n");
                                        $shippingTime = $qualifiers->getShippingTime();
                                        if ($shippingTime->isSetMax()) 
                                        {
                                            //echo("                                    Max\n");
                                            //echo("                                        " . $shippingTime->getMax() . "\n");
                                            $lols[$i]['Qualifiers']['ShippingTime']['Max'] = $shippingTime->getMax();
                                        }
                                    } 
                                    if ($qualifiers->isSetSellerPositiveFeedbackRating()) 
                                    {
                                        //echo("                                SellerPositiveFeedbackRating\n");
                                        //echo("                                    " . $qualifiers->getSellerPositiveFeedbackRating() . "\n");
                                        $lols[$i]['Qualifiers']['SellerPositiveFeedbackRating'] = $qualifiers->getSellerPositiveFeedbackRating();
                                    }
                                } 
                                if ($lowestOfferListing->isSetNumberOfOfferListingsConsidered()) 
                                {
                                    //echo("                            NumberOfOfferListingsConsidered\n");
                                    //echo("                                " . $lowestOfferListing->getNumberOfOfferListingsConsidered() . "\n");
                                    $lols[$i]['NumberOfOfferListingsConsidered'] = $lowestOfferListing->getNumberOfOfferListingsConsidered();
                                }
                                if ($lowestOfferListing->isSetSellerFeedbackCount()) 
                                {
                                    //echo("                            SellerFeedbackCount\n");
                                    //echo("                                " . $lowestOfferListing->getSellerFeedbackCount() . "\n");
                                    $lols[$i]['SellerFeedbackCount'] = $lowestOfferListing->getSellerFeedbackCount();
                                }
                                if ($lowestOfferListing->isSetPrice()) { 
                                    //echo("                            Price\n");
                                    $price1 = $lowestOfferListing->getPrice();
                                    if ($price1->isSetLandedPrice()) { 
                                        //echo("                                LandedPrice\n");
                                        $landedPrice1 = $price1->getLandedPrice();
                                        if ($landedPrice1->isSetCurrencyCode()) 
                                        {
                                            //echo("                                    CurrencyCode\n");
                                            //echo("                                        " . $landedPrice1->getCurrencyCode() . "\n");
                                            $lols[$i]['Price']['LandedPrice']['CurrencyCode'] = $landedPrice1->getCurrencyCode();
                                        }
                                        if ($landedPrice1->isSetAmount()) 
                                        {
                                            //echo("                                    Amount\n");
                                            //echo("                                        " . $landedPrice1->getAmount() . "\n");
                                            $lols[$i]['Price']['LandedPrice']['Amount'] = $landedPrice1->getAmount();
                                        }
                                    } 
                                    if ($price1->isSetListingPrice()) { 
                                        //echo("                                ListingPrice\n");
                                        $listingPrice1 = $price1->getListingPrice();
                                        if ($listingPrice1->isSetCurrencyCode()) 
                                        {
                                            //echo("                                    CurrencyCode\n");
                                            //echo("                                        " . $listingPrice1->getCurrencyCode() . "\n");
                                            $lols[$i]['Price']['ListingPrice']['CurrencyCode'] = $listingPrice1->getCurrencyCode();
                                        }
                                        if ($listingPrice1->isSetAmount()) 
                                        {
                                            //echo("                                    Amount\n");
                                            //echo("                                        " . $listingPrice1->getAmount() . "\n");
                                            $lols[$i]['Price']['ListingPrice']['Amount'] = $listingPrice1->getAmount(); 
                                        }
                                    } 
                                    if ($price1->isSetShipping()) { 
                                        //echo("                                Shipping\n");
                                        $shipping1 = $price1->getShipping();
                                        if ($shipping1->isSetCurrencyCode()) 
                                        {
                                            //echo("                                    CurrencyCode\n");
                                            //echo("                                        " . $shipping1->getCurrencyCode() . "\n");
                                            $lols[$i]['Price']['Shipping']['CurrencyCode'] = $shipping1->getCurrencyCode();
                                        }
                                        if ($shipping1->isSetAmount()) 
                                        {
                                            //echo("                                    Amount\n");
                                            //echo("                                        " . $shipping1->getAmount() . "\n");
                                            $lols[$i]['Price']['Shipping']['Amount'] = $shipping1->getAmount();
                                        }
                                    } 
                                } 
                                if ($lowestOfferListing->isSetMultipleOffersAtLowestPrice()) 
                                {
                                    //echo("                            MultipleOffersAtLowestPrice\n");
                                    //echo("                                " . $lowestOfferListing->getMultipleOffersAtLowestPrice() . "\n");
                                    $lols[$i]['MultipleOffersAtLowestPrice'] = $lowestOfferListing->getMultipleOffersAtLowestPrice();
                                }
                                $i++;
                            }
                            $r['product']['LowestOfferListings'] = $lols;
	                        if(empty($lols))
							{
							     $sql = " INSERT INTO `zz_pricewatch_amazon_without_lowest_prices_$countryCode`(`ASIN`, `t_inserted`) VALUES ( '".$r['product']['Identifiers']['MarketplaceASIN']['ASIN']."','".$t_inserted."') ON DUPLICATE KEY UPDATE `t_inserted` = '".$t_inserted."'";
							     db::query($sql);
							}
                            //echo "<pre>";
                            //print_r($r);
                            //echo "</pre>";
                            
                            #####################################################
                            #													#
                            # 			Insertion à la base de données 			#
                            #													#
                            #####################################################
                            $status = $r['status'];
                            $allOfferListingsConsidered = $r['allOfferListingsConsidered'];
                            $marketplaceId = $r['product']['Identifiers']['MarketplaceASIN']['MarketplaceId'];
                            $asin = $r['product']['Identifiers']['MarketplaceASIN']['ASIN'];
                            $sellerId = $r['product']['Identifiers']['SKUIdentifier']['SellerId'];
                            $sellerSKU = $r['product']['Identifiers']['SKUIdentifier']['SellerSKU'];
                            //$values = "'".$status."','".$allOfferListingsConsidered."','".$marketplaceId."','".$asin."','".$sellerId."','".$sellerSKU;
                            $n = 1;
                            $s = sizeof($lols);
                            foreach ($lols as $lol) {
                            	$values = "'".$t_inserted."','".$status."','".$allOfferListingsConsidered."','".$marketplaceId."','".$asin."','".$sellerId."','".$sku_found ;
                            	$sql = '';
                            	//echo "<pre>";
                            	//print_r($lol);
                            	//echo "</pre>";
                            	//die();
                            	$itemCondition = $lol['Qualifiers']['ItemCondition'];
                            	$itemSubcondition = $lol['Qualifiers']['ItemSubcondition'];
                            	$fulfillmentChannel = $lol['Qualifiers']['FulfillmentChannel'];
                            	$shipsDomestically = $lol['Qualifiers']['ShipsDomestically'];
                            	$shippingTime = $lol['Qualifiers']['ShippingTime']['Max'];
                            	$SellerPositiveFeedbackRating = $lol['Qualifiers']['SellerPositiveFeedbackRating'];
                            	$numberOfOfferListingsConsidered = $lol['NumberOfOfferListingsConsidered'];
                            	$sellerFeedbackCount = $lol['SellerFeedbackCount'];
                            	$landedPrice_CurrencyCode = $lol['Price']['LandedPrice']['CurrencyCode'];
                            	$landedPrice_Amount = isset($lol['Price']['LandedPrice']['Amount']) ? $lol['Price']['LandedPrice']['Amount'] : -2 ;
                            	/*For some reason, in amazon flow there is some products without landed Price and shipping price informations ( often there's at least 0) 
                            	 * which affects the order of lowest prices ,so to distinct this case i set $shipping_Amount,  $landedPrice_Amount to -2 .*/
                            	$listingPrice_CurrencyCode = $lol['Price']['ListingPrice']['CurrencyCode'];
                            	$listingPrice_Amount = $lol['Price']['ListingPrice']['Amount'];
                            	$shipping_CurrencyCode = $lol['Price']['Shipping']['CurrencyCode'];
                            	$shipping_Amount = isset($lol['Price']['Shipping']['Amount']) ? $lol['Price']['Shipping']['Amount'] : -2 ;
                            	$multipleOffersAtLowestPrice = $lol['MultipleOffersAtLowestPrice'];
                            	$num_offre = $n.'/'.$s;                            	
                            	$values .= "','".$itemCondition."','".$itemSubcondition."','".$fulfillmentChannel."','".$shipsDomestically."','".
                            	$shippingTime."','".$SellerPositiveFeedbackRating."',".$numberOfOfferListingsConsidered.",".$sellerFeedbackCount.",'".
                            	$landedPrice_CurrencyCode."',".$landedPrice_Amount.",'".$listingPrice_CurrencyCode."',".$listingPrice_Amount.",'".
                            	$shipping_CurrencyCode."',".$shipping_Amount.",'".$multipleOffersAtLowestPrice."','".$num_offre."'";
                            	#####################################################
                            	#		table pricewatch_test_amazon				#
                            	#####################################################
                            	/*$sql = 'INSERT INTO `pricewatch_test_amazon`( `t_inserted`,`status`, `allOfferListingsConsidered`, `MarketplaceId`,
                             	`ASIN`, `SellerId`, `SellerSKU`, `ItemCondition`, `ItemSubcondition`, `FulfillmentChannel`, 
                             	`ShipsDomestically`, `ShippingTime`, `SellerPositiveFeedbackRating`, `NumberOfOfferListingsConsidered`,
                              	`SellerFeedbackCount`, `LandedPrice_CurrencyCode`, `LandedPrice_Amount`, `ListingPrice_CurrencyCode`,
                               	`ListingPrice_Amount`, `Shipping_CurrencyCode`, `Shipping_Amount`, `MultipleOffersAtLowestPrice`, `num_offre`)
                            		 VALUES ('.$values.')';
                            	//die($sql);
                            	////echo "<br/>".$sql."<br/>";
                            	
                                if (!db::query($sql)) {
                            		//echo '<br/>'.' fuck '.$sql;
                            	}*/
                            	###########################################################################################
                            	#		table pricewatch_amazon_fr_prices qui contient les prix les plus bas			#
                            	###########################################################################################
                            	$shipping_price = $shipping_Amount * 100 ;
                            	$price = $listingPrice_Amount * 100 ;
                            	$shop_name = 'Vendeur '.$num_offre;
                                if ($fulfillmentChannel==='Amazon') {
                            		$shipping_price = -1;
                            		if ($landedPrice_Amount < 25 ) {
                            			$shipping_price = 279;/*LIVRAISON GRATUITE pour fulfillmentChannel = amazon à partir de 25,00 d'achats, else le client 
                            									 paye 2.79 pour le unique article acheté
                            									 cette info n'est pas dans la reponse d'amazon 
                            									  */
                            			$shipping_Amount = 2.79;
                            		}
                            	}
                            	$values2 = "'".$asin."','".$t_inserted."',".$n.",'".$shop_name."',".$price.",".$shipping_price.",'".
                            	$status."','".$allOfferListingsConsidered."','".$marketplaceId."','".$sellerId."','".$sku_found."','".
                            	$itemCondition."','".$itemSubcondition."','".$fulfillmentChannel."','".$shipsDomestically."','".$shippingTime."','".
                            	$SellerPositiveFeedbackRating."',".$numberOfOfferListingsConsidered.",".$sellerFeedbackCount.",'".
                            	$landedPrice_CurrencyCode."',".$landedPrice_Amount.",'".$listingPrice_CurrencyCode."',".
                            	$listingPrice_Amount.",'".$shipping_CurrencyCode."',".$shipping_Amount.",'".$multipleOffersAtLowestPrice."'" ;
                            	
                            	$sql = "INSERT INTO `zz_pricewatch_amazon_prices_$countryCode`(`remote_id`, `t_inserted`, `position`,`shop_name`,
                            	`price`, `shipping_price`, `status`, `allOfferListingsConsidered`, `MarketplaceId`, `SellerId`,
                            	`SellerSKU`, `ItemCondition`, `ItemSubcondition`, `FulfillmentChannel`, 
                            	`ShipsDomestically`, `ShippingTime`, `SellerPositiveFeedbackRating`, `NumberOfOfferListingsConsidered`,
                            	 `SellerFeedbackCount`, `LandedPrice_CurrencyCode`, `LandedPrice_Amount`,
                            	 `ListingPrice_CurrencyCode`, `ListingPrice_Amount`, `Shipping_CurrencyCode`,
                            	  `Shipping_Amount`, `MultipleOffersAtLowestPrice`) VALUES (".$values2.')';
                            	////echo "<br/>".$sql."<br/>";
                            	//die();
                                if (!db::query($sql)) {
                                	//echo '<br/>'.' fuck '.$sql;
                                }
                            	##########################################################################################################
                            	#		table pricewatch_amazon_fr_products	qui contient le prix le plus bas juste une seul pour chaque produit #
                            	#####################################################
                            	if ($n === 1) {
                            		$price = $landedPrice_Amount * 100 ;
                            		$top_price = $listingPrice_Amount * 100 ;
                            		$top_shipping_price = $shipping_Amount * 100 ;
                            		$values = "'".$asin."','".$sku_found."',".$price.",".$top_price.",".$top_shipping_price.",'".$t_inserted."'";
                            		$on_duplicate = "`product_id` = ".$sku_found.", `price` = ".$price. ",`top_price` = ".$top_price .", `top_shipping_price` = ".$top_shipping_price.", `t_updated` = '".$t_inserted."'";
                            		$sql = "INSERT INTO `zz_pricewatch_amazon_products_$countryCode`(`remote_id`, `product_id`, 
                            		`price`, `top_price`, `top_shipping_price`, `t_updated`)
                            		 VALUES (".$values.') ON DUPLICATE KEY UPDATE '.$on_duplicate ;
                            		if (!db::query($sql)) {
                            			//echo '<br/>'.' fuck '.$sql;
                            		}
                            	}
                            	$n++;
                            }
                            if ($status == 'Success') {
                            	$sql = " UPDATE `$table` SET `t_watched_price`= '$t_inserted' WHERE `ASIN` = '$asin' AND SKU = $sku_found "  ;
                            	//debug($sql);
                            	db::query($sql);
                            }
                            
                            
                            
                            
                            
                            
                            
                        } 
                        if ($product->isSetOffers()) { 
                            //echo("                    Offers\n");
                            $offers = $product->getOffers();
                            $offerList = $offers->getOffer();
                            foreach ($offerList as $offer) {
                                //echo("                        Offer\n");
                                if ($offer->isSetBuyingPrice()) { 
                                    //echo("                            BuyingPrice\n");
                                    $buyingPrice = $offer->getBuyingPrice();
                                    if ($buyingPrice->isSetLandedPrice()) { 
                                        //echo("                                LandedPrice\n");
                                        $landedPrice2 = $buyingPrice->getLandedPrice();
                                        if ($landedPrice2->isSetCurrencyCode()) 
                                        {
                                            //echo("                                    CurrencyCode\n");
                                            //echo("                                        " . $landedPrice2->getCurrencyCode() . "\n");
                                        }
                                        if ($landedPrice2->isSetAmount()) 
                                        {
                                            //echo("                                    Amount\n");
                                            //echo("                                        " . $landedPrice2->getAmount() . "\n");
                                        }
                                    } 
                                    if ($buyingPrice->isSetListingPrice()) { 
                                        //echo("                                ListingPrice\n");
                                        $listingPrice2 = $buyingPrice->getListingPrice();
                                        if ($listingPrice2->isSetCurrencyCode()) 
                                        {
                                            //echo("                                    CurrencyCode\n");
                                            //echo("                                        " . $listingPrice2->getCurrencyCode() . "\n");
                                        }
                                        if ($listingPrice2->isSetAmount()) 
                                        {
                                            //echo("                                    Amount\n");
                                            //echo("                                        " . $listingPrice2->getAmount() . "\n");
                                        }
                                    } 
                                    if ($buyingPrice->isSetShipping()) { 
                                        //echo("                                Shipping\n");
                                        $shipping2 = $buyingPrice->getShipping();
                                        if ($shipping2->isSetCurrencyCode()) 
                                        {
                                            //echo("                                    CurrencyCode\n");
                                            //echo("                                        " . $shipping2->getCurrencyCode() . "\n");
                                        }
                                        if ($shipping2->isSetAmount()) 
                                        {
                                            //echo("                                    Amount\n");
                                            //echo("                                        " . $shipping2->getAmount() . "\n");
                                        }
                                    } 
                                } 
                                if ($offer->isSetRegularPrice()) { 
                                    //echo("                            RegularPrice\n");
                                    $regularPrice = $offer->getRegularPrice();
                                    if ($regularPrice->isSetCurrencyCode()) 
                                    {
                                        //echo("                                CurrencyCode\n");
                                        //echo("                                    " . $regularPrice->getCurrencyCode() . "\n");
                                    }
                                    if ($regularPrice->isSetAmount()) 
                                    {
                                        //echo("                                Amount\n");
                                        //echo("                                    " . $regularPrice->getAmount() . "\n");
                                    }
                                } 
                                if ($offer->isSetFulfillmentChannel()) 
                                {
                                    //echo("                            FulfillmentChannel\n");
                                    //echo("                                " . $offer->getFulfillmentChannel() . "\n");
                                }
                                if ($offer->isSetItemCondition()) 
                                {
                                    //echo("                            ItemCondition\n");
                                    //echo("                                " . $offer->getItemCondition() . "\n");
                                }
                                if ($offer->isSetItemSubCondition()) 
                                {
                                    //echo("                            ItemSubCondition\n");
                                    //echo("                                " . $offer->getItemSubCondition() . "\n");
                                }
                                if ($offer->isSetSellerId()) 
                                {
                                    //echo("                            SellerId\n");
                                    //echo("                                " . $offer->getSellerId() . "\n");
                                }
                                if ($offer->isSetSellerSKU()) 
                                {
                                    //echo("                            SellerSKU\n");
                                    //echo("                                " . $offer->getSellerSKU() . "\n");
                                }
                            }
                        } 
                    } 
                    if ($getLowestOfferListingsForASINResult->isSetError()) { 
                        //echo("                Error\n");
                        $error = $getLowestOfferListingsForASINResult->getError();
                        if ($error->isSetType()) 
                        {
                            //echo("                    Type\n");
                            //echo("                        " . $error->getType() . "\n");
                        }
                        if ($error->isSetCode()) 
                        {
                            //echo("                    Code\n");
                            //echo("                        " . $error->getCode() . "\n");
                        }
                        if ($error->isSetMessage()) 
                        {
                            //echo("                    Message\n");
                            //echo("                        " . $error->getMessage() . "\n");
                        }
                    } 
                    //echo "</fieldset>";
                }
                if ($response->isSetResponseMetadata()) { 
                    //echo("            ResponseMetadata\n");
                    $responseMetadata = $response->getResponseMetadata();
                    if ($responseMetadata->isSetRequestId()) 
                    {
                        //echo("                RequestId\n");
                        //echo("                    " . $responseMetadata->getRequestId() . "\n");
                    }
                } 

              //echo("            ResponseHeaderMetadata: " . $response->getResponseHeaderMetadata() . "\n");
     } catch (MarketplaceWebServiceProducts_Exception $ex) {
     	/*
     	if ($ex->getStatusCode() == 503){
			$sql = "  UPDATE `tasks` SET `t_started`='0000-00-00 00:00:00',`t_done`='0000-00-00 00:00:00',`result`=-15
					  WHERE  `method` LIKE  'ListLowestOfferListingsForASINBy400' AND 
					  `t_to_start` < NOW() AND `t_started` IS NULL AND `t_done` IS NULL  AND `result` IS NULL  ";
			
		}*/
         //echo("Caught Exception: " . $ex->getMessage() . "<br/>");
         $messageException = $ex->getMessage();
         debug($messageException);
         //echo("Response Status Code: " . $ex->getStatusCode() . "<br/>");
         $statusCodeException = $ex->getStatusCode();
         //echo("Error Code: " . $ex->getErrorCode() . "<br/>");
         $errorCodeException = $ex->getErrorCode();
         //echo("Error Type: " . $ex->getErrorType() . "<br/>");
         $errorTypeException = $ex->getErrorType();
         //echo("Request ID: " . $ex->getRequestId() . "<br/>");
         $requestIdException = $ex->getRequestId(); 
         //echo("XML: " . $ex->getXML() . "\n");
         $xmlException = $ex->getXML();
         //echo("ResponseHeaderMetadata: " . $ex->getResponseHeaderMetadata() . "<br/>");
         $responseHeaderMetadataException = $ex->getResponseHeaderMetadata();
         $ASINListException = $request->getASINList(); 
         $asinvalueException = $ASINListException->getASIN();
         $asinvalueException = serialize($asinvalueException);
         $requestException = serialize($request);        
         $serviceException = serialize($service);
         $sql = "INSERT INTO `amazon_mws_error`(`message`, `statusCode`, `errorCode`, `errorType`, 
         `requestId`, `xml`, `responseHeaderMetadata`, `class`, `fonction`,`file`,`asinArray`,`request`,`service`,`countryCode`) 
         VALUES ('".$messageException."','".$statusCodeException."','".$errorCodeException."','".$errorTypeException."','".$requestIdException."','"
         .$xmlException."','".$responseHeaderMetadataException."','AmazonMWS_Products_Products','ListLowestOfferListingsForASINBy400ForAll','".__FILE__."','".$asinvalueException."','".$requestException."','".$serviceException."','".$countryCode."')";
         db::query($sql); 
         //return 0; 
     }
