<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsSkus extends Model
{
    //
    protected $fillable = ['goods_id', 'attribute_id', 'attribute_value_id',
        'attrs','picture_id', 'price', 'stock'];

    public function goods(){
        return $this->belongsTo(Goods::class,'goods_id','id');
    }


}
