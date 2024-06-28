@extends('admin/layout-main')

@section('title', 'ĐƠN HÀNG')

@section('content')
    <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">DANH SÁCH ĐƠN HÀNG</h1>
        </div>

        @if ($orders->count() > 0)
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
                                Đơn Hàng
                            </h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Mã Đơn Hàng</th>
                                        <th>Người Đặt Hàng</th>
                                        <th>Trạng Thái</th>
                                        <th>Ngày Tạo Đơn Hàng</th>
                                        <th>Xem Chi Tiết</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
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
                                            @endif
                                            <td>{{ $order->created_at->format('d/m/Y H:i:s') }}</td>
                                            <th><a class="button-edit mb-1" title="Xem chi tiết"
                                                    href="/admin/order-details/{{ $order->order_code }}"><svg xmlns="http://www.w3.org/2000/svg"
                                                        width="16" height="16" fill="currentColor" class="bi bi-eye"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                                        <path
                                                            d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                                    </svg></a></th>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="list-empty">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-clipboard2-x" viewBox="0 0 16 16">
                    <path
                        d="M9.5 0a.5.5 0 0 1 .5.5.5.5 0 0 0 .5.5.5.5 0 0 1 .5.5V2a.5.5 0 0 1-.5.5h-5A.5.5 0 0 1 5 2v-.5a.5.5 0 0 1 .5-.5.5.5 0 0 0 .5-.5.5.5 0 0 1 .5-.5z" />
                    <path
                        d="M3 2.5a.5.5 0 0 1 .5-.5H4a.5.5 0 0 0 0-1h-.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1H12a.5.5 0 0 0 0 1h.5a.5.5 0 0 1 .5.5v12a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5z" />
                    <path
                        d="M8 8.293 6.854 7.146a.5.5 0 1 0-.708.708L7.293 9l-1.147 1.146a.5.5 0 0 0 .708.708L8 9.707l1.146 1.147a.5.5 0 0 0 .708-.708L8.707 9l1.147-1.146a.5.5 0 0 0-.708-.708z" />
                </svg>
                <p>Không tìm thấy màu nào</p>
            </div>
        @endif
    </div>
    <!---Container Fluid-->
@endsection
