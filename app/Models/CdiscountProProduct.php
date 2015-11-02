<?php

namespace alyya\Models;

use Illuminate\Database\Eloquent\Model;

class CdiscountProProduct extends Model
{
    protected $primaryKey = 'ref_sku';
    protected $guarded = [];
    protected $deniedCategories = [];
    //
    //

    public function scopeProductAlreadyExist($query ,$ref_sku ,$ean = null  )
    {
        if(!is_null($ean)){
            return $query->where('ref_sku', $ref_sku)->where('ean', $ean);
        }
        return $query->where('ref_sku', $ref_sku);
    }

    public function scopeResetTable($query)
    {
        return $query->where('quantity','<>',0)->orWhere('is_new',1) ;
    }

    /**
     * Used to send catalog to products table
     * @param $query
     * @return mixed
     */
    public function scopeActualiseProductsTable($query)
    {
        return $query->where('quantity','<>',0)->whereNotIn('category_id', $this->deniedCategories) ;
    }
}
