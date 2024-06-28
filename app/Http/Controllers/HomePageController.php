<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\Post;
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
        $posts = Post::all();
        $products = Product::with('variants')->get();
        $categories = Category::active()->get();
        $manufacturers = Manufacturer::active()->get();
        return view('client.home.home', compact('products', 'banners', 'categories', 'manufacturers', 'posts'));
    }

    public function productDetails($product_id)
    {
        try {
            $categories = Category::active()->get();
            $manufacturers = Manufacturer::active()->get();
            $product = Product::with('variants.size', 'variants.color', 'reviews.customer')->findOrFail($product_id);
            $totalReviews = $product->reviews->count();
            $starCounts = [
                5 => 0,
                4 => 0,
                3 => 0,
                2 => 0,
                1 => 0,
            ];
            foreach ($product->reviews as $review) {
                $starCounts[$review->rating]++;
            }
            $starPercentages = [];
            foreach ($starCounts as $stars => $count) {
                $starPercentages[$stars] = $totalReviews ? ($count / $totalReviews) * 100 : 0;
            }
            $galleries = ProductGallery::where('product_id', $product_id)->get();
            return view('client.home.product-details', compact('product', 'galleries', 'categories', 'manufacturers', 'starCounts', 'starPercentages', 'totalReviews'));
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

    public function getAllManufacturerById($manufacturer_id)
    {
        try {
            $categories = Category::active()->get();
            $manufacturers = Manufacturer::active()->get();
            // Lấy thông tin thương hiệu
            $manufacturer = Manufacturer::findOrFail($manufacturer_id);
            // Lấy tất cả các sản phẩm thuộc thương hiệu
            $products = Product::where('manufacturer_id', $manufacturer->manufacturer_id)->get();
            return view('client.home.manufacturer', compact('products', 'categories', 'manufacturers', 'manufacturer'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('client.home.home')->with('error', 'Thương hiệu này không tồn tại!');
        }
    }

    public function getAllCategoryById($category_id)
    {
        try {
            $categories = Category::active()->get();
            $manufacturers = Manufacturer::active()->get();
            // Lấy thông tin danh mục
            $category = Category::findOrFail($category_id);
            /// Lấy tất cả các sản phẩm thuộc danh mục
            $products = $category->product;
            return view('client.home.category', compact('products', 'categories', 'manufacturers', 'category'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('client.home.home')->with('error', 'Danh mục này không tồn tại!');
        }
    }

    public function search(Request $request)
    {
        $categories = Category::active()->get();
        $manufacturers = Manufacturer::active()->get();
        $query = $request->input('query');

        // Search products
        $products = Product::whereRaw('name LIKE ?', ["%{$query}%"])->get();

        return view('client.home.search', compact('categories', 'manufacturers', 'products', 'query'));
    }
}
