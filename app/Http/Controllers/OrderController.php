<?php

namespace App\Http\Controllers;

use App\Exceptions\InternalException;
use App\Http\Requests\OrderRequest;
use App\Jobs\CloseOrder;
use App\Models\GoodsSkus;
use App\Models\Order;
use App\Models\UserAddress;
use App\Service\OrderService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    //
    public function store(OrderRequest $request,OrderService $service){
        $user = $request->user();
        $address = $request->input('address_id');
        $data =$service->make($user,$address,$request->input('remark'),$request->input('items'));
        return $data;
    }

    public function index(Request $request){
        $orders = Order::with(['items.goods','items.sku'])
        ->where('user_id',$request->user()->id)
        ->orderBy('created_at','desc')
        ->paginate(0);

        return view('orders.index',compact('orders'));
    }

    public function show(Order $order){
        $this->authorize('own',$order);
        return view('orders.show',['order'=>$order->load(['items.sku','items.goods'])]);
    }
}
