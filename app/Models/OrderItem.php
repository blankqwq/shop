<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    //
    protected $fillable=['amount','price','rating', 'review','review_at'];
    protected $dates = ['reviewed_at'];

    public function order(){
        return $this->belongsTo(Order::classq,'order_id','id');
    }

    public function sku(){
        return $this->belongsTo(GoodsSkus::class,'goods_sku_id','id');
    }

    public function goods(){
        return $this->belongsTo(Goods::class,'goods_id','id');
    }
}
