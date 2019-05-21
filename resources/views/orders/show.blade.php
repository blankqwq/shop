@extends('layouts.app')
@section('title', '查看订单')

@section('content')
    <div class="ps-product--detail pt-60">
        <div class="ps-container">
            <div class="row">
                <div class="col-lg-10 col-md-12 col-lg-offset-1">
                    <div class="card">
                        <div class="card-header">
                            <h4>订单详情</h4>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>商品信息</th>
                                    <th class="text-center">单价</th>
                                    <th class="text-center">数量</th>
                                    <th class="text-right item-amount">小计</th>
                                </tr>
                                </thead>
                                @foreach($order->items as $index => $item)
                                    <tr>
                                        <td class="goods-info">
                                            <div class="ps-cart-item__thumbnail">
                                                <a target="_blank" href="{{ route('goods.show', [$item->goods_id]) }}">
                                                    <img src="{{ url('storage/'.$item->goods->image) }}">
                                                </a>
                                            </div>
                                            <div>
              <span class="goods-title">
                 <a target="_blank" href="{{ route('goods.show', [$item->goods_id]) }}">{{ $item->goods->name }}</a>
              </span>
                                                <span class="sku-title">{{ $item->sku->title }}</span>
                                            </div>
                                        </td>
                                        <td class="sku-price text-center vertical-middle">￥{{ $item->price }}</td>
                                        <td class="sku-amount text-center vertical-middle">{{ $item->amount }}</td>
                                        <td class="item-amount text-right vertical-middle">
                                            ￥{{ number_format($item->price * $item->amount, 2, '.', '') }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="4"></td>
                                </tr>
                            </table>
                            <div class="order-bottom">
                                <div class="order-info">
                                    <table>
{{--                                        <tr>--}}
                                        <td>收货地址：</td>
{{--                                        </tr>--}}
                                        <tr><td></td><td>{{ join(' ',$order->address) }}</td></tr>
                                        <td>订单备注：</td>
                                        <tr><td></td><td>{{ $order->remark ?: '-' }}</td></tr>
                                        <td>订单编号：</td>
                                        <tr><td></td><td>{{ $order->no }}</td></tr>
                                        <td>物流状态：</td>
                                        <tr><td></td><td>{{ \App\Models\Order::$shipStatusMap[$order->ship_status] }}</td></tr>
                                        @if($order->ship_data)
                                            <td>物流信息：</td>
                                            <tr><td></td><td>{{ $order->ship_data['express_company'] }}</td><td> {{ $order->ship_data['express_no'] }}</td></tr>
                                        @endif

                                        <td>订单总价：</td>
                                        <tr><td></td><td>￥{{ $order->total_amount }}</td></tr>
                                        <td>订单状态：</td>
                                        <tr><td></td><td>
                                                @if($order->paid_at)
                                                    @if($order->refund_status === \App\Models\Order::REFUND_STATUS_PENDING)
                                                        已支付
                                                    @else
                                                        {{ \App\Models\Order::$refundStatusMap[$order->refund_status] }}
                                                    @endif
                                                @elseif($order->closed)
                                                    已关闭
                                                @else
                                                    未支付
                                                @endif</td></tr>
                                    </table>
                                </div>

                                <div class="order-summary text-right" style="text-align: center">
                                    @if(!$order->paid_at && !$order->closed)
                                        <div class="payment-buttons">
                                            <a class="btn btn-primary btn-sm"
                                               href="{{ route('payment.alipay', ['order' => $order->id]) }}">支付宝支付</a>
                                        </div>
                                    @endif
                                    @if($order->ship_status === \App\Models\Order::SHIP_STATUS_DELIVERED)
                                        <div class="receive-button">
                                            <form method="post" action="{{ route('orders.received', [$order->id]) }}">
                                                <!-- csrf token 不能忘 -->
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-sm btn-success">确认收货</button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                                <hr>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection



@section('scriptsAfterJs')
                <script>
                    $(document).ready(function () {
                        $('#btn-receive').click(function () {
                            // 弹出确认框
                            swal({
                                title: "确认已经收到商品？",
                                icon: "warning",
                                dangerMode: true,
                                buttons: ['取消', '确认收到'],
                            })
                                .then(function (ret) {
                                    // 如果点击取消按钮则不做任何操作
                                    if (!ret) {
                                        return;
                                    }
                                    // ajax 提交确认操作
                                    axios.post('{{ route('orders.received', [$order->id]) }}')
                                        .then(function () {
                                            // 刷新页面
                                            location.reload();
                                        })
                                });
                        });

                    });
                </script>
@endsection