@extends('client/layout-main')

@section('title', 'Trang Chủ')

@section('content')

    <div class="colorlib-product">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 offset-sm-2 text-center colorlib-heading">
                    <h2>THƯƠNG HIỆU: {{ $manufacturer->name }}</h2>
                </div>
            </div>
            @if ($products->isEmpty())
                <div class="list-empty-home">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-clipboard2-x" viewBox="0 0 16 16">
                        <path
                            d="M9.5 0a.5.5 0 0 1 .5.5.5.5 0 0 0 .5.5.5.5 0 0 1 .5.5V2a.5.5 0 0 1-.5.5h-5A.5.5 0 0 1 5 2v-.5a.5.5 0 0 1 .5-.5.5.5 0 0 0 .5-.5.5.5 0 0 1 .5-.5z" />
                        <path
                            d="M3 2.5a.5.5 0 0 1 .5-.5H4a.5.5 0 0 0 0-1h-.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1H12a.5.5 0 0 0 0 1h.5a.5.5 0 0 1 .5.5v12a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5z" />
                        <path
                            d="M8 8.293 6.854 7.146a.5.5 0 1 0-.708.708L7.293 9l-1.147 1.146a.5.5 0 0 0 .708.708L8 9.707l1.146 1.147a.5.5 0 0 0 .708-.708L8.707 9l1.147-1.146a.5.5 0 0 0-.708-.708z" />
                    </svg>
                    <p>Không tìm sản phẩm nào!</p>
                </div>
            @else
                <div class="row row-pb-md">
                    @foreach ($products as $product)
                        <div class="col-lg-3 mb-4 text-center">
                            <a href="/product-details/{{ $product->product_id }}">
                                <div class="product-entry border">
                                    <span class="prod-img">
                                        <img src="{{ asset('backend/images/product/' . $product->image) }}"
                                            class="img-fluid">
                                        @if ($product->discount > 0)
                                            <span class="discount-badge">-{{ $product->discount }}%</span>
                                        @endif
                                    </span>
                                    <div class="desc">
                                        <h2>{{ \Illuminate\Support\Str::limit($product->name, 30) }}</h2>
                                        @if ($product->discount > 0)
                                            @php
                                                // Tính giá sau khi giảm giá
                                                $minDiscountedPrice =
                                                    $product->min_price * (1 - $product->discount / 100);
                                                $maxDiscountedPrice =
                                                    $product->max_price * (1 - $product->discount / 100);
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
            @endif
        </div>
    </div>

@endsection
