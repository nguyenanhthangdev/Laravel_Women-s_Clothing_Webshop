<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\Colors;
use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Models\ProductVariants;
use App\Models\Sizes;
use DateTime;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function product()
    {
        $products = Product::all();
        return view('admin.product.product', compact('products'));
    }

    public function addProduct()
    {
        $manufacturers = Manufacturer::all();
        $categories = Category::all();
        $sizes = Sizes::all();
        $colors = Colors::all();
        return view('admin.product.add-product', compact('manufacturers', 'categories', 'sizes', 'colors'));
    }

    public function saveProduct(Request $request)
    {
        try {
            // Tạo một sản phẩm mới
            $product = new Product();
            $product->name = $request->name;
            $product->description = $request->description;
            $product->discount = $request->discount;
            $product->new = $request->has('new');
            $product->best_seller = $request->has('best-seller');
            $product->featured = $request->has('featured');
            $product->status = $request->status == 'true';
            $product->manufacturer_id = $request->manufacturer_id;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('backend/images/product'), $imageName);
                $product->image = $imageName;
            }

            $product->save();
            $savedProduct = Product::find($product->product_id);

            if ($savedProduct != null) {
                if ($request->has('categories')) {
                    $product->category()->sync($request->categories);
                }
                if ($request->hasFile('gallery')) {
                    foreach ($request->file('gallery') as $file) {
                        $galleryImageName = rand(1000000000, 9999999999) . '-' . $file->getClientOriginalName();
                        $file->move(public_path('backend/images/gallery'), $galleryImageName);

                        $gallery = new ProductGallery();
                        $gallery->product_id = $savedProduct->product_id;
                        $gallery->gallery_path = $galleryImageName;
                        $gallery->save();
                    }
                }
                if ($request->hasFile('optionImage')) {
                    $optionImages = $request->file('optionImage');
                    $optionColors = $request->optionColor;
                    $optionSizes = $request->optionSize;
                    $optionPrices = $request->optionPrice;
                    $optionQuantitys = $request->optionQuantity;
                    for ($i = 0; $i < count($optionImages); $i++) {
                        $optionImageName = rand(1000000000, 9999999999) . '-' . $optionImages[$i]->getClientOriginalName();
                        $optionImages[$i]->move(public_path('backend/images/option'), $optionImageName);

                        $productVariant = new ProductVariants();
                        $productVariant->product_id = $savedProduct->product_id;
                        $productVariant->size_id = $optionSizes[$i];
                        $productVariant->color_id = $optionColors[$i];
                        $productVariant->image = $optionImageName;
                        $productVariant->price = $optionPrices[$i];
                        $productVariant->quantity = $optionQuantitys[$i];
                        $productVariant->save();
                    }
                }
            }
            return redirect()->intended('/admin/product')->with('success', 'Thêm mới sản phẩm thành công!');
        } catch (Exception $e) {
            // Xử lý ngoại lệ
            return back()->with('error', 'Đã xảy ra lỗi khi thêm sản phẩm.');
        }
    }

    public function editProduct($product_id)
    {
        try {
            $manufacturers = Manufacturer::all();
            $categories = Category::all();
            $sizes = Sizes::all();
            $colors = Colors::all();
            $product = Product::findOrFail($product_id);
            $categoriesProduct = CategoryProduct::where('product_id', $product_id)->get();
            $variants = ProductVariants::where('product_id', $product_id)->get();
            $galleries = ProductGallery::where('product_id', $product_id)->get();
            return view('admin.product.edit-product', compact('manufacturers', 'categories', 'sizes', 'colors', 'product', 'variants', 'galleries', 'categoriesProduct'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.product')->with('error', 'Sản phẩm này không tồn tại!');
        }
    }

    public function updateProduct(Request $request)
    {
        try {
            $product = Product::findOrFail($request->product_id);
            if ($product != null) {
                $imageName = '';
                // Handle image upload if present
                if ($request->hasFile('image')) {
                    // Delete old image if exists
                    if ($product->image) {
                        $oldImagePath = public_path('/backend/images/product') . '/' . $product->image;
                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }
                    $image = $request->file('image');
                    $imageName = rand(1000000000, 9999999999) . '-' . $image->getClientOriginalName();
                    $image->move(public_path('backend/images/product'), $imageName);
                }

                $product->fill([
                    'name' => $request->name,
                    'description' => $request->description,
                    'discount' => $request->discount,
                    'new' => $request->new === 'true' ? true : false,
                    'best_seller' => $request->new === 'true' ? true : false,
                    'featured' => $request->new === 'true' ? true : false,
                    'status' => $request->status === 'true' ? true : false,
                    'manufacturer_id' => $request->manufacturer_id,
                    'image' => $imageName !== '' ? $imageName : $product->image,
                ]);

                $product->save();
                $savedProduct = Product::find($product->product_id);

                if ($savedProduct != null) {
                    $variants = ProductVariants::where('product_id', $savedProduct->product_id)->get();
                    $galleries = ProductGallery::where('product_id', $savedProduct->product_id)->get();

                    CategoryProduct::where('product_id', $savedProduct->product_id)->delete();

                    if ($request->has('categories')) {
                        $product->category()->sync($request->categories);
                    }
                    if ($galleries->isNotEmpty()) {
                        $galleriesOld = $request->input('galleriesOld');
                        if (!empty($galleriesOld) && is_array($galleriesOld)) {
                            foreach ($galleries as $gallery) {
                                if (!in_array($gallery->gallery_path, $galleriesOld)) {
                                    ProductGallery::where('gallery_path', $gallery->gallery_path)
                                        ->where('product_id', $request->product_id)
                                        ->delete();
                                    $galleryImagePath = public_path('backend/images/gallery/' . $gallery->gallery_path);
                                    if (file_exists($galleryImagePath)) {
                                        unlink($galleryImagePath);
                                    }
                                }
                            }
                        } else {
                            ProductGallery::where('product_id', $savedProduct->product_id)->delete();
                            foreach ($galleries as $gallery) {
                                $galleryImagePath = public_path('backend/images/gallery/' . $gallery->gallery_path);
                                if (file_exists($galleryImagePath)) {
                                    unlink($galleryImagePath);
                                }
                            }
                        }
                    }
                    if ($request->hasFile('gallery')) {
                        foreach ($request->file('gallery') as $file) {
                            $galleryImageName = rand(1000000000, 9999999999) . '-' . $file->getClientOriginalName();
                            $file->move(public_path('backend/images/gallery'), $galleryImageName);

                            $gallery = new ProductGallery();
                            $gallery->product_id = $savedProduct->product_id;
                            $gallery->gallery_path = $galleryImageName;
                            $gallery->save();
                        }
                    }
                    if ($variants->isNotEmpty()) {
                        $optionIdOld = $request->input('optionIdOld');
                        if (!empty($optionIdOld) && is_array($optionIdOld)) {
                            foreach ($variants as $variant) {
                                if (!in_array($variant->product_variant_id, $optionIdOld)) {
                                    ProductVariants::where('product_variant_id', $variant->product_variant_id)
                                        ->where('product_id', $request->product_id)
                                        ->delete();
                                    $optionImagePath = public_path('backend/images/option/' . $variant->image);
                                    if (file_exists($optionImagePath)) {
                                        unlink($optionImagePath);
                                    }
                                }
                            }
                        } else {
                            ProductVariants::where('product_id', $savedProduct->product_id)->delete();
                            foreach ($variants as $variant) {
                                $optionImagePath = public_path('backend/images/option/' . $variant->image);
                                if (file_exists($optionImagePath)) {
                                    unlink($optionImagePath);
                                }
                            }
                        }
                    }
                    if ($request->hasFile('optionImage')) {
                        $optionImages = $request->file('optionImage');
                        $optionColors = $request->optionColor;
                        $optionSizes = $request->optionSize;
                        $optionPrices = $request->optionPrice;
                        $optionQuantitys = $request->optionQuantity;
                        for ($i = 0; $i < count($optionImages); $i++) {
                            $optionImageName = rand(1000000000, 9999999999) . '-' . $optionImages[$i]->getClientOriginalName();
                            $optionImages[$i]->move(public_path('backend/images/option'), $optionImageName);

                            $productVariant = new ProductVariants();
                            $productVariant->product_id = $savedProduct->product_id;
                            $productVariant->size_id = $optionSizes[$i];
                            $productVariant->color_id = $optionColors[$i];
                            $productVariant->image = $optionImageName;
                            $productVariant->price = $optionPrices[$i];
                            $productVariant->quantity = $optionQuantitys[$i];
                            $productVariant->save();
                        }
                    }
                }
            }
            return redirect()->intended('/admin/product')->with('success', 'Chỉnh sửa sản phẩm thành công!');
        } catch (Exception $e) {
            // Xử lý ngoại lệ
            return back()->with('error', 'Đã xảy ra lỗi khi chỉnh sửa sản phẩm.');
        }
    }

    public function deleteProduct($product_id)
    {
        try {
            $product = Product::findOrFail($product_id);

            if ($product != null) {
                $variants = ProductVariants::where('product_id', $product->product_id)->get();
                $galleries = ProductGallery::where('product_id', $product->product_id)->get();

                CategoryProduct::where('product_id', $product->product_id)->delete();
                ProductGallery::where('product_id', $product->product_id)->delete();
                ProductVariants::where('product_id', $product->product_id)->delete();

                if ($product->image) {
                    $imagePath = public_path('backend/images/product') . '/' . $product->image;
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }

                if ($galleries->isNotEmpty()) {
                    foreach ($galleries as $gallery) {
                        $galleryImagePath = public_path('backend/images/gallery/' . $gallery->gallery_path);
                        if (file_exists($galleryImagePath)) {
                            unlink($galleryImagePath);
                        }
                    }
                }

                if ($variants->isNotEmpty()) {
                    foreach ($variants as $variant) {
                        $optionImagePath = public_path('backend/images/option/' . $variant->image);
                        if (file_exists($optionImagePath)) {
                            unlink($optionImagePath);
                        }
                    }
                }

                $product->delete();
            }
            return redirect()->back()->with('success', 'Đã xóa sản phẩm thành công.');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Sản phẩm này không tồn tại.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Đã có lỗi xảy ra khi xóa sản phẩm.');
        }
    }
}
