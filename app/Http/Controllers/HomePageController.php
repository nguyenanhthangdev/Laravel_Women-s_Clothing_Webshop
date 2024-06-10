<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Models\ProductVariants;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HomePageController extends Controller
{
    public function home()
    {
        $banners = Banner::all();
        $products = Product::with('variants')->get();
        $categories = Category::active()->get();
        $manufacturers = Manufacturer::active()->get();
        return view('client.home.home', compact('products', 'banners', 'categories', 'manufacturers'));
    }

    public function productDetails($product_id)
    {
        try {
            $categories = Category::active()->get();
            $manufacturers = Manufacturer::active()->get();
            $product = Product::with('variants.size', 'variants.color')->findOrFail($product_id);
            $galleries = ProductGallery::where('product_id', $product_id)->get();
            return view('client.home.product-details', compact('product', 'galleries', 'categories', 'manufacturers'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('client.home.home')->with('error', 'Sản phẩm này không tồn tại!');
        }
    }

    public function getProductByVariant(Request $request)
    {
        try {
            $colorId = $request->color_id;
            $sizeId = $request->size_id;
            $productId = $request->product_id;

            // Truy vấn để lấy sản phẩm tương ứng với color_id và size_id
            $variant = DB::table('product_variants')
                ->where('size_id', '=', $sizeId)
                ->where('color_id', '=', $colorId)
                ->where('product_id', '=', $productId)
                ->get();

            // Trả về kết quả dưới dạng JSON
            return response()->json($variant);
        } catch (Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function getVariantsByColorId(Request $request)
    {
        try {
            $colorId = $request->color_id;
            $productId = $request->product_id;

            // Truy vấn để lấy sản phẩm tương ứng với color_id
            $variant = DB::table('product_variants')
                ->where('color_id', '=', $colorId)
                ->where('product_id', '=', $productId)
                ->get();

            // Trả về kết quả dưới dạng JSON
            return response()->json($variant);
        } catch (Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function getVariantsBySizeId(Request $request)
    {
        try {
            $sizeId = $request->size_id;
            $productId = $request->product_id;

            // Truy vấn để lấy sản phẩm tương ứng với color_id
            $variant = DB::table('product_variants')
                ->where('size_id', '=', $sizeId)
                ->where('product_id', '=', $productId)
                ->get();

            // Trả về kết quả dưới dạng JSON
            return response()->json($variant);
        } catch (Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
