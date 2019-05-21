<header class="header">
    <div class="header__top">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 col-md-8 col-sm-6 col-xs-12 ">
                    <p>地址:xxxxxxxxxxxxxx</p>
                </div>
                <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12 ">
                    <div class="header__actions">
                    @guest
                        <a href="{{route('login')}}">登录</a>
                        <a href="{{route('register')}}">注册</a>
                    @else
                            <a href="#">{{\Illuminate\Support\Facades\Auth::user()->name}}个人中心</a>
                            <a href="#"  onclick="event.preventDefault();document.getElementById('logout-form').submit();">退出登录</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                            </form>
                        <div class="btn-group ps-dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">其他信息<i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{route('user.addresses.index')}}"> 我的收货地址</a></li>
                                <li><a href="{{route('orders.index')}}"> 我的订单</a></li>

                            </ul>
                        </div>

                    @endguest

                    </div>
                </div>
            </div>
        </div>
    </div>
    <nav class="navigation">
        <div class="container-fluid">
            <div class="navigation__column left">
                <div class="header__logo"><a class="ps-logo" href="{{route('root')}}"><img src="{{asset('images/logo.png')}}" alt=""></a></div>
            </div>
            <div class="navigation__column center">
                <ul class="main-menu menu">
                    @foreach($categories as $category)
                        <li class="menu-item menu-item-has-children has-mega-menu"><a href="#">{{$category["name"]}}</a>
                            <div class="mega-menu">
                                <div class="mega-wrap">
                                    <div class="mega-column">
                                        <ul class="mega-item mega-features">
                                            @foreach($category['children'] as $item)
                                            <li><a href="{{ route('goods.category.show',$item['id']) }}">{{$item['name']}}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                        </div>
                    @endforeach
                    </li>
                    <li class="menu-item"><a href="#">其他</a></li>
                </ul>
            </div>
            <div class="navigation__column right">
                <form class="ps-search--header" action="do_action" method="post">
                    <input class="form-control" type="text" placeholder="Search Product…">
                    <button><i class="ps-icon-search"></i></button>
                </form>
                <div class="ps-cart"><a class="ps-cart__toggle" href="{{route('cart.index')}}"><span><i>n</i></span><i class="ps-icon-shopping-cart"></i></a>
{{--                    <div class="ps-cart__listing">--}}
{{--                        <div class="ps-cart__content">--}}
{{--                            <div class="ps-cart-item"><a class="ps-cart-item__close" href="#"></a>--}}
{{--                                <div class="ps-cart-item__thumbnail"><a href="product-detail.html"></a><img src="{{asset('images/cart-preview/1.jpg')}}" alt=""></div>--}}
{{--                                <div class="ps-cart-item__content"><a class="ps-cart-item__title" href="#">购物车1</a>--}}
{{--                                    <p><span>Quantity:<i>12</i></span><span>Total:<i>£176</i></span></p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="ps-cart__total">--}}
{{--                            <p>Number of items:<span>36</span></p>--}}
{{--                            <p>Item Total:<span>£528.00</span></p>--}}
{{--                        </div>--}}
{{--                        <div class="ps-cart__footer"><a class="ps-btn" href="cart.html">购物车详情<i class="ps-icon-arrow-left"></i></a></div>--}}
{{--                    </div>--}}
                </div>
                <div class="menu-toggle"><span></span></div>
            </div>
        </div>
    </nav>
</header>

<div class="header-services">
    <div class="ps-services owl-slider" data-owl-auto="true" data-owl-loop="true" data-owl-speed="7000" data-owl-gap="0" data-owl-nav="true" data-owl-dots="false" data-owl-item="1" data-owl-item-xs="1" data-owl-item-sm="1" data-owl-item-md="1" data-owl-item-lg="1" data-owl-duration="1000" data-owl-mousedrag="on">
        <p class="ps-service"><i class="ps-icon-delivery"></i><strong>Free delivery</strong>:消息1</p>
        <p class="ps-service"><i class="ps-icon-delivery"></i><strong>Free delivery</strong>:消息1</p>
        <p class="ps-service"><i class="ps-icon-delivery"></i><strong>Free delivery</strong>:消息1</p>
    </div>
</div>