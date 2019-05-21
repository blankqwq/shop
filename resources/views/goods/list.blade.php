@extends('layouts.app')
@section('title', 'xx商品列表')

@section('content')
    <div class="ps-products-wrap pt-80 pb-80">
        <div class="ps-products" data-mh="product-listing">
            <div class="ps-product-action">
                <div class="ps-product__filter">
                    <select class="ps-select selectpicker">
                        <option value="1">最近上架</option>
                        <option value="2">按名称排序</option>
                        <option value="3">价格 (Low to High)</option>
                        <option value="3">价格 (High to Low)</option>
                    </select>
                </div>
                {{--                分页--}}
                <div class="ps-pagination">
                    <ul class="pagination">
                        <li><a href="#"><i class="fa fa-angle-left"></i></a></li>
                        <li class="active"><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">...</a></li>
                        <li><a href="#"><i class="fa fa-angle-right"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="ps-product__columns">
            @foreach($categories as $category)
                @foreach($category->goods as $item)
                    <div class="ps-product__column">
                        <div class="ps-shoe mb-30">
                            <div class="ps-shoe__thumbnail"><a class="ps-shoe__favorite" href="#">
                                    <i class="ps-icon-heart"></i>
                                </a><img src="{{url('storage/',$item->picture->url)}}" alt="">
                                <a class="ps-shoe__overlay" href="{{route('goods.show',$item->id)}}"></a>
                            </div>
                            <div class="ps-shoe__content">
                                <div class="ps-shoe__variants">
                                    <div class="ps-shoe__variant normal">
                                        @foreach($item->pictures as $p)
                                            <img src="{{ url('storage/',$p->url) }}" alt="">
                                        @endforeach
                                    </div>
                                    <select class="ps-rating ps-shoe__rating">
                                        <option value="1">1</option>
                                        <option value="1">2</option>
                                        <option value="1">3</option>
                                        <option value="1">4</option>
                                        <option value="2">5</option>
                                    </select>
                                </div>
                                <div class="ps-shoe__detail"><a class="ps-shoe__name" href="#">{{ $item->name }}</a>
                                    <p class="ps-shoe__categories"><a href="{{route('goods.show',$item->id)}}">具体属性</a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforeach
            </div>

            <div class="ps-product-action">
                <div class="ps-product__filter">
                    <select class="ps-select selectpicker">
                        <option value="1">最近</option>
                        <option value="2">按名称</option>
                        <option value="3">价格 (Low to High)</option>
                        <option value="3">价格 (High to Low)</option>
                    </select>
                </div>
                {{--                分页系统--}}
                <div class="ps-pagination">
                        <ul class="pagination">
                            <li><a href="#"><i class="fa fa-angle-left"></i></a></li>
                            <li class="active"><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">...</a></li>
                            <li><a href="#"><i class="fa fa-angle-right"></i></a></li>
                        </ul>
                </div>
            </div>
        </div>
            <div class="ps-sidebar" data-mh="product-listing">
                <aside class="ps-widget--sidebar ps-widget--category">
                    <div class="ps-widget__header">
                        <h3>分类</h3>
                    </div>
                    <div class="ps-widget__content">
                        <ul class="ps-list--checked">
                            @foreach($categories as $category)
                                <li><a href="product-listing.html">{{$category->name}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </aside>
            </div>

        </div>

@endsection
