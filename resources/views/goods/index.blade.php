@extends('layouts.app')
@section('title', '商品列表')

@section('content')

    <div class="col-lg-10 offset-lg-1">
        <div id="demo" class="carousel slide" data-ride="carousel">

            <!-- 指示符 -->
            <ul class="carousel-indicators">
                <li data-target="#demo" data-slide-to="0" class="active"></li>
                <li data-target="#demo" data-slide-to="1"></li>
                <li data-target="#demo" data-slide-to="2"></li>
            </ul>

            <!-- 轮播图片 -->
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="https://static.runoob.com/images/mix/img_fjords_wide.jpg">
                </div>
                <div class="carousel-item">
                    <img src="https://static.runoob.com/images/mix/img_nature_wide.jpg">
                </div>
                <div class="carousel-item">
                    <img src="https://static.runoob.com/images/mix/img_mountains_wide.jpg">
                </div>
            </div>

            <!-- 左右切换按钮 -->
            <a class="carousel-control-prev" href="#demo" data-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </a>
            <a class="carousel-control-next" href="#demo" data-slide="next">
                <span class="carousel-control-next-icon"></span>
            </a>

        </div>
        <hr>
            <div class="card">
                <div class="card-body">
                    <!-- 筛选组件开始 -->
                    <form action="{{ route('goods.index') }}" class="search-form">
                        <div class="form-row">
                            <div class="col-md-9">
                                <div class="form-row">
                                    <div class="col-auto"><input type="text" class="form-control form-control-sm" name="search" placeholder="搜索"></div>
                                    <div class="col-auto"><button class="btn btn-primary btn-sm">搜索</button></div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select name="order" class="form-control form-control-sm float-right">
                                    <option value="">排序方式</option>
                                    <option value="price_asc">价格从低到高</option>
                                    <option value="price_desc">价格从高到低</option>
                                    <option value="sold_count_desc">销量从高到低</option>
                                    <option value="sold_count_asc">销量从低到高</option>
{{--                                    <option value="rating_desc">评价从高到低</option>--}}
{{--                                    <option value="rating_asc">评价从低到高</option>--}}
                                </select>
                            </div>
                        </div>
                    </form>
                    <div class="row goods-list">
                        @foreach($goodss as $goods)
                            <div class="col-3 goods-item">
                                <div class="goods-content">
                                    <div class="top">
                                        <div class="img">
                                            <a href="{{ route('goods.show', ['id' => $goods->id]) }}">
                                            <img
                                                    src="{{ config('appi.url').'storage/'.$goods->picture->url }}"
                                                    alt="">
                                            </a>
                                        </div>
                                        <div class="price"><b>￥</b>{{ $goods->sku->price }}</div>
                                            <div class="title">                                        <a href="{{ route('goods.show', ['id' => $goods->id]) }}">
                                                {{ $goods->name }}</a></div>
                                    </div>
                                    <div class="bottom">
                                        <div class="sold_count">销量 <span>{{ $goods->sale }}笔</span></div>
                                        <div class="review_count">点击量 <span>{{ $goods->pv }}</span></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="float-right">{{ $goodss->appends($filters)->render() }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scriptsAfterJs')
    <script>
        var filters = {!! json_encode($filters) !!};
        $(document).ready(function () {
            $('.search-form input[name=search]').val(filters.search);
            $('.search-form select[name=order]').val(filters.order);
        })
    </script>
@endsection