<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Goods extends Model
{
    //
    use SoftDeletes;
    protected $fillable = [
        'category_id',
        'image',
        'desc',
        'state',
        'state_date',
        'pv',
        'sale',
        'sort',
    ];
    protected $appends = ['image'];

    public function skus()
    {
        return $this->hasMany(GoodsSkus::class, 'goods_id', 'id');
    }

    public function sku()
    {
        return $this->hasOne(GoodsSkus::class, 'goods_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(GoodsCategory::class, 'category_id', 'id');
    }

    public function pictures()
    {
        return $this->hasMany(Picture::class, 'goods_id', 'id');
    }

    public function getImageAttribute()
    {
        return Picture::where([
            'goods_id' => $this->id,
            'is_main' => 1
        ])->value('url');
    }

    public function picture()
    {
        return $this->hasOne(Picture::class, 'goods_id', 'id')->where('is_main', 1);
    }


}
