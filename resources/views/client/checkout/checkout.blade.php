@extends('client/layout-main')

@section('title', 'Thanh Toán')

@section('content')

    <div class="container">
        <div class="breadcrumbs mb-4">
            <div class="row">
                <div class="col">
                    <p class="bread"><span><a href="/">Trang chủ</a></span> / <span>Thanh toán</span></p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="mb-5 information-address-of-my">
                    <h4 class="ml-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor"
                            class="bi bi-geo-alt" viewBox="0 0 16 16">
                            <path
                                d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A32 32 0 0 1 8 14.58a32 32 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10" />
                            <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4m0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                        </svg>
                        <span>Thông tin địa chỉ giao hàng</span>
                    </h4>
                    @if ($shipping != null)
                        <div class="p-2">
                            <div class="d-flex">
                                <h6 class="mr-2 mb-3">{{ $shipping->fullname }}</h6>
                                <h6 class="mr-2">|</h6>
                                <h6 class="mr-2">{{ $shipping->phone_number }}</h6>
                                @if ($shipping->address_type == 'HOME')
                                    <h6 class="mr-2">|</h6>
                                    <h6 class="mr-2">Nhà riêng</h6>
                                @endif
                                @if ($shipping->address_type == 'OFFICE')
                                    <h6 class="mr-2">|</h6>
                                    <h6 class="mr-2">Văn phòng</h6>
                                @endif
                            </div>
                            <h6>Địa chỉ: <span class="text-danger">Mặc định</span></h6>
                            <div class="d-flex justify-content-between">
                                <div class="d-flex">
                                    <span
                                        class="mr-2">{{ $shipping->address_specific . ' - ' . optional($shipping->ward)->ward_name . ', ' . optional($shipping->district)->district_name . ', ' . optional($shipping->city)->city_name }}</span>
                                </div>
                                <div>
                                    <span class="text-primary cursor-pointer" onclick="showAllShippingModal()">Thay
                                        đổi</span>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="d-flex p-2">
                            <span class="cursor-pointer" onclick="showAddShippingModal()">Thêm mới</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="bg-light pt-4 pr-4 pb-1 pl-4 d-flex justify-content-between">
                    <h5 class="color-main d-inline-block">Hình thức thanh toán</h5>
                    <a class="card-a" onclick="changePayment()">Thay đổi</a>
                </div>
                <div class="bg-light pb-4 pl-4">
                    <input type="radio" name="payments" class="d-inline-block mr-2" checked />
                    <img src="/images/payments/cod-money.jpg" width="50" height="50"
                        class="d-inline-block mr-2 img-thumbnail" />
                    <span>Thanh toán khi nhận hàng (COD)</span>
                </div>
            </div>
        </div>

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
                                                <input type="text" id="quantity-{{ $item['variantId'] }}"
                                                    name="quantity" class="form-control input-number quantity-cart"
                                                    value="{{ $item['quantity'] }}" min="1" readonly>
                                            </div>
                                        </form>
                                    </td>
                                    <td id="total-{{ $item['variantId'] }}">
                                        {{ number_format(($item['price_variant'] - ($item['price_variant'] * $item['discount']) / 100) * $item['quantity'], 0, ',', '.') }}
                                        VND</td>
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
                                            <p><span>Giá tiền:</span> <span
                                                    id="total-price">{{ number_format($totalPrice, 0, ',', '.') }}
                                                    VND</span></p>
                                            <p><span>Giảm giá:</span> <span>0</span></p>
                                            <p><span>Phí vận chuyển:</span> <span>0</span></p>
                                        </div>
                                        <div class="grand-total">
                                            <p><span><strong>Tổng giá tiền:</strong></span>
                                                <span
                                                    id="total-of-all-prices">{{ number_format($totalPrice, 0, ',', '.') }}
                                                    VND</span>
                                            </p>
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

        <!-- Form thêm địa chỉ nhận hàng -->
        <div id="addShippingModal" class="modal">
            <div class="modal-content">
                <div class="close" onclick="closeAddShippingModal()">
                    <span>&times;</span>
                </div>
                <h2>Thêm địa chỉ nhận hàng mới</h2>
                <form class="form-shipping" onsubmit="return validateShipping()">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="fullName">Họ tên</label>
                                <input type="text" id="fullName" name="fullName" class="form-control" />
                                <small class="text-danger" id="fullNameError"></small>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="phoneNumber">Số điện thoại</label>
                                <input type="text" id="phoneNumber" name="phoneNumber" class="form-control" />
                                <small class="text-danger" id="phoneNumberError"></small>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" id="email" name="email" class="form-control" />
                                <small class="text-danger" id="emailError"></small>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="city">Thành phố</label>
                                <select name="city" id="city" class="form-control" onchange="fetchDistricts()">
                                    <option value="">Chọn thành phố</option>
                                    @foreach ($cities as $city)
                                        <option value="{{ $city->city_id }}">{{ $city->city_name }}</option>
                                    @endforeach
                                </select>
                                <small class="text-danger" id="cityError"></small>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="district">Quận huyện</label>
                                <select name="district" id="district" class="form-control" onchange="fetchWards()">
                                    <option value="">Chọn quận huyện</option>
                                </select>
                                <small class="text-danger" id="districtError"></small>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="ward">Xã phường</label>
                                <select name="ward" id="ward" class="form-control">
                                    <option value="">Chọn xã phường</option>
                                </select>
                                <small class="text-danger" id="wardError"></small>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="specific">Địa chỉ cụ thể</label>
                                <input type="text" id="specific" name="specific" class="form-control" />
                                <small class="text-danger" id="specificError"></small>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Loại địa chỉ</label>
                                <div class="d-flex">
                                    <label for="radio-home" class="radio-block mr-3">
                                        <input type="radio" id="radio-home" class="radio-home" name="radio-shipping"
                                            value="HOME">
                                        <span class="radio-text">Nhà Riêng</span>
                                    </label>
                                    <label for="radio-office">
                                        <input type="radio" id="radio-office" class="radio-office"
                                            name="radio-shipping" value="OFFICE">
                                        <span class="radio-text">Công Ty</span>
                                    </label>
                                    <label for="radio-no" class="d-none">
                                        <input type="radio" id="radio-no" class="radio-no" name="radio-shipping"
                                            value="NO" checked>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <input type="submit" value="Thêm" class="btn btn-primary">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div id="showAllShippingModal" class="modal">
            <div class="modal-content">
                <div class="close" onclick="closeShowAllShippingModal()">
                    <span>&times;</span>
                </div>
                <h4 class="mb-0">ĐỊA CHỈ CỦA TÔI</h4>
                <form>
                    @csrf
                    <div id="all-shipping"></div>
                </form>
                <div class="d-flex mb-0 mt-5">
                    <div class="form-group">
                        <input type="submit" value="Lưu thay đổi" class="btn btn-success"
                            onclick="selectThisAddressAsTheDefaultAddress()" />
                    </div>
                    <div class="form-group">
                        <span class="cursor-pointer btn btn-primary" onclick="showAddShippingModal()">Thêm mới</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
