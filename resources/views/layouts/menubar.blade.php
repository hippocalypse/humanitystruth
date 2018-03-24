<?php
//load shopping cart
    if (Session::get('products')) {
        $cart_summary = "$" . number_format(Session::get('total'), 2) . " ";
        $num = count(Session::get('products'));

        if ($num > 0) {
            $cart_summary .= "(" . $num . " PRODUCT" . ($num == 1 ? "" : "S") . ")";
        } else {
            $cart_summary .= "(0 PRODUCTS)";
        }
    } else {
        $cart_summary = "$0.00 (0 PRODUCTS)";
    }
?>

<div id="menu-bar" class="w3-bar w3-black w3-mobile">
    @if(Request::url() === 'shop')
        <div class="shopping-cart w3-button w3-bar-item w3-right w3-mobile">
            <a href="/shopping-cart">{{$cart_summary}}</a>
        </div>';

    @else
        <div class="shopping-cart w3-button w3-bar-item w3-right w3-mobile"><a href="/shop">SHOP</a></div>
        @if(Session::get('products'))
            <div class="shopping-cart w3-button w3-bar-item w3-right w3-mobile">
                <a href="/shopping-cart">{{$cart_summary}}</a>
            </div>
        @endif
        
    @endif
    <div class="w3-button w3-bar-item w3-right w3-mobile"><a href="/donate">DONATE</a></div>
    <div class="w3-button w3-bar-item w3-right w3-mobile"><a href="/contact">CONTACT</a></div>
    <div class="w3-button w3-bar-item w3-right w3-mobile"><a href="/securedrop">SECURE DROP</a></div>
    <div class="w3-button w3-bar-item w3-right w3-mobile"><a href="/download">DOWNLOAD</a></div>
    <div class="w3-button w3-bar-item w3-right w3-mobile"><a href="/join">JOIN</a></div>
    @guest
        <div class="w3-button w3-bar-item w3-right w3-mobile"><a href="{{ route('login') }}">LOGIN</a></div>
        <div class="w3-button w3-bar-item w3-right w3-mobile"><a href="{{ route('register') }}">REGISTER</a></div>
    @else
        @if(Auth::user()->role == 'super_admin' || Auth::user()->role == 'admin')
            <div class="w3-button w3-bar-item w3-mobile"><a href="/backend">ADMIN</a></div>
        @endif
        <div class="w3-button w3-bar-item w3-right w3-mobile"><a href="/profile">{{ Auth::user()->email }}</a></div>
        <div class="w3-button w3-bar-item w3-right w3-mobile">
            <a href="{{ route('logout') }}" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
                LOGOUT
            </a>
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: hidden;">
            @csrf
        </form>
    @endguest
</div>