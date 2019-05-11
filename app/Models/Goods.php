<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    //

    public function skus(){
        return $this->hasMany(GoodsSkus::class,'goods_id','id');
    }
}
