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
        $carts = $user->cartItems()->with(['sku'])->paginate(10);
        return view('cart.index',compact('carts'));
    }

    public function addCart(CartRequest $request){

    }

    public function remove(GoodsSkus $sku,Request $request){
        //删除购物车内容
        $request->user()->cartItems()->where('goods_sku_id',$sku->id)->delete();
        return [];
    }
}
