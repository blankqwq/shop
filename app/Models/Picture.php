<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    //]

    protected $fillable=[
            'name',
            'url',
            'goods_id',
            'size',
            'is_main',
    ];

    public function goods(){
        return $this->hasMany(Goods::class,'id','goods_id');
    }
}
