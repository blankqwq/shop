<?php

namespace App\Http\Controllers;

use App\Events\OrderReviewed;
use App\Exceptions\InternalException;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\SendReviewRequest;
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

    public function received(Order $order){
        $this->authorize('own',$order);
        if ($order->ship_status !== Order::SHIP_STATUS_DELIVERED){
            throw new InternalException('订单还未发货');
        }
        $order->update(['ship_status'=>Order::SHIP_STATUS_RECEIVED]);
        return $order;
    }


    public function showReview(Order $order){
        $this->authorize('own',$order);
        if (!$order->paid_at)
            throw new InternalException('订单未支付','订单未支付,不可以评价');
        return view('orders.review',['order'=>$order->load(['items.goods','items.sku'])]);
    }

    public function storeReview(Order $order,SendReviewRequest $request){
        $this->authorize('own',$order);
        if (!$order->paid_at)
            throw new InternalException('未支付','订单未支付');
        if ($order->reviewed)
            throw new InternalException('已评价','订单已评价');
        $reviews = $request->input('reviews');
        DB::transaction(function () use($reviews,$order){
            foreach ($reviews as $review){
                $orderItem = $order->items()->find($review['id']);
                $orderItem->update([
                    'rating'      => $review['rating'],
                    'review'      => $review['review'],
                    'review_at' => Carbon::now(),
                ]);
            }
            $order->update(['reviewed' => true]);
        });
//        event(new OrderReviewed($order));
        return redirect()->back();

    }
}
