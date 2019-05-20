<?php

namespace App\Listeners;

use App\Events\OrderPaid;
use App\Models\OrderItem;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateProductSoldCount
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OrderPaid  $event
     * @return void
     */
    public function handle(OrderPaid $event)
    {
        $order = $event->getOrder();

        $order->load('items.goods');

        foreach ($order->items as $item){
            $goods = $item->goods;

            $soldCount = OrderItem::query()->where('goods_id',$goods->id)->whereHas('order',function ($query){
                $query->whereNotNull('paid_at');  // 关联的订单状态是已支付
            })->sum('amount');

            $goods->update(['sale'=>$soldCount]);
        }
    }
}
