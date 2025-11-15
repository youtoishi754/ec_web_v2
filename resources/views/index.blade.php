@extends('layouts.parents')
@section('title', 'ECサイト')
@section('content')

<div class="container">
    <div class="top">
        <div class="welcome">
        <p>商品を探索し、ショッピング体験をお楽しみください！</p>

        <!-- Bootstrap4 carousel with indicators; slides use dummy.png -->
        <div id="welcomeCarousel" class="carousel slide" data-ride="carousel" data-interval="3000">
            <ol class="carousel-indicators">
                <li data-target="#welcomeCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#welcomeCarousel" data-slide-to="1"></li>
                <li data-target="#welcomeCarousel" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('public/site-image/dummy_one.png') }}" class="d-block w-100" alt="スライド1">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('public/site-image/dummy_two.png') }}" class="d-block w-100" alt="スライド2">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('public/site-image/dummy_three.png') }}" class="d-block w-100" alt="スライド3">
                </div>
            </div>
            <a class="carousel-control-prev" href="#welcomeCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#welcomeCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        </div>
        <div class="notice-list">
            <h3>お知らせ</h3>
            <ul class="notices">
                <li>お知らせ 1 — セール情報</li>
                <li>お知らせ 2 — 新規入荷</li>
                <li>お知らせ 3 — メンテナンス案内</li>
                <li>お知らせ 4 — 会員限定クーポン</li>
            </ul>
        </div>

        <div class="new-products">
            <h3>新着商品</h3>
            <a href="#">新着商品一覧へ</a>
            <div class="products">
                <div class="product">
                    <img src="{{ asset('public/product-image/dummy.png') }}" alt="新着商品1">
                    <p class="p-title">新着商品 1</p>
                </div>
                <div class="product">
                    <img src="{{ asset('public/product-image/dummy.png') }}" alt="新着商品2">
                    <p class="p-title">新着商品 2</p>
                </div>
                <div class="product">
                    <img src="{{ asset('public/product-image/dummy.png') }}" alt="新着商品3">
                    <p class="p-title">新着商品 3</p>
                </div>
                <div class="product">
                    <img src="{{ asset('public/product-image/dummy.png') }}" alt="新着商品4">
                    <p class="p-title">新着商品 4</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection