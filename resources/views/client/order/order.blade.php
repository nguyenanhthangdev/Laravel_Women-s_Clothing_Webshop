@extends('client/layout-main')

@section('title', 'Đơn Hàng Của Tôi')

@section('content')

    <div class="container">
        <div id="cart-table">
            <h1 class="mt-4">ĐƠN HÀNG CỦA TÔI</h1>

            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#all-order">Tất cả</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#ordered-order">Chờ xử lý</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#processing-order">Đang xử lý</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#shipped-order">Đang giao hàng</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#delivered-order">Hoàn thành</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#cancelled-order">Đã hủy</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div id="all-order" class="container tab-pane fade"><br>
                    <h3 class="mb-5">TẤT CẢ ĐƠN HÀNG</h3>
                    @if ($orders->count() > 0)
                        @foreach ($orders as $order)
                            <table>
                                @foreach ($order->orderDetails as $detail)
                                    <tr>
                                        <td class="d-inline-block mr-3">
                                            <img src="{{ asset('backend/images/option/' . $detail->productVariant->image) }}"
                                                width="100" height="100" class="img-fluid img-thumbnail">
                                        </td>
                                        <td>
                                            <div>
                                                <h6>{{ \Illuminate\Support\Str::limit($detail->productVariant->product->name, 100) }}
                                                </h6>
                                            </div>
                                            <div>Kích thước: {{ $detail->productVariant->size->name }}</div>
                                            <div>Màu: {{ $detail->productVariant->color->name }}</div>
                                            <div>Số lượng: x{{ $detail->quantity }}</div>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            <div class="d-flex justify-content-between mt-3">
                                <div>
                                    <h6>Trạng thái:
                                        @if ($order->status == 'ORDERED')
                                            <span>CHỜ XỬ LÝ</span>
                                        @endif
                                        @if ($order->status == 'PROCESSING')
                                            <span>ĐANG XỬ LÝ</span>
                                        @endif
                                        @if ($order->status == 'SHIPPED')
                                            <span>ĐANG GIAO HÀNG</span>
                                        @endif
                                        @if ($order->status == 'DELIVERED')
                                            <span>ĐÃ GIAO HÀNG</span>
                                        @endif
                                        @if ($order->status == 'CANCELLED')
                                            <span>ĐÃ HỦY</span>
                                        @endif
                                    </h6>
                                </div>
                                <div>
                                    <h6>Mã đơn hàng: {{ $order->order_code }}</h6>
                                </div>
                            </div>
                            @if ($order->status != 'CANCELLED' && $order->status != 'DELIVERED')
                                <div class="d-flex justify-content-end">
                                    <a type="button" class="btn btn-secondary" href="javascript:void(0)"
                                        data-order_id="{{ $order->order_code }}"
                                        onclick="showOrderCancelModal(this.getAttribute('data-order_id'))">Hủy đơn
                                        hàng</a>
                                </div>
                            @endif
                            <hr class="line-hr">
                        @endforeach
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
                            <p>Bạn không có đơn hàng nào!</p>
                        </div>
                    @endif
                </div>
                <div id="ordered-order" class="container tab-pane active"><br>
                    <h3 class="mb-5">TẤT CẢ ĐƠN HÀNG CHỜ XỬ LÝ</h3>
                    @if ($orderedOrders->isEmpty())
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
                            <p>Bạn không có đơn hàng nào!</p>
                        </div>
                    @else
                        @if ($orders->count() > 0)
                            @foreach ($orders as $order)
                                @if ($order->status == 'ORDERED')
                                    <table>
                                        @foreach ($order->orderDetails as $detail)
                                            <tr>
                                                <td class="d-inline-block mr-3">
                                                    <img src="{{ asset('backend/images/option/' . $detail->productVariant->image) }}"
                                                        width="100" height="100" class="img-fluid img-thumbnail">
                                                </td>
                                                <td>
                                                    <div>
                                                        <h6>{{ \Illuminate\Support\Str::limit($detail->productVariant->product->name, 100) }}
                                                        </h6>
                                                    </div>
                                                    <div>Kích thước: {{ $detail->productVariant->size->name }}</div>
                                                    <div>Màu: {{ $detail->productVariant->color->name }}</div>
                                                    <div>Số lượng: x{{ $detail->quantity }}</div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                    <div class="d-flex justify-content-between mt-3">
                                        <div>
                                            <h6>Trạng thái:
                                                @if ($order->status == 'ORDERED')
                                                    <span>CHỜ XỬ LÝ</span>
                                                @endif
                                                @if ($order->status == 'PROCESSING')
                                                    <span>ĐANG XỬ LÝ</span>
                                                @endif
                                                @if ($order->status == 'SHIPPED')
                                                    <span>ĐANG GIAO HÀNG</span>
                                                @endif
                                                @if ($order->status == 'DELIVERED')
                                                    <span>ĐÃ GIAO HÀNG</span>
                                                @endif
                                                @if ($order->status == 'CANCELLED')
                                                    <span>ĐÃ HỦY</span>
                                                @endif
                                            </h6>
                                        </div>
                                        <h6>Mã đơn hàng: {{ $order->order_code }}</h6>
                                    </div>
                                    @if ($order->status != 'CANCELLED' && $order->status != 'DELIVERED')
                                        <div class="d-flex justify-content-end">
                                            <a type="button" class="btn btn-secondary" href="javascript:void(0)"
                                                data-order_id="{{ $order->order_code }}"
                                                onclick="showOrderCancelModal(this.getAttribute('data-order_id'))">Hủy đơn
                                                hàng</a>
                                        </div>
                                    @endif
                                    <hr class="line-hr">
                                @endif
                            @endforeach
                        @endif
                    @endif
                </div>
                <div id="processing-order" class="container tab-pane fade"><br>
                    <h3 class="mb-5">TẤT CẢ ĐƠN HÀNG ĐANG XỬ LÝ</h3>
                    @if ($processingOrders->isEmpty())
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
                            <p>Bạn không có đơn hàng nào!</p>
                        </div>
                    @else
                        @if ($orders->count() > 0)
                            @foreach ($orders as $order)
                                @if ($order->status == 'PROCESSING')
                                    <table>
                                        @foreach ($order->orderDetails as $detail)
                                            <tr>
                                                <td class="d-inline-block mr-3">
                                                    <img src="{{ asset('backend/images/option/' . $detail->productVariant->image) }}"
                                                        width="100" height="100" class="img-fluid img-thumbnail">
                                                </td>
                                                <td>
                                                    <div>
                                                        <h6>{{ \Illuminate\Support\Str::limit($detail->productVariant->product->name, 100) }}
                                                        </h6>
                                                    </div>
                                                    <div>Kích thước: {{ $detail->productVariant->size->name }}</div>
                                                    <div>Màu: {{ $detail->productVariant->color->name }}</div>
                                                    <div>Số lượng: x{{ $detail->quantity }}</div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                    <div class="d-flex justify-content-between mt-3">
                                        <div>
                                            <h6>Trạng thái:
                                                @if ($order->status == 'ORDERED')
                                                    <span>CHỜ XỬ LÝ</span>
                                                @endif
                                                @if ($order->status == 'PROCESSING')
                                                    <span>ĐANG XỬ LÝ</span>
                                                @endif
                                                @if ($order->status == 'SHIPPED')
                                                    <span>ĐANG GIAO HÀNG</span>
                                                @endif
                                                @if ($order->status == 'DELIVERED')
                                                    <span>ĐÃ GIAO HÀNG</span>
                                                @endif
                                                @if ($order->status == 'CANCELLED')
                                                    <span>ĐÃ HỦY</span>
                                                @endif
                                            </h6>
                                        </div>
                                        <h6>Mã đơn hàng: {{ $order->order_code }}</h6>
                                    </div>
                                    @if ($order->status != 'CANCELLED' && $order->status != 'DELIVERED')
                                        <div class="d-flex justify-content-end">
                                            <a type="button" class="btn btn-secondary" href="javascript:void(0)"
                                                data-order_id="{{ $order->order_code }}"
                                                onclick="showOrderCancelModal(this.getAttribute('data-order_id'))">Hủy đơn
                                                hàng</a>
                                        </div>
                                    @endif
                                    <hr class="line-hr">
                                @endif
                            @endforeach
                        @endif
                    @endif
                </div>
                <div id="shipped-order" class="container tab-pane fade"><br>
                    <h3 class="mb-5">TẤT CẢ ĐƠN HÀNG ĐANG GIAO</h3>
                    @if ($shippedOrders->isEmpty())
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
                            <p>Bạn không có đơn hàng nào!</p>
                        </div>
                    @else
                        @if ($orders->count() > 0)
                            @foreach ($orders as $order)
                                @if ($order->status == 'SHIPPED')
                                    <table>
                                        @foreach ($order->orderDetails as $detail)
                                            <tr>
                                                <td class="d-inline-block mr-3">
                                                    <img src="{{ asset('backend/images/option/' . $detail->productVariant->image) }}"
                                                        width="100" height="100" class="img-fluid img-thumbnail">
                                                </td>
                                                <td>
                                                    <div>
                                                        <h6>{{ \Illuminate\Support\Str::limit($detail->productVariant->product->name, 100) }}
                                                        </h6>
                                                    </div>
                                                    <div>Kích thước: {{ $detail->productVariant->size->name }}</div>
                                                    <div>Màu: {{ $detail->productVariant->color->name }}</div>
                                                    <div>Số lượng: x{{ $detail->quantity }}</div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                    <div class="d-flex justify-content-between mt-3">
                                        <div>
                                            <h6>Trạng thái:
                                                @if ($order->status == 'ORDERED')
                                                    <span>CHỜ XỬ LÝ</span>
                                                @endif
                                                @if ($order->status == 'PROCESSING')
                                                    <span>ĐANG XỬ LÝ</span>
                                                @endif
                                                @if ($order->status == 'SHIPPED')
                                                    <span>ĐANG GIAO HÀNG</span>
                                                @endif
                                                @if ($order->status == 'DELIVERED')
                                                    <span>ĐÃ GIAO HÀNG</span>
                                                @endif
                                                @if ($order->status == 'CANCELLED')
                                                    <span>ĐÃ HỦY</span>
                                                @endif
                                            </h6>
                                        </div>
                                        <h6>Mã đơn hàng: {{ $order->order_code }}</h6>
                                    </div>
                                    @if ($order->status != 'CANCELLED' && $order->status != 'DELIVERED')
                                        <div class="d-flex justify-content-end">
                                            <a type="button" class="btn btn-secondary" href="javascript:void(0)"
                                                data-order_id="{{ $order->order_code }}"
                                                onclick="showOrderCancelModal(this.getAttribute('data-order_id'))">Hủy đơn
                                                hàng</a>
                                        </div>
                                    @endif
                                    <hr class="line-hr">
                                @endif
                            @endforeach
                        @endif
                    @endif
                </div>
                <div id="delivered-order" class="container tab-pane fade"><br>
                    <h3 class="mb-5">TẤT CẢ ĐƠN HÀNG ĐÃ HOÀN THÀNH</h3>
                    @if ($deliveredOrders->isEmpty())
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
                            <p>Bạn không có đơn hàng nào!</p>
                        </div>
                    @else
                        @if ($orders->count() > 0)
                            @foreach ($orders as $order)
                                @if ($order->status == 'DELIVERED')
                                    <table>
                                        @foreach ($order->orderDetails as $detail)
                                            <tr>
                                                <td class="d-inline-block mr-3">
                                                    <img src="{{ asset('backend/images/option/' . $detail->productVariant->image) }}"
                                                        width="100" height="100" class="img-fluid img-thumbnail">
                                                </td>
                                                <td>
                                                    <div>
                                                        <h6>{{ \Illuminate\Support\Str::limit($detail->productVariant->product->name, 100) }}
                                                        </h6>
                                                    </div>
                                                    <div>Kích thước: {{ $detail->productVariant->size->name }}</div>
                                                    <div>Màu: {{ $detail->productVariant->color->name }}</div>
                                                    <div>Số lượng: x{{ $detail->quantity }}</div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                    <div class="d-flex justify-content-between mt-3">
                                        <div>
                                            <h6>Trạng thái:
                                                @if ($order->status == 'ORDERED')
                                                    <span>CHỜ XỬ LÝ</span>
                                                @endif
                                                @if ($order->status == 'PROCESSING')
                                                    <span>ĐANG XỬ LÝ</span>
                                                @endif
                                                @if ($order->status == 'SHIPPED')
                                                    <span>ĐANG GIAO HÀNG</span>
                                                @endif
                                                @if ($order->status == 'DELIVERED')
                                                    <span>ĐÃ GIAO HÀNG</span>
                                                @endif
                                                @if ($order->status == 'CANCELLED')
                                                    <span>ĐÃ HỦY</span>
                                                @endif
                                            </h6>
                                        </div>
                                        <h6>Mã đơn hàng: {{ $order->order_code }}</h6>
                                    </div>
                                    <hr class="line-hr">
                                @endif
                            @endforeach
                        @endif
                    @endif
                </div>
                <div id="cancelled-order" class="container tab-pane fade"><br>
                    <h3 class="mb-5">TẤT CẢ ĐƠN HÀNG ĐÃ HỦY</h3>
                    @if ($cancelledOrders->isEmpty())
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
                            <p>Bạn không có đơn hàng nào!</p>
                        </div>
                    @else
                        @if ($orders->count() > 0)
                            @foreach ($orders as $order)
                                @if ($order->status == 'CANCELLED')
                                    <table>
                                        @foreach ($order->orderDetails as $detail)
                                            <tr>
                                                <td class="d-inline-block mr-3">
                                                    <img src="{{ asset('backend/images/option/' . $detail->productVariant->image) }}"
                                                        width="100" height="100" class="img-fluid img-thumbnail">
                                                </td>
                                                <td>
                                                    <div>
                                                        <h6>{{ \Illuminate\Support\Str::limit($detail->productVariant->product->name, 100) }}
                                                        </h6>
                                                    </div>
                                                    <div>Kích thước: {{ $detail->productVariant->size->name }}</div>
                                                    <div>Màu: {{ $detail->productVariant->color->name }}</div>
                                                    <div>Số lượng: x{{ $detail->quantity }}</div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                    <div class="d-flex justify-content-between mt-3">
                                        <div>
                                            <h6>Trạng thái:
                                                @if ($order->status == 'ORDERED')
                                                    <span>CHỜ XỬ LÝ</span>
                                                @endif
                                                @if ($order->status == 'PROCESSING')
                                                    <span>ĐANG XỬ LÝ</span>
                                                @endif
                                                @if ($order->status == 'SHIPPED')
                                                    <span>ĐANG GIAO HÀNG</span>
                                                @endif
                                                @if ($order->status == 'DELIVERED')
                                                    <span>ĐÃ GIAO HÀNG</span>
                                                @endif
                                                @if ($order->status == 'CANCELLED')
                                                    <span>ĐÃ HỦY</span>
                                                @endif
                                            </h6>
                                        </div>
                                        <h6>Mã đơn hàng: {{ $order->order_code }}</h6>
                                    </div>
                                    <hr class="line-hr">
                                @endif
                            @endforeach
                        @endif
                    @endif
                </div>
            </div>
        </div>

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
                    <input type="hidden" id="order-code">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="cancellation_reason" id="reason1"
                            value="THAY_DOI_DIA_CHI">
                        <label class="form-check-label" for="reason1">
                            Tôi muốn cập nhật địa chỉ/sđt nhận hàng
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="cancellation_reason" id="reason2"
                            value="THAY_DOI_SAN_PHAM">
                        <label class="form-check-label" for="reason2">
                            Tôi muốn thay đổi sản phẩm
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="cancellation_reason" id="reason3"
                            value="VAN_DE_THANH_TOAN">
                        <label class="form-check-label" for="reason3">
                            Thủ tục thanh toán rắc rối
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="cancellation_reason" id="reason4"
                            value="TIM_THAY_LUA_CHON_TOT_HON">
                        <label class="form-check-label" for="reason4">
                            Tôi tìm thấy chỗ mua khác tốt hơn (Rẻ hơn, uy tín hơn, giao nhanh hơn…)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="cancellation_reason" id="reason5"
                            value="KHONG_CO_NHU_CAU">
                        <label class="form-check-label" for="reason5">
                            Tôi không có nhu cầu mua nữa
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="cancellation_reason" id="reason7"
                            value="LY_DO_KHAC">
                        <label class="form-check-label" for="reason7">
                            Tôi không tìm thấy lý do hủy phù hợp
                        </label>
                    </div>
                </form>
                <div class="d-flex mb-0 mt-4">
                    <a type="button" class="btn btn-secondary cancelled" id="cancelOrderButton"
                        href="javascript:void(0)">Xác nhận hủy</a>
                </div>
            </div>
        </div>

    </div>

@endsection
