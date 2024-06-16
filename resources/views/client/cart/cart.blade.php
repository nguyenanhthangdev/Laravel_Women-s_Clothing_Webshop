@extends('client/layout-main')

@section('title', 'Trang Chủ')

@section('content')

    <div class="container">
        @if (count($cart) > 0)
            <div id="cart-table">
                <h1 class="mt-4">Giỏ hàng của bạn</h1>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Hình Ảnh</th>
                                <th scope="col">Tên</th>
                                <th scope="col">Phân Loại Hàng</th>
                                <th scope="col">Giá Tiền</th>
                                <th scope="col">Số Lượng</th>
                                <th scope="col">Tổng Giá</th>
                                <th scope="col">Xóa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cart as $item)
                                <tr id="cart-item-{{ $item['variantId'] }}">
                                    <th><img src="{{ asset('backend/images/option/' . $item['image_variant']) }}"
                                            width="100" height="100" class="img-fluid img-thumbnail"></th>
                                    <td>{{ \Illuminate\Support\Str::limit($item['product_name'], 30) }}</td>
                                    <td>{{ $item['color_name'] }}, {{ $item['size_name'] }}</td>
                                    <td>
                                        <span
                                            class="d-block">{{ number_format($item['price_variant'] - ($item['price_variant'] * $item['discount']) / 100, 0, ',', '.') }}
                                            VND</span>
                                        @if ($item['discount'] > 0)
                                            <del class="d-block">{{ number_format($item['price_variant'], 0, ',', '.') }}
                                                VND</del>
                                        @endif
                                    </td>
                                    <td>
                                        <form>
                                            @csrf
                                            <div class="input-group mb-4">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn" data-type="minus" data-field=""
                                                        onclick="decreaseQuantity({{ $item['variantId'] }})">
                                                        <i class="icon-minus2"></i>
                                                    </button>
                                                </span>
                                                <input type="hidden" id="price-{{ $item['variantId'] }}"
                                                    value="{{ $item['price_variant'] }}" readonly />
                                                <input type="hidden" id="discount-{{ $item['variantId'] }}"
                                                    value="{{ $item['discount'] }}" readonly />
                                                <input type="text" id="quantity-{{ $item['variantId'] }}"
                                                    name="quantity" class="form-control input-number quantity-cart"
                                                    value="{{ $item['quantity'] }}" min="1" readonly>
                                                <span class="input-group-btn ml-1">
                                                    <button type="button" class="btn" data-type="plus" data-field=""
                                                        onclick="increaseQuantity({{ $item['variantId'] }})">
                                                        <i class="icon-plus2"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </form>
                                    </td>
                                    <td id="total-{{ $item['variantId'] }}">
                                        {{ number_format(($item['price_variant'] - ($item['price_variant'] * $item['discount']) / 100) * $item['quantity'], 0, ',', '.') }}
                                        VND</td>
                                    <td><i class="icon-delete" onclick="removeFromCart({{ $item['variantId'] }})"></i></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <hr />
                <div class="row row-pb-lg">
                    <div class="col-md-12">
                        <div class="total-wrap">
                            <div class="row">
                                <div class="col-sm-7">
                                </div>
                                <div class="col-sm-5 text-center">
                                    <div class="total mb-3">
                                        <div class="sub">
                                            <p><span>Giá tiền:</span> <span id="total-price">{{ number_format($totalPrice, 0, ',', '.') }}
                                                    VND</span></p>
                                            <p><span>Giảm giá:</span> <span>0</span></p>
                                            <p><span>Phí vận chuyển:</span> <span>0</span></p>
                                        </div>
                                        <div class="grand-total">
                                            <p><span><strong>Tổng giá tiền:</strong></span>
                                                <span id="total-of-all-prices">{{ number_format($totalPrice, 0, ',', '.') }} VND</span></p>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <a type="button" class="btn btn-secondary" href="javascript:void(0)"
                                            onclick="checkLogin()">Thanh toán</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div>
                <h1 class="mt-4">Giỏ hàng của bạn trống</h1>
                <a type="button" class="btn btn-secondary" href="/">Tiếp tục mua hàng</a>
            </div>
        @endif
        <div id="cart-empty">
            <h1 class="mt-4">Giỏ hàng của bạn trống</h1>
            <a type="button" class="btn btn-secondary" href="/">Tiếp tục mua hàng</a>
        </div>
    </div>

@endsection
