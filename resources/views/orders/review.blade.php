@extends('layouts.app')
@section('title', '商品评价')

@section('content')
    <div class="ps-goods--detail pt-60">
        <div class="ps-container">
            <div class="row">
                <div class="col-lg-10 col-md-12 col-lg-offset-1">
                    <div class="card">
                        <div class="card-header">
                            商品评价
                            <a class="float-right" href="{{ route('orders.index') }}">返回订单列表</a>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('orders.review.store', [$order->id]) }}" method="post">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td>商品名称</td>
                                        <td>打分</td>
                                        <td>评价</td>
                                    </tr>
                                    @foreach($order->items as $index => $item)
                                        <tr>
                                            <td class="goods-info">
                                                <div class="ps-cart-item__thumbnail">
                                                    <a target="_blank"
                                                       href="{{ route('goods.show', [$item->goods_id]) }}">
                                                        <img src="{{ url('storage/'.$item->goods->image) }}">
                                                    </a>
                                                </div>
                                                <div>
                <span class="goods-title">
                   <a target="_blank"
                      href="{{ route('goods.show', [$item->goods_id]) }}">{{ $item->goods->title }}</a>
                </span>
                                                    <span class="sku-title">{{ $item->goods->name }}</span>
                                                </div>
                                                <input type="hidden" name="reviews[{{$index}}][id]"
                                                       value="{{ $item->id }}">
                                            </td>
                                            <td class="vertical-middle">
                                                <!-- 如果订单已经评价则展示评分，下同 -->
                                                @if($order->reviewed)
                                                    <div class="ps-product__rating">
                                                        <select class="ps-rating" >
                                                            @for($i=1;$i<=5;$i++)
                                                            <option value="1" @if($i ===$item->rating) selected @endif>1</option>
                                                            @endfor

                                                        </select>
                                                    </div>
                                                @else
                                                    <div class="ps-product__rating">
                                                        <select class="ps-rating"  name="reviews[{{$index}}][rating]">
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4">4</option>
                                                            <option value="5" selected>5</option>
                                                        </select>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                @if($order->reviewed)
                                                    {{ $item->review }}
                                                @else
                                                    <textarea
                                                            class="form-control {{ $errors->has('reviews.'.$index.'.review') ? 'is-invalid' : '' }}"
                                                            name="reviews[{{$index}}][review]"></textarea>
                                                    @if($errors->has('reviews.'.$index.'.review'))
                                                        @foreach($errors->get('reviews.'.$index.'.review') as $msg)
                                                            <span class="invalid-feedback"
                                                                  role="alert"><strong>{{ $msg }}</strong></span>
                                                        @endforeach
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            @if(!$order->reviewed)
                                                <button type="submit" class="btn btn-primary center-block">提交</button>
                                            @else
                                                <a href="{{ route('orders.show', [$order->id]) }}"
                                                   class="btn btn-primary">查看订单</a>
                                            @endif
                                        </td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection