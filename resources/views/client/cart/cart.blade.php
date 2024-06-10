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
                                        <div class="input-group mb-4">
                                            <span class="input-group-btn">
                                                <button type="button" class="quantity-left-minus btn" data-type="minus"
                                                    data-field="">
                                                    <i class="icon-minus2"></i>
                                                </button>
                                            </span>
                                            <input type="text" id="quantity-{{ $item['variantId'] }} quantity"
                                                name="quantity" class="form-control input-number quantity-cart"
                                                value="{{ $item['quantity'] }}" min="1" max="100" readonly>
                                            <span class="input-group-btn ml-1">
                                                <button type="button" class="quantity-right-plus btn" data-type="plus"
                                                    data-field="">
                                                    <i class="icon-plus2"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </td>
                                    <td>{{ number_format(($item['price_variant'] - ($item['price_variant'] * $item['discount']) / 100) * $item['quantity'], 0, ',', '.') }}
                                        VND</td>
                                    <td><i class="icon-delete" onclick="removeFromCart({{ $item['variantId'] }})"></i></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="cart-empty">
                <h1 class="mt-4">Giỏ hàng của bạn trống</h1>
                <a type="button" class="btn btn-secondary" href="/">Tiếp tục mua hàng</a>
            </div>
        @else
            <h1 class="mt-4">Giỏ hàng của bạn trống</h1>
            <a type="button" class="btn btn-secondary" href="/">Tiếp tục mua hàng</a>
        @endif
    </div>

@endsection
