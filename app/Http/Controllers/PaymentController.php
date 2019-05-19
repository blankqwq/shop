<?php

namespace App\Http\Controllers;

use App\Exceptions\InternalException;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    //

    public function payByAlipay(Order $order,Request $request){
        $this->authorize('own',$order);
        if ($order->paid_at || $order->closed){
            throw new InternalException('订单状态不正确');
        }
        return app('alipay')->web([
            'out_trade_no' => $order->no, // 订单编号，需保证在商户端不重复
            'total_amount' => $order->total_amount, // 订单金额，单位元，支持小数点后两位
            'subject'      => '支付  Shop 的订单：'.$order->no, // 订单标题
        ]);
    }

    public function payByWechart(){

    }
}
