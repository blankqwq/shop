@extends('layouts.app')
@section('title', $goods->name)
    @section('css')
        <style>
            .btn.active, .btn:hover {
                margin-top: 0px !important;
                background: #fff !important;
                border: 2px solid red !important;
            }

            .btn.focus {
                outline: 0 !important;
            }
        </style>
    @endsection
@section('content')

    <div class="ps-product--detail pt-60">
        <div class="ps-container">
            <div class="row">
                <div class="col-lg-10 col-md-12 col-lg-offset-1">
                    <div class="ps-product__thumbnail">
                        <div class="ps-product__preview">
                            <div class="ps-product__variants">
                                @foreach($goods->pictures as $item)
                                    <div class="item"><img src="{{ url('storage/'.$item->url) }}" alt=""></div>
                                @endforeach

                            </div>
                            {{--                            <a class="popup-youtube ps-product__video" href="">--}}
                            {{--                                <img src="images/shoe-detail/1.jpg" alt=""><i class="fa fa-play"></i>--}}
                            {{--                            </a>--}}
                        </div>
                        <div class="ps-product__image">
                            @foreach($goods->pictures as $item)
                                <div class="item"><img class="zoom" src="{{ url('storage/'.$item->url) }}" alt=""
                                                       data-zoom-image="{{ url('storage/'.$item->url) }}"></div>
                            @endforeach
                        </div>
                    </div>
                    <div class="ps-product__thumbnail--mobile">
                        <div class="ps-product__main-img"><img src="{{ url('storage/'.$goods->picture->url) }}" alt="">
                        </div>
                        <div class="ps-product__preview owl-slider" data-owl-auto="true" data-owl-loop="true"
                             data-owl-speed="5000" data-owl-gap="20" data-owl-nav="true" data-owl-dots="false"
                             data-owl-item="3" data-owl-item-xs="3" data-owl-item-sm="3" data-owl-item-md="3"
                             data-owl-item-lg="3" data-owl-duration="1000" data-owl-mousedrag="on">
                            @foreach($goods->pictures as $item)
                                <img class="zoom" src="{{ url('storage/'.$item->url) }}" alt="">
                            @endforeach
                        </div>
                    </div>
                    <div class="ps-product__info">
                        <div class="ps-product__rating">
                            <span class="sale">
                              销量:{{$goods->sale}}
                            </span><a href="#">(点击量{{$goods->pv}})</a>
                        </div>
                        <h1>{{$goods->name}}</h1>
                        <p class="ps-product__category">{{ $goods->category->full_name }}</p>
                        <h3 class="ps-product__price">{{ $goods->sku->price }}
                            <del>原价</del>
                        </h3>
                        <div class="ps-product__block ps-product__quickview">
                            <h4>一句话描述</h4>
                            <p>xxxxxxxxxxxxxxxxxxxxx…</p>
                        </div>
                        @foreach($valuess as $key1=>$values)
                            @foreach($values as $key2=>$value)

                                <div class="ps-product__block ps-product__style">
                                    <h4>{{ $key2 }}</h4>
                                    <ul>
                                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                            @foreach($value as $item)
                                                <label class="btn sku-btn" title="{{ $key2 }}"
                                                       style=" color: #001; font-size: 26px;padding: 0 10px 0 10px;
                                                      ">
                                                    <input type="radio" name="skus[]" autocomplete="off"
                                                           value="{{ $key1.':'.$item['id'] }}"
                                                           attribute-id="{{$key1}}"> {{ $item['name'] }}
                                                </label>
                                            @endforeach
                                        </div>
                                    </ul>
                                </div>
                            @endforeach
                        @endforeach
                        {{--                        <div class="ps-product__block ps-product__style">--}}
                        {{--                            <h4>Attribute</h4>--}}
                        {{--                            <ul>--}}
                        {{--                                <li><a href="product-detail.html"><img src="images/shoe/sidebar/1.jpg" alt=""></a></li>--}}
                        {{--                                <li><a href="product-detail.html"><img src="images/shoe/sidebar/2.jpg" alt=""></a></li>--}}
                        {{--                                <li><a href="product-detail.html"><img src="images/shoe/sidebar/3.jpg" alt=""></a></li>--}}
                        {{--                                <li><a href="product-detail.html"><img src="images/shoe/sidebar/2.jpg" alt=""></a></li>--}}
                        {{--                            </ul>--}}
                        {{--                        </div>--}}

                        <div class="ps-product__shopping"><a class="ps-btn mb-10" href="cart.html">加入购物车<i
                                        class="ps-icon-next"></i></a>
                            <div class="ps-product__actions">
                                @if($favored)
                                    <a class="mr-10 btn-disfavor" style="background-color: #2AC37D">
                                        <i class="ps-icon-heart  "></i>
                                    </a>
                                @else
                                    <a class="mr-10 btn-favor" href="">
                                        <i class="ps-icon-heart  "></i>
                                    </a>
                                @endif
                                <a href="compare.html"><i class="ps-icon-share"></i></a></div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="ps-product__content mt-50">
                        <ul class="tab-list" role="tablist">
                            <li class="active"><a href="#tab_01" aria-controls="tab_01" role="tab" data-toggle="tab">详情介绍</a>
                            </li>
                            <li><a href="#tab_02" aria-controls="tab_02" role="tab" data-toggle="tab">商品评价</a></li>
                            {{--                            <li><a href="#tab_03" aria-controls="tab_03" role="tab" data-toggle="tab">PRODUCT TAG</a></li>--}}
                            {{--                            <li><a href="#tab_04" aria-controls="tab_04" role="tab" data-toggle="tab">ADDITIONAL</a></li>--}}
                        </ul>
                    </div>
                    <div class="tab-content mb-60">
                        <div class="tab-pane active" role="tabpanel" id="tab_01">
                            {!! $goods->desc !!}
                        </div>
                        <div class="tab-pane" role="tabpanel" id="tab_02">

                            <p class="mb-20">{{count($reviews)}}个评价<strong>{{ $goods->name }}</strong></p>
                            @foreach($reviews as $review)
                                <div class="ps-review">
                                <div class="ps-review__thumbnail"><img src="{{ $review->order->user->avatar }}" alt=""></div>
                                <div class="ps-review__content">
                                    <header>
                                        <select class="ps-rating">
                                            @for($i=1;$i<=5;$i++)
                                                <option value="1" @if($i === $review->rating) selected @endif>1</option>
                                            @endfor
                                        </select>
                                        <p>By<a href="">{{ $review->order->user->name }}</a> - {{ $review->review_at }}</p>
                                    </header>
                                    <p>{{ $review->review }}</p>
                                </div>
                            </div>
                            @endforeach

                        </div>
                        <div class="tab-pane" role="tabpanel" id="tab_03">
                            <p>Add your tag <span> *</span></p>
                            <form class="ps-product__tags" action="_action" method="post">
                                <div class="form-group">
                                    <input class="form-control" type="text" placeholder="">
                                    <button class="ps-btn ps-btn--sm">Add Tags</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" role="tabpanel" id="tab_04">
                            <div class="form-group">
                                <textarea class="form-control" rows="6"
                                          placeholder="Enter your addition here..."></textarea>
                            </div>
                            <div class="form-group">
                                <button class="ps-btn" type="button">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ps-section ps-section--top-sales ps-owl-root pt-40 pb-80">
        <div class="ps-container">
            <div class="ps-section__header mb-50">
                <div class="row">
                    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 ">
                        <h3 class="ps-section__title" data-mask="Related item">- 你应该喜欢</h3>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 ">
                        <div class="ps-owl-actions"><a class="ps-prev" href="#"><i class="ps-icon-arrow-right"></i>Prev</a><a
                                    class="ps-next" href="#">Next<i class="ps-icon-arrow-left"></i></a></div>
                    </div>
                </div>
            </div>
            <div class="ps-section__content">
                {{--                <div class="ps-owl--colection owl-slider" data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000" data-owl-gap="30" data-owl-nav="false" data-owl-dots="false" data-owl-item="4" data-owl-item-xs="1" data-owl-item-sm="2" data-owl-item-md="3" data-owl-item-lg="4" data-owl-duration="1000" data-owl-mousedrag="on">--}}
                {{--                    <div class="ps-shoes--carousel">--}}
                {{--                        <div class="ps-shoe">--}}
                {{--                            <div class="ps-shoe__thumbnail">--}}
                {{--                                <div class="ps-badge"><span>New</span></div><a class="ps-shoe__favorite" href="#"><i class="ps-icon-heart"></i></a><img src="images/shoe/1.jpg" alt=""><a class="ps-shoe__overlay" href="product-detail.html"></a>--}}
                {{--                            </div>--}}
                {{--                            <div class="ps-shoe__content">--}}
                {{--                                <div class="ps-shoe__variants">--}}
                {{--                                    <div class="ps-shoe__variant normal"><img src="images/shoe/2.jpg" alt=""><img src="images/shoe/3.jpg" alt=""><img src="images/shoe/4.jpg" alt=""><img src="images/shoe/5.jpg" alt=""></div>--}}
                {{--                                    <select class="ps-rating ps-shoe__rating">--}}
                {{--                                        <option value="1">1</option>--}}
                {{--                                        <option value="1">2</option>--}}
                {{--                                        <option value="1">3</option>--}}
                {{--                                        <option value="1">4</option>--}}
                {{--                                        <option value="2">5</option>--}}
                {{--                                    </select>--}}
                {{--                                </div>--}}
                {{--                                <div class="ps-shoe__detail"><a class="ps-shoe__name" href="product-detai.html">Air Jordan 7 Retro</a>--}}
                {{--                                    <p class="ps-shoe__categories"><a href="#">Men shoes</a>,<a href="#"> Nike</a>,<a href="#"> Jordan</a></p><span class="ps-shoe__price"> £ 120</span>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                    <div class="ps-shoes--carousel">--}}
                {{--                        <div class="ps-shoe">--}}
                {{--                            <div class="ps-shoe__thumbnail">--}}
                {{--                                <div class="ps-badge"><span>New</span></div>--}}
                {{--                                <div class="ps-badge ps-badge--sale ps-badge--2nd"><span>-35%</span></div><a class="ps-shoe__favorite" href="#"><i class="ps-icon-heart"></i></a><img src="images/shoe/2.jpg" alt=""><a class="ps-shoe__overlay" href="product-detail.html"></a>--}}
                {{--                            </div>--}}
                {{--                            <div class="ps-shoe__content">--}}
                {{--                                <div class="ps-shoe__variants">--}}
                {{--                                    <div class="ps-shoe__variant normal"><img src="images/shoe/2.jpg" alt=""><img src="images/shoe/3.jpg" alt=""><img src="images/shoe/4.jpg" alt=""><img src="images/shoe/5.jpg" alt=""></div>--}}
                {{--                                    <select class="ps-rating ps-shoe__rating">--}}
                {{--                                        <option value="1">1</option>--}}
                {{--                                        <option value="1">2</option>--}}
                {{--                                        <option value="1">3</option>--}}
                {{--                                        <option value="1">4</option>--}}
                {{--                                        <option value="2">5</option>--}}
                {{--                                    </select>--}}
                {{--                                </div>--}}
                {{--                                <div class="ps-shoe__detail"><a class="ps-shoe__name" href="product-detai.html">Air Jordan 7 Retro</a>--}}
                {{--                                    <p class="ps-shoe__categories"><a href="#">Men shoes</a>,<a href="#"> Nike</a>,<a href="#"> Jordan</a></p><span class="ps-shoe__price">--}}
                {{--					<del>£220</del> £ 120</span>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                    <div class="ps-shoes--carousel">--}}
                {{--                        <div class="ps-shoe">--}}
                {{--                            <div class="ps-shoe__thumbnail">--}}
                {{--                                <div class="ps-badge"><span>New</span></div><a class="ps-shoe__favorite" href="#"><i class="ps-icon-heart"></i></a><img src="images/shoe/3.jpg" alt=""><a class="ps-shoe__overlay" href="product-detail.html"></a>--}}
                {{--                            </div>--}}
                {{--                            <div class="ps-shoe__content">--}}
                {{--                                <div class="ps-shoe__variants">--}}
                {{--                                    <div class="ps-shoe__variant normal"><img src="images/shoe/2.jpg" alt=""><img src="images/shoe/3.jpg" alt=""><img src="images/shoe/4.jpg" alt=""><img src="images/shoe/5.jpg" alt=""></div>--}}
                {{--                                    <select class="ps-rating ps-shoe__rating">--}}
                {{--                                        <option value="1">1</option>--}}
                {{--                                        <option value="1">2</option>--}}
                {{--                                        <option value="1">3</option>--}}
                {{--                                        <option value="1">4</option>--}}
                {{--                                        <option value="2">5</option>--}}
                {{--                                    </select>--}}
                {{--                                </div>--}}
                {{--                                <div class="ps-shoe__detail"><a class="ps-shoe__name" href="product-detai.html">Air Jordan 7 Retro</a>--}}
                {{--                                    <p class="ps-shoe__categories"><a href="#">Men shoes</a>,<a href="#"> Nike</a>,<a href="#"> Jordan</a></p><span class="ps-shoe__price"> £ 120</span>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                    <div class="ps-shoes--carousel">--}}
                {{--                        <div class="ps-shoe">--}}
                {{--                            <div class="ps-shoe__thumbnail"><a class="ps-shoe__favorite" href="#"><i class="ps-icon-heart"></i></a><img src="images/shoe/4.jpg" alt=""><a class="ps-shoe__overlay" href="product-detail.html"></a>--}}
                {{--                            </div>--}}
                {{--                            <div class="ps-shoe__content">--}}
                {{--                                <div class="ps-shoe__variants">--}}
                {{--                                    <div class="ps-shoe__variant normal"><img src="images/shoe/2.jpg" alt=""><img src="images/shoe/3.jpg" alt=""><img src="images/shoe/4.jpg" alt=""><img src="images/shoe/5.jpg" alt=""></div>--}}
                {{--                                    <select class="ps-rating ps-shoe__rating">--}}
                {{--                                        <option value="1">1</option>--}}
                {{--                                        <option value="1">2</option>--}}
                {{--                                        <option value="1">3</option>--}}
                {{--                                        <option value="1">4</option>--}}
                {{--                                        <option value="2">5</option>--}}
                {{--                                    </select>--}}
                {{--                                </div>--}}
                {{--                                <div class="ps-shoe__detail"><a class="ps-shoe__name" href="product-detai.html">Air Jordan 7 Retro</a>--}}
                {{--                                    <p class="ps-shoe__categories"><a href="#">Men shoes</a>,<a href="#"> Nike</a>,<a href="#"> Jordan</a></p><span class="ps-shoe__price"> £ 120</span>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                    <div class="ps-shoes--carousel">--}}
                {{--                        <div class="ps-shoe">--}}
                {{--                            <div class="ps-shoe__thumbnail">--}}
                {{--                                <div class="ps-badge"><span>New</span></div><a class="ps-shoe__favorite" href="#"><i class="ps-icon-heart"></i></a><img src="images/shoe/5.jpg" alt=""><a class="ps-shoe__overlay" href="product-detail.html"></a>--}}
                {{--                            </div>--}}
                {{--                            <div class="ps-shoe__content">--}}
                {{--                                <div class="ps-shoe__variants">--}}
                {{--                                    <div class="ps-shoe__variant normal"><img src="images/shoe/2.jpg" alt=""><img src="images/shoe/3.jpg" alt=""><img src="images/shoe/4.jpg" alt=""><img src="images/shoe/5.jpg" alt=""></div>--}}
                {{--                                    <select class="ps-rating ps-shoe__rating">--}}
                {{--                                        <option value="1">1</option>--}}
                {{--                                        <option value="1">2</option>--}}
                {{--                                        <option value="1">3</option>--}}
                {{--                                        <option value="1">4</option>--}}
                {{--                                        <option value="2">5</option>--}}
                {{--                                    </select>--}}
                {{--                                </div>--}}
                {{--                                <div class="ps-shoe__detail"><a class="ps-shoe__name" href="product-detai.html">Air Jordan 7 Retro</a>--}}
                {{--                                    <p class="ps-shoe__categories"><a href="#">Men shoes</a>,<a href="#"> Nike</a>,<a href="#"> Jordan</a></p><span class="ps-shoe__price"> £ 120</span>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                    <div class="ps-shoes--carousel">--}}
                {{--                        <div class="ps-shoe">--}}
                {{--                            <div class="ps-shoe__thumbnail"><a class="ps-shoe__favorite" href="#"><i class="ps-icon-heart"></i></a><img src="images/shoe/6.jpg" alt=""><a class="ps-shoe__overlay" href="product-detail.html"></a>--}}
                {{--                            </div>--}}
                {{--                            <div class="ps-shoe__content">--}}
                {{--                                <div class="ps-shoe__variants">--}}
                {{--                                    <div class="ps-shoe__variant normal"><img src="images/shoe/2.jpg" alt=""><img src="images/shoe/3.jpg" alt=""><img src="images/shoe/4.jpg" alt=""><img src="images/shoe/5.jpg" alt=""></div>--}}
                {{--                                    <select class="ps-rating ps-shoe__rating">--}}
                {{--                                        <option value="1">1</option>--}}
                {{--                                        <option value="1">2</option>--}}
                {{--                                        <option value="1">3</option>--}}
                {{--                                        <option value="1">4</option>--}}
                {{--                                        <option value="2">5</option>--}}
                {{--                                    </select>--}}
                {{--                                </div>--}}
                {{--                                <div class="ps-shoe__detail"><a class="ps-shoe__name" href="product-detai.html">Air Jordan 7 Retro</a>--}}
                {{--                                    <p class="ps-shoe__categories"><a href="#">Men shoes</a>,<a href="#"> Nike</a>,<a href="#"> Jordan</a></p><span class="ps-shoe__price"> £ 120</span>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
            </div>
        </div>
    </div>
@endsection

@section('scriptsAfterJs')
    <script>
        $(document).ready(function () {
            var a = 1;
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
                    }, function (error) { // 请求失败会执行这个回调
                        // 如果返回码是 401 代表没登录
                        if (error.response && error.response.status === 401) {
                            swal('请先登录', '', 'error');
                        } else if (error.response && error.response.data.msg) {
                            // 其他有 msg 字段的情况，将 msg 提示给用户
                            swal(error.response.data.msg, '', 'error');
                        } else {
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