<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    // --- CLIENT: START ---
    public function myOrder(Request $request)
    {
        $customer = $request->session()->get('customer');
        $customerId = $customer->customer_id;
        $orders = Order::with('orderDetails.productVariant.product')
            ->where('customer_id', $customerId)
            ->get();

        $orderedOrders = $orders->where('status', 'ORDERED');
        $processingOrders = $orders->where('status', 'PROCESSING');
        $shippedOrders = $orders->where('status', 'SHIPPED');
        $deliveredOrders = $orders->where('status', 'DELIVERED');
        $cancelledOrders = $orders->where('status', 'CANCELLED');
        $categories = Category::active()->get();
        $manufacturers = Manufacturer::active()->get();
        return view('client.order.order', compact('categories', 'manufacturers', 'orders', 'orderedOrders', 'processingOrders', 'shippedOrders', 'deliveredOrders', 'cancelledOrders'));
    }

    public function cancelOrder(Request $request)
    {
        try {
            $orderCode = $request->input('order_code');
            $cancellationReason = $request->input('cancellation_reason');
            // Tìm đơn hàng với mã đơn hàng
            $order = Order::where('order_code', $orderCode)->firstOrFail();

            // Cập nhật trạng thái đơn hàng thành CANCELLED
            $order->status = 'CANCELLED';
            $order->cancellation_reason = $cancellationReason;
            $order->save();

            return response()->json(['success' => true, 'message' => 'Đơn hàng đã được hủy thành công']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Mã đơn hàng không tồn tại']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Đã xảy ra lỗi. Vui lòng thử lại sau']);
        }
    }
    // --- CLIENT: END ---

    // --- ADMIN: START ---
    public function order()
    {
        $orders = Order::all();
        return view('admin.order.order', compact('orders'));
    }

    public function orderDetails($order_code)
    {
        try {
            // Tìm đơn hàng với mã đơn hàng
            $order = Order::with('shipping')->where('order_code', $order_code)->firstOrFail();

            // Lấy chi tiết đơn hàng dựa trên order_id
            $orderDetails = OrderDetail::where('order_id', $order->order_id)->get();

            // Trả dữ liệu về view
            return view('admin.order.order-details', compact('order', 'orderDetails'));
        } catch (ModelNotFoundException $e) {
            // Chuyển hướng về trang danh sách đơn hàng với thông báo lỗi
            return redirect()->route('admin.order')->with('error', 'Đơn hàng không tồn tại!');
        } catch (\Exception $e) {
            // Xử lý các lỗi khác
            return redirect()->route('admin.order')->with('error', 'Đã xảy ra lỗi trong quá trình truy xuất đơn hàng!');
        }
    }

    public function orderCancel(Request $request)
    {
        try {
            $orderCode = $request->input('order_code');
            $cancellationReason = $request->input('cancellation_reason');
            // Tìm đơn hàng với mã đơn hàng
            $order = Order::where('order_code', $orderCode)->firstOrFail();

            // Cập nhật trạng thái đơn hàng thành CANCELLED
            $order->status = 'CANCELLED';
            $order->cancellation_reason = $cancellationReason;
            $order->save();

            return response()->json(['success' => true, 'message' => 'Đơn hàng đã được hủy thành công']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Mã đơn hàng không tồn tại']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Đã xảy ra lỗi. Vui lòng thử lại sau']);
        }
    }

    public function changeOrderProcess(Request $request)
    {
        try {
            $orderCode = $request->input('order_code');
            // Tìm đơn hàng với mã đơn hàng
            $order = Order::where('order_code', $orderCode)->firstOrFail();

            // Cập nhật trạng thái đơn hàng
            $order->status = 'PROCESSING';
            $order->save();

            return response()->json(['success' => true, 'message' => 'Đơn hàng đã được chuyển sang trạng thái xử lý']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Mã đơn hàng không tồn tại']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Đã xảy ra lỗi. Vui lòng thử lại sau']);
        }
    }

    public function changeOrderShipped(Request $request)
    {
        try {
            $orderCode = $request->input('order_code');
            // Tìm đơn hàng với mã đơn hàng
            $order = Order::where('order_code', $orderCode)->firstOrFail();

            // Cập nhật trạng thái đơn hàng
            $order->status = 'SHIPPED';
            $order->save();

            return response()->json(['success' => true, 'message' => 'Đơn hàng đã được chuyển sang trạng thái giao hàng']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Mã đơn hàng không tồn tại']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Đã xảy ra lỗi. Vui lòng thử lại sau']);
        }
    }

    public function changeOrderDelivered(Request $request)
    {
        try {
            $orderCode = $request->input('order_code');
            // Tìm đơn hàng với mã đơn hàng
            $order = Order::where('order_code', $orderCode)->firstOrFail();

            // Cập nhật trạng thái đơn hàng
            $order->status = 'DELIVERED';
            $order->save();

            return response()->json(['success' => true, 'message' => 'Đơn hàng đã được chuyển sang trạng thái thành công']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Mã đơn hàng không tồn tại']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Đã xảy ra lỗi. Vui lòng thử lại sau']);
        }
    }
    // --- ADMIN: END ---
}
