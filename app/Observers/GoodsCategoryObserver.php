<?php

namespace App\Observers;

use App\Models\GoodsCategory;

class GoodsCategoryObserver
{
    //
    public function created(GoodsCategory $goodsCategory){
        if (is_null($goodsCategory->parent_id) || $goodsCategory->parent_id == 0) {
            $goodsCategory->level = 0;
            $goodsCategory->possess = '-';
        } else {
            $goodsCategory->level = $goodsCategory->parent->level + 1;
            $goodsCategory->possess = $goodsCategory->parent->possess
                . $goodsCategory->parent_id . '-';
        }
        $goodsCategory->save();
    }
}
