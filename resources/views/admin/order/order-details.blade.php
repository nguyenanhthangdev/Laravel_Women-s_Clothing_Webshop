@extends('admin/layout-main')

@section('title', 'CHI TIẾT ĐƠN HÀNG')

@section('content')
    <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">CHI TIẾT ĐƠN HÀNG</h1>
        </div>
        @if (session('success'))
            <div class="alert alert-success text-center">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger text-center">
                {{ session('error') }}
            </div>
        @endif
        <div class="row">
            <div class="col-lg-12 mb-4">
                <!-- Simple Tables -->
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">
                            Thông Tin Người Đặt Hàng
                        </h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>Mã Đơn Hàng</th>
                                    <th>Người Đặt Hàng</th>
                                    <th>Trạng Thái</th>
                                    @if ($order->status == 'CANCELLED')
                                        <th>Lý Do Hủy</th>
                                    @endif
                                    <th>Tổng Đơn Giá</th>
                                    <th>Ngày Tạo Đơn Hàng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $order->order_code }}</td>
                                    <td>{{ $order->shipping->fullname }}</td>
                                    @if ($order->status == 'ORDERED')
                                        <th><span class="status-order ordered">Đặt hàng</span></th>
                                    @endif
                                    @if ($order->status == 'PROCESSING')
                                        <th><span class="status-order processing">Đang xử lý</span></th>
                                    @endif
                                    @if ($order->status == 'SHIPPED')
                                        <th><span class="status-order shipped">Đang giao hàng</span></th>
                                    @endif
                                    @if ($order->status == 'DELIVERED')
                                        <th><span class="status-order delivered">Đã giao hàng</span></th>
                                    @endif
                                    @if ($order->status == 'CANCELLED')
                                        <th><span class="status-order cancelled">Đã hủy</span></th>
                                        <th>{{ $order->cancellation_reason }}</th>
                                    @endif
                                    <td>{{ number_format($order->total_amount, 0, ',', '.') }} VND</td>
                                    <td>{{ $order->created_at->format('d/m/Y H:i:s') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 mb-4">
                <!-- Simple Tables -->
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">
                            Chi Tiết Đơn Hàng
                        </h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>Sản Phẩm</th>
                                    <th>Màu</th>
                                    <th>Kích Thước</th>
                                    <th>Số Lượng</th>
                                    <th>Giá Tiền</th>
                                    <th>Tổng Giá Tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orderDetails as $orderDetail)
                                    <tr>
                                        <td>
                                            {{ \Illuminate\Support\Str::limit($orderDetail->productVariant->product->name, 30) }}
                                        </td>
                                        <td>{{ $orderDetail->productVariant->color->name }}</td>
                                        <td>{{ $orderDetail->productVariant->size->name }}</td>
                                        <td>{{ $orderDetail->quantity }}</td>
                                        <td>{{ number_format($orderDetail->unit_price, 0, ',', '.') }} VND</td>
                                        <td>{{ number_format($orderDetail->total_price, 0, ',', '.') }} VND</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        @if ($order->status != 'CANCELLED')
            @if ($order->status != 'DELIVERED')
                <div class="d-flex justify-content-end mb-3">
                    <a class="custom-btn-order cancelled text-white mr-2" onclick="showOrderCancelModal()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-x-circle text-white" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                            <path
                                d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                        </svg>
                        <span>Hủy đơn hàng</span>
                    </a>
                    @if ($order->status == 'ORDERED')
                        <a class="custom-btn-order processing text-white" id="processOrderButton"
                            data-order_code="{{ $order->order_code }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-gear text-white" viewBox="0 0 16 16">
                                <path
                                    d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492M5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0" />
                                <path
                                    d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115z" />
                            </svg>
                            <span>Xử lý</span>
                        </a>
                    @endif
                    @if ($order->status == 'PROCESSING')
                        <a class="custom-btn-order shipped text-white" id="shippedOrderButton"
                            data-order_code="{{ $order->order_code }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-truck text-white" viewBox="0 0 16 16">
                                <path
                                    d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5zm1.294 7.456A2 2 0 0 1 4.732 11h5.536a2 2 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456M12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2" />
                            </svg>
                            <span>Giao hàng</span>
                        </a>
                    @endif
                    @if ($order->status == 'SHIPPED')
                        <a class="custom-btn-order delivered text-white" id="deliveredOrderButton"
                            data-order_code="{{ $order->order_code }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-check-circle text-white" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                <path
                                    d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05" />
                            </svg>
                            <span>Đã giao hàng</span>
                        </a>
                    @endif
                </div>
            @endif
        @endif

        <div id="showOrderCancelModal" class="modal">
            <div class="modal-content">
                <div class="d-flex justify-content-end">
                    <div class="close" onclick="closeOrderCancelModal()">
                        <span>&times;</span>
                    </div>
                </div>
                <h4 class="mb-4">LÝ DO HỦY ĐƠN HÀNG</h4>
                <form>
                    @csrf
                    <input type="hidden" id="order-code" value="{{ $order->order_code }}" readonly>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="cancellation_reason" id="reason6"
                            value="HET_HANG">
                        <label class="form-check-label ml-1" for="reason6">
                            Hết hàng
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="cancellation_reason" id="reason7"
                            value="LY_DO_KHAC">
                        <label class="form-check-label ml-1" for="reason7">
                            Tôi không tìm thấy lý do hủy phù hợp
                        </label>
                    </div>
                </form>
                <div class="d-flex mb-0 mt-4">
                    <a class="custom-btn-order cancelled text-white mr-2" id="cancelOrderButton">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-x-circle text-white" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                            <path
                                d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                        </svg>
                        <span>Hủy đơn hàng</span>
                    </a>
                </div>
            </div>
        </div>

    </div>
    <!---Container Fluid-->
@endsection
