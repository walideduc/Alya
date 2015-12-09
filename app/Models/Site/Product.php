<?php

namespace Alyya\Models\Site;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $connection = 'site';
    protected $guarded = [];
    //
    public function scopeIndex($query,$category_id)
    {
        return $query->where('id', '>', 5000)->has('category_id',$category_id);
    }
    public function categories(){
        return $this->belongsToMany('Alyya\Models\Site\Category')->withPivot('position');
    }
    //
}
