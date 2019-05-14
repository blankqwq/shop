<?php

namespace App\Http\Controllers;

use App\Models\Goods;
use Illuminate\Http\Request;

class GoodsController extends Controller
{
    //
    public function index(Request $request)
    {
        $builder = Goods::with('picture', 'sku', 'category')->where('state', 1);
        if ($search = $request->input('search' . '')) {
            $like = '%' . $search . '%';
            $builder->where(function ($query) use ($like) {
                $query
                    ->where('name', 'like', $like)
                    ->orWhere('desc', 'like', $like);
            });
        }

        if ($order = $request->input('order', '')) {
            // 是否是以 _asc 或者 _desc 结尾
            if (preg_match('/^(.+)_(asc|desc)$/', $order, $m)) {
                // 如果字符串的开头是这 3 个字符串之一，说明是一个合法的排序值
                if (in_array($m[1], ['price', 'pv', 'sale'])) {
                    // 根据传入的排序值来构造排序参数
                    $builder->orderBy($m[1], $m[2]);
                }
            }
        }
        $goodss = $builder->paginate(16);
        return view('goods.index', ['goodss' => $goodss, 'filters' => ['search' => $search, 'order' => $order]]);
    }

    public function show($id){
        $goods = Goods::with('skus','pictures','picture')->find($id);
        return view('goods.show',compact('goods'));
    }
}
