<?php

namespace App\Models;

use App\Exceptions\InternalException;
use Illuminate\Database\Eloquent\Model;

class GoodsSkus extends Model
{
    //
    protected $fillable = ['goods_id', 'attribute_id', 'attribute_value_id',
        'attrs','picture_id', 'price', 'stock'];

    public function goods(){
        return $this->belongsTo(Goods::class,'goods_id','id');
    }

    public function decreaseStock($amount){
        if ($amount<0){
            throw new InternalException('库存不可小于0');
        }
        return $this->where('id',$this->id)->where('stock','>=',$amount)->decrement('stock',$amount);
    }

    public function addStock($amount){
        if ($amount<0){
            throw new InternalException('库存不可小于0');
        }
        return $this->increment('stock',$amount);
    }
}
