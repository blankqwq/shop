<?php


namespace App\Models\Traits;


trait FactoryAllGoodsAttribute
{

    public function getAllGoodsId(){
        $goods_ids = Goods::select(['id'])->get();
    }

}