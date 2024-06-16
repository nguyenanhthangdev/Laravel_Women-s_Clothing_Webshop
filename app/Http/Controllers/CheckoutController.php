<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\City;
use App\Models\Manufacturer;
use App\Models\Shipping;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

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
}