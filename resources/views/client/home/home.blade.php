@extends('client/layout-main')

@section('title', 'Trang Chủ')

@section('content')

    <div class="sale">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 offset-sm-2 text-center">
                    <div class="row">
                        <div class="owl-carousel2">
                            <div class="item">
                                <div class="col">
                                    <h3><a href="#">25% off (Almost) Everything! Use Code: Summer Sale</a></h3>
                                </div>
                            </div>
                            <div class="item">
                                <div class="col">
                                    <h3><a href="#">Our biggest sale yet 50% off all summer shoes</a></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </nav>
    <aside id="colorlib-hero">
        <div class="flexslider">
            <ul class="slides">
                @foreach ($banners as $banner)
                    <li style="background-image: url('{{ asset('backend/images/banner/' . $banner->image) }}');"></li>
                @endforeach
            </ul>
        </div>
    </aside>

    <div class="colorlib-product">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 offset-sm-2 text-center colorlib-heading">
                    <h2>SẢN PHẨM NỔI BẬT</h2>
                </div>
            </div>
            <div class="row row-pb-md">
                @foreach ($products as $product)
                    <div class="col-lg-3 mb-4 text-center">
                        <a href="/product-details/{{ $product->product_id }}">
                            <div class="product-entry border">
                                <span class="prod-img">
                                    <img src="{{ asset('backend/images/product/' . $product->image) }}" class="img-fluid">
                                    @if ($product->discount > 0)
                                        <span class="discount-badge">-{{ $product->discount }}%</span>
                                    @endif
                                </span>
                                <div class="desc">
                                    <h2>{{ \Illuminate\Support\Str::limit($product->name, 30) }}</h2>
                                    @if ($product->discount > 0)
                                        @php
                                            // Tính giá sau khi giảm giá
                                            $minDiscountedPrice = $product->min_price * (1 - $product->discount / 100);
                                            $maxDiscountedPrice = $product->max_price * (1 - $product->discount / 100);
                                        @endphp
                                        <del class="price">
                                            {{ number_format($product->min_price, 0, ',', ',') }} VND -
                                            {{ number_format($product->max_price, 0, ',', ',') }} VND
                                        </del>
                                        <span class="price">
                                            {{ number_format($minDiscountedPrice, 0, ',', ',') }} VND -
                                            {{ number_format($maxDiscountedPrice, 0, ',', ',') }} VND
                                        </span>
                                    @else
                                        <span class="price">
                                            {{ number_format($product->min_price, 0, ',', ',') }} VND -
                                            {{ number_format($product->max_price, 0, ',', ',') }} VND
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="colorlib-product">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 offset-sm-2 text-center colorlib-heading">
                    <h2>BÀI VIẾT MỚI NHẤT</h2>
                </div>
            </div>
            <div class="row row-pb-md">
                @foreach ($posts as $post)
                    <div class="col-lg-3 mb-4 text-center">
                        <a href="/post-details/{{ $post->post_id }}">
                            <div class="product-entry border">
                                <img src="{{ asset('backend/images/post/' . $post->image) }}" class="img-fluid">
                                <div class="desc">
                                    <h2>{{ \Illuminate\Support\Str::limit($post->title, 30) }}</h2>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="colorlib-partner">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 offset-sm-2 text-center colorlib-heading colorlib-heading-sm">
                    <h2>Trusted Partners</h2>
                </div>
            </div>
            <div class="row">
                <div class="col partner-col text-center">
                    <img src="images/brand-1.jpg" class="img-fluid" alt="Free html4 bootstrap 4 template">
                </div>
                <div class="col partner-col text-center">
                    <img src="images/brand-2.jpg" class="img-fluid" alt="Free html4 bootstrap 4 template">
                </div>
                <div class="col partner-col text-center">
                    <img src="images/brand-3.jpg" class="img-fluid" alt="Free html4 bootstrap 4 template">
                </div>
                <div class="col partner-col text-center">
                    <img src="images/brand-4.jpg" class="img-fluid" alt="Free html4 bootstrap 4 template">
                </div>
                <div class="col partner-col text-center">
                    <img src="images/brand-5.jpg" class="img-fluid" alt="Free html4 bootstrap 4 template">
                </div>
            </div>
        </div>
    </div>

@endsection
