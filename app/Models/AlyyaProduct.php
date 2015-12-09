<?php
namespace Alyya\Models;

use Illuminate\Database\Eloquent\Model;

class AlyyaProduct extends Model
{
    protected $guarded = [];
    //
    public function scopeIndex($query,$category_id)
    {
        return $query->where('sku', '>', 5000)->where('category_id',$category_id);
    }
}
