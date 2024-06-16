<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\ProductVariants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $productId = $request->input('product_id');
        $colorId = $request->input('color_id');
        $colorName = $request->input('color_name');
        $sizeId = $request->input('size_id');
        $sizeName = $request->input('size_name');
        $quantity = $request->input('quantity');
        $imageVariant = $request->input('image_variant');
        $priceVariant = $request->input('price_variant');
        $discount = $request->input('discount');
        $variantId = $request->input('variant_id');
        $productName = $request->input('product_name');

        // Bạn có thể thêm logic để tìm sản phẩm, kiểm tra tính hợp lệ, v.v...
        // Ở đây chúng ta chỉ lưu thông tin vào session giỏ hàng
        $cart = Session::get('cart', []);

        $found = false;

        // Kiểm tra xem variantId có tồn tại trong giỏ hàng hay không
        foreach ($cart as &$item) {
            if ($item['variantId'] == $variantId) {
                // Nếu tồn tại, tăng quantity lên
                $item['quantity'] += $quantity;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $cart[] = [
                'product_id' => $productId,
                'color_id' => $colorId,
                'color_name' => $colorName,
                'size_id' => $sizeId,
                'size_name' => $sizeName,
                'quantity' => $quantity,
                'image_variant' => $imageVariant,
                'price_variant' => $priceVariant,
                'discount' => $discount,
                'variantId' => $variantId,
                'product_name' => $productName,
            ];
        }

        Session::put('cart', $cart);

        return response()->json(['success' => true, 'message' => 'Product added to cart!']);
    }

    public function viewCart()
    {
        $cart = Session::get('cart', []);
        $categories = Category::active()->get();
        $manufacturers = Manufacturer::active()->get();
        $totalPrice = 0;
        foreach ($cart as $item) {
            $priceAfterDiscount = $item['price_variant'] - ($item['price_variant'] * $item['discount'] / 100);
            $totalPrice += $priceAfterDiscount * $item['quantity'];
        }
        return view('client.cart.cart', compact('cart', 'categories', 'manufacturers', 'totalPrice'));
    }

    public function getCartCount()
    {
        $cart = Session::get('cart', []);
        return response()->json(['cartCount' => count($cart)]);
    }

    public function removeFromCart(Request $request)
    {
        $variantId = $request->input('variant_id');

        $cart = Session::get('cart', []);

        foreach ($cart as $key => $item) {
            if ($item['variantId'] == $variantId) {
                unset($cart[$key]);
                break;
            }
        }

        Session::put('cart', $cart);

        return response()->json(['success' => true, 'message' => 'Đã xóa sản phẩm khỏi giỏ hàng!', 'cartCount' => count($cart)]);
    }

    public function updateCart(Request $request)
    {
        $variantIdToUpdate = $request->input('variant_id');
        $newQuantity = $request->input('quantity');

        $cart = Session::get('cart', []);

        foreach ($cart as &$item) {
            if ($item['variantId'] === $variantIdToUpdate) {
                $item['quantity'] = $newQuantity;
                break;
            }
        }

        // Lưu giỏ hàng mới vào session
        Session::put('cart', $cart);

        return response()->json(['success' => true]);
    }
}
