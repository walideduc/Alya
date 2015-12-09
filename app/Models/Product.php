<?php

namespace Alyya\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Product extends Model
{
    protected $guarded = [];
    //protected $dates = ['deleted_at'];
    static $deniedCategoriesInAmazon = [1,2,5,9,8,4,3];
    static $deniedCategoriesInAlyya= [1,2,5,9,8,4,3];
    //
    public function supplier(){
        return $this->belongsTo('Alyya\Models\Supplier');
    }

    public function categories(){
        return $this->belongsToMany('Alyya\Models\Category')->withPivot('position');
    }

    public function scopeUpdateAmazonCatalog($query){
        //return $query->where('updated_at', '>', Carbon::now()->subDay()->toDateTimeString())->whereNotIn('category_id',self::$deniedCategoriesInAmazon);
        return $query->where('id', '>', 0); //for testing
    }

    public function scopeUpdateAlyyaCatalog($query){
        return $query->where('id', '>', '0');
    }

    public function matchCategoryCdiscountPro($CategoryCdiscountProId){
        return DB::table('category_cdiscount_pro_category')
            ->select('category_id')->where('cdiscount_pro_category_id', $CategoryCdiscountProId)
            ->first()->category_id;
    }
}
