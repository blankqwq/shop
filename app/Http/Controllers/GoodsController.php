<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidRequestException;
use App\Models\Goods;
use App\Models\GoodsAttribute;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class GoodsController extends Controller
{
    //
    public function index(Request $request)
    {
        $builder = Goods::with('picture','pictures', 'sku', 'category')->where('state', 1);
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

    public function show($id)
    {
        $goods = Goods::with('skus', 'pictures', 'picture', 'attributes')->find($id);
        if (!$goods)
            throw new InvalidRequestException('商品未上架',404);
        $favored=false;
        if (Auth::user()->favoriteGoods()->find($goods->id))
            $favored=true;
        $valuess = $goods->getValues();
        return view('goods.show', compact('goods','valuess','favored'));
    }

    public function favor(Goods $goods,Request $request){
        $user = $request->user();
        if ($user->favoriteGoods()->find($goods->id))
            return [];
        $user->favoriteGoods()->attach($goods);
        return [];
    }

    public function disfavor(Goods $goods,Request $request){
        $user = $request->user();
        $user->favoriteGoods()->detach($goods);
        return [];
    }

    public function favorites(Request $request){
        $user = $request->user();
        $goodss = $user->favoriteGoods()->paginate(16);
        return view('goods.favorites',compact('goodss'));
    }

}
