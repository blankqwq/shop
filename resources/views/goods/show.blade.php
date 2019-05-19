@extends('layouts.app')
@section('title', $goods->title)

@section('content')
    <div class="row">
        <div class="col-lg-10 offset-lg-1">
            <div class="card">
                <div class="card-body goods-info">
                    <div class="row">
                        <div class="col-5">
                            <img class="cover" src="{{ config('appi.url').'/storage/'.$goods->picture->url }}" alt="">
                        </div>
                        <div class="col-7">
                            <div class="title">{{ $goods->title }}</div>
                            <div class="price"><label>价格</label><em>￥</em><span>{{ $goods->sku->price }}</span></div>
                            <div class="sales_and_reviews">
                                <div class="sold_count">累计销量 <span class="count">{{ $goods->sale }}</span></div>
                                <div class="review_count">点击量 <span class="count">{{ $goods->pv }}</span></div>
                            </div>
                            @foreach($valuess as $key1=>$values)
                                @foreach($values as $key2=>$value)

                                    <div class="skus">

                                        <label>{{ $key2 }}</label>
                                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                            @foreach($value as $item)

                                                <label class="btn sku-btn" title="{{ $key2 }}">
                                                    <input type="radio" name="skus[]" autocomplete="off"
                                                           value="{{ $key1.':'.$item['id'] }}"
                                                           attribute-id="{{$key1}}"> {{ $item['name'] }}
                                                </label>
                                            @endforeach

                                        </div>
                                    </div>
                                @endforeach
                            @endforeach
                            <br>
                            <div class="cart_amount"><label>数量</label><input type="text"
                                                                             class="form-control form-control-sm"
                                                                             value="1"><span>件</span><span
                                        class="stock"></span></div>
                            <div class="buttons">
                                @if($favored)
                                <button class="btn btn-success btn-disfavor">取消收藏</button>
                                @else
                                    <button class="btn btn-success btn-favor">❤ 收藏</button>
                                @endif
                                <button class="btn btn-primary btn-add-to-cart">加入购物车</button>

                            </div>
                        </div>
                    </div>
                    <div class="goods-detail">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" href="#goods-detail-tab" aria-controls="goods-detail-tab"
                                   role="tab" data-toggle="tab" aria-selected="true">商品详情</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#goods-reviews-tab" aria-controls="goods-reviews-tab"
                                   role="tab" data-toggle="tab" aria-selected="false">用户评价</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="goods-detail-tab">
                                {!! $goods->desc !!}
                            </div>
                            <div role="tabpanel" class="tab-pane" id="goods-reviews-tab">
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
            var a=1;
            $('[data-toggle="tooltip"]').tooltip({trigger: 'hover'});

            $('.sku-btn').click(function () {
                {{--if (a<{{count($valuess)}}){--}}
                {{--    data={'sku':[$(this).data('price')+':'+$(this).data('price')]};--}}
                {{--    alert('12');--}}
                {{--    a++;--}}
                {{--}else {--}}
                {{--    a=0;--}}
                {{--    $('.product-info .price span').text($(this).data('price'));--}}
                {{--    $('.product-info .stock').text('库存：' + $(this).data('stock') + '件');--}}
                {{--}--}}
                {{--console.log(a);--}}

            });

            $('.btn-favor').click(function () {
                // 发起一个 post ajax 请求，请求 url 通过后端的 route() 函数生成。
                axios.post('{{ route('user.goods.favor', ['goods' => $goods->id]) }}')
                    .then(function () { // 请求成功会执行这个回调
                        swal('操作成功', '', 'success');
                    }, function(error) { // 请求失败会执行这个回调
                        // 如果返回码是 401 代表没登录
                        if (error.response && error.response.status === 401) {
                            swal('请先登录', '', 'error');
                        } else if (error.response && error.response.data.msg) {
                            // 其他有 msg 字段的情况，将 msg 提示给用户
                            swal(error.response.data.msg, '', 'error');
                        }  else {
                            // 其他情况应该是系统挂了
                            swal('系统错误', '', 'error');
                        }
                    });
            });
            $('.btn-disfavor').click(function () {
                axios.delete('{{ route('user.goods.disfavor', ['goods' => $goods->id]) }}')
                    .then(function () {
                        swal('操作成功', '', 'success')
                            .then(function () {
                                location.reload();
                            });
                    });
            });
        })
    </script>
@endsection