@extends('layouts.app')
@section('title', '我的收藏')

@section('content')
    <div class="row">
        <div class="col-lg-10 offset-lg-1">
            <div class="card">
                <div class="card-header">我的收藏</div>
                <div class="card-body">
                    <div class="row goods-list">
                        @foreach($goodss as $goods)
                            <div class="col-3 goods-item">
                                <div class="goods-content">
                                    <div class="top">
                                        <div class="img">
                                            <a href="{{ route('goods.show', ['goods' => $goods->id]) }}">
                                                <img src="{{ config('appi.url').'/storage/'.$goods->picture->url }}" alt="">
                                            </a>
                                        </div>
                                        <div class="price"><b>￥</b>{{ $goods->sku->price }}</div>
                                        <a href="{{ route('goods.show', ['goods' => $goods->id]) }}">{{ $goods->sku->name }}</a>
                                    </div>
                                    <div class="bottom">
                                        <div class="sold_count">销量 <span>{{ $goods->sale }}笔</span></div>
                                        <div class="review_count">点击量 <span>{{ $goods->pv }}</span></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="float-right">{{ $goodss->render() }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection