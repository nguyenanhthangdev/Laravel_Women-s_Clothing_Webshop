<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\City;
use App\Models\Manufacturer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Shipping;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $customer = $request->session()->get('customer');
        $customerId = $customer->customer_id;
        $shipping = Shipping::where('customer_id', $customerId)
            ->where('status', true)
            ->first();
        $cart = Session::get('cart', []);
        $cities = City::all();
        $categories = Category::active()->get();
        $manufacturers = Manufacturer::active()->get();
        $totalPrice = 0;
        foreach ($cart as $item) {
            $priceAfterDiscount = $item['price_variant'] - ($item['price_variant'] * $item['discount'] / 100);
            $totalPrice += $priceAfterDiscount * $item['quantity'];
        }
        return view('client.checkout.checkout', compact('cart', 'categories', 'manufacturers', 'totalPrice', 'shipping', 'cities'));
    }

    public function saveOrder(Request $request)
    {
        try {
            // Bắt đầu transaction
            DB::beginTransaction();

            $customer = $request->session()->get('customer');
            $customerId = $customer->customer_id;
            $shipping = Shipping::where('customer_id', $customerId)
                ->where('status', true)
                ->first();

            $cart = Session::get('cart', []);
            $totalPrice = 0;
            $totalDiscount = 0;

            foreach ($cart as $item) {
                $itemTotalPrice = $item['price_variant'] * $item['quantity'];
                $itemTotalDiscount = ($item['price_variant'] * $item['discount'] / 100) * $item['quantity'];

                $totalPrice += $itemTotalPrice;
                $totalDiscount += $itemTotalDiscount;
            }
            $final_price = $totalPrice - $totalDiscount;


            // Tạo mã đơn hàng gồm 12 ký tự ngẫu nhiên (chữ hoa và chữ số)
            $orderCode = strtoupper(Str::random(12));

            $order = new Order();
            $order->order_code = $orderCode;
            $order->customer_id = $customerId;
            $order->shipping_id = $shipping->shipping_id;
            $order->total_amount = $final_price;
            $order->status = "ORDERED";
            $order->payment_method = "THANH_TOAN_KHI_NHAN_HANG";
            $order->save();

            // Lưu chi tiết đơn hàng vào bảng order_detail
            foreach ($cart as $item) {
                $orderDetail = new OrderDetail();
                $orderDetail->order_id = $order->order_id;
                $orderDetail->product_variant_id = $item['variantId'];
                $orderDetail->unit_price = $item['price_variant'];
                $orderDetail->total_price = $item['price_variant'] * $item['quantity'];
                $orderDetail->quantity = $item['quantity'];
                $orderDetail->save();
            }
            
            $request->session()->forget('cart');

            // Commit transaction
            DB::commit();

            return response()->json(['message' => 'Đặt hàng thành công', 200]);
        } catch (\Exception $e) {
            // Rollback transaction nếu có lỗi xảy ra
            DB::rollBack();
            // Xử lý lỗi nếu có
            return response()->json(['message' => 'Đã xảy ra lỗi khi lưu đơn hàng: ' . $e->getMessage()], 500);
        }
    }
}
