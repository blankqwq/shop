<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    //
    protected $fillable=['amount'];

    public function user(){
        return $this->belongsTo(User::class,'id','user_id');
    }

    public function sku(){
        return $this->belongsTo(GoodsSkus::class,'goods_sku_id','id');
    }
}
