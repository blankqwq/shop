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

    public function attributes()
    {
        return $this->hasMany(GoodsAttribute::class, 'category_id', 'category_id');
    }

    public function attributeValue()
    {
        return $this->hasMany(GoodsAttribute::class, 'category_id', 'category_id');
    }

    public function getValues()
    {
        $values = [];
        foreach ($this->skus as $sku){
            $datas = explode(',', $sku->attrs);
            foreach ($datas as $data) {
                $temp = explode(':', $data);
                if (isset($values[$temp[0]])) {
                    $values[$temp[0]] = array_merge([$temp[1]], $values[$temp[0]]);
                    $values[$temp[0]]= array_unique($values[$temp[0]]);
                } else {
                    $values[$temp[0]] = [$temp[1]];
                }
            }
        }
        $datas=[];
        foreach ($values as $key=>$value){
            //替换成中文
            $datas[$key][GoodsAttribute::find($key)->name]=GoodsAttributeValue::select(['id','name'])->whereIn('id',$value)->get()->toArray();
        }
        return $datas;
    }

}
