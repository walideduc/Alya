<?php
/**
 * Created by PhpStorm.
 * User: walid
 * Date: 13/11/15
 * Time: 10:43
 */
namespace Alyya\Partners\Resellers\Amazon\Products\PricingQualifiers;
use Illuminate\Support\Facades\DB;

class PricingQualifier extends AbstractPricingQualifier {
    public function getData(){
        $results = DB::table('amazon_products')->select('asin', 'sku')->whereRaw(' asin IS NOT NULL AND price_watched_at >= price_submitted_at AND price_watched_done = 0 ')->take(400)->get();
        foreach ( $results as $result ){
            $data[] = $result->asin;
            $skus[$result->asin] = $result->sku;
        }
        $this->data = $data;
        $this->skus = $skus;
        return $this->data;
    }
    public function afterSuccess($asin,$stockTest){
        dd($this);
    }

}