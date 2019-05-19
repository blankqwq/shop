<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Models\CartItem;
use App\Models\GoodsSkus;
use Illuminate\Http\Request;

class CartController extends Controller
{
    //

    public function index(Request $request){
        $user = $request->user();
        $carts = $user->cartItems()->with(['sku'])->get();
        $addresses = $request->user()->addresses()->orderBy('last_use', 'desc')->get();
        return view('cart.index',compact('carts','addresses'));
    }

    public function addCart(CartRequest $request){

    }

    public function remove(GoodsSkus $sku,Request $request){
        //删除购物车内容
        $request->user()->cartItems()->where('goods_sku_id',$sku->id)->delete();
        return [];
    }
}
