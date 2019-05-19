<?php


namespace App\Service;


use App\Exceptions\InternalException;
use App\Jobs\CloseOrder;
use App\Models\GoodsSkus;
use App\Models\Order;
use App\Models\UserAddress;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function make($user,$address_id,$remark,$items){
        $data = DB::transaction(function () use($user,$address_id,$remark,$items){
            $user_address = UserAddress::find($address_id);
            $user_address->update(['last_use'=>Carbon::now()]);
            $order = new Order([
                'address'      => [ // 将地址信息放入订单中
                    'address'       => $user_address->full_address,
                    'zip'           => $user_address->zip,
                    'contact_name'  => $user_address->contact_name,
                    'contact_phone' => $user_address->contact_phone,
                ],
                'remark'       => $remark,
                'total_amount' => 0,
            ]);
            $order->user()->associate($user);
            $order->save();

            $totalAmount = 0;
            foreach ($items as $data){
                $sku = GoodsSkus::find($data['sku_id']);
                $item = $order->items()->make([
                    'amount'=>$data['amount'],
                    'price'=>$sku->price
                ]);

                $item->goods()->associate($sku->goods_id);
                $item->sku()->associate($sku);
                $item->save();
                $totalAmount += $sku->price * $data['amount'];
                if ($sku->decreaseStock($data['amount']) <= 0){
                    throw new InternalException('库存不足');
                }
            }
            // 更新订单总金额
            $order->update(['total_amount' => $totalAmount]);
            // 将下单的商品从购物车中移除
            $skuIds = collect($items)->pluck('sku_id');
            $user->cartItems()->whereIn('goods_sku_id', $skuIds)->delete();
            return $order;
        });
        dispatch(new CloseOrder($data,config('app.order_ttl')));
        return $data;
    }

}