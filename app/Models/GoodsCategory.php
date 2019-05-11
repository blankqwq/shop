<?php

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;

class GoodsCategory extends Model
{
    //
    use ModelTree, AdminBuilder;

    protected $fillable = ['name', 'parent_id', 'process', 'image', 'level', 'sort'];
    protected $appends = ['levels'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setParentColumn('parent_id');
        $this->setOrderColumn('sort');
        $this->setTitleColumn('name');
    }

    //有多少儿子
    public function children()
    {
        return $this->hasMany(GoodsCategory::class, 'parent_id', 'id');
    }

    //属于哪个爸爸
    public function parent()
    {
        return $this->belongsTo(GoodsCategory::class, 'parent_id', 'id');
    }

    //获取器
    public function getLevelsAttribute()
    {
        $data = [
            '0' => '根目录',
            '1' => '一级目录',
            '2' => '二级目录',
        ];
        return is_null($this->attributes['level']) ? $data : $data[$this->attributes['level']];
    }

    public function getPossessIdsAttribute()
    {
        return array_filter(explode('-', trim($this->possess, '-')));
    }

    public function getAncestorsAttribute()
    {
        return GoodsCategory::query()
            ->whereIn('id', $this->possess_ids)
            ->orderBy('level')->get();
    }

    public function getFullNameAttribute()
    {
        return $this->ancestors->pluck('name')
            ->push($this->name)->implode('-');
    }

}
