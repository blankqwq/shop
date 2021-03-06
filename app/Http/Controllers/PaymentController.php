<?php

namespace App\Http\Controllers;

use App\Exceptions\InternalException;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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

    // 前端回调页面
    public function alipayReturn(Request $request)
    {
        // 校验提交的参数是否合法
        try{
            $data = app('alipay')->verify();
        }catch (\Exception $e){
            return view('pages.error',['msg' => '数据不正确']);
        }
        return view('pages.success',['msg' => '支付成功']);
    }

    // 服务器端回调
    public function alipayNotify()
    {
        $data  = app('alipay')->verify();
        // 如果订单状态不是成功或者结束，则不走后续的逻辑
        if(!in_array($data->trade_status, ['TRADE_SUCCESS', 'TRADE_FINISHED'])) {
            return app('alipay')->success();
        }
        // $data->out_trade_no 拿到订单流水号，并在数据库中查询
        $order = Order::where('no', $data->out_trade_no)->first();
        if (!$order) {
            return 'fail';
        }
        if ($order->paid_at) {
            return app('alipay')->success();
        }
        $order->update([
            'paid_at'        => Carbon::now(), // 支付时间
            'payment_method' => 'alipay', // 支付方式
            'payment_no'     => $data->trade_no, // 支付宝订单号
        ]);
        $this->afterPaid($order);
        return app('alipay')->success();
    }
}
