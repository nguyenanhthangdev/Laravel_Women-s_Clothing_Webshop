<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function category()
    {
        $categories = Category::all();
        return view('admin.category.category', compact('categories'));
    }

    public function addCategory()
    {
        return view('admin.category.add-category');
    }

    public function saveCategory(Request $request)
    {
        try {
            // Tạo một bản ghi mới trong cơ sở dữ liệu
            $category = new Category();
            $category->name = $request->name;
            $category->featured = $request->featured === 'true' ? true : false;
            $category->status = $request->status === 'true' ? true : false;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('backend/images/category'), $imageName);
                $category->image = $imageName;
            }

            $category->save();

            return redirect()->intended('/admin/category')->with('success', 'Thêm mới danh mục thành công!');
        } catch (Exception $e) {
            // Xử lý ngoại lệ
            return back()->with('error', 'Đã xảy ra lỗi khi thêm danh mục.');
        }
    }

    public function editCategory($category_id)
    {
        try {
            $category = Category::findOrFail($category_id);
            return view('admin.category.edit-category', compact('category'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.category')->with('error', 'Danh mục này không tồn tại!');
        }
    }

    public function updateCategory(Request $request)
    {
        try {
            // Find the user by ID
            $category = Category::findOrFail($request->category_id);
            $imageName = '';
            // Handle image upload if present
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($category->image) {
                    $oldImagePath = public_path('/backend/images/category') . '/' . $category->image;
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('backend/images/category'), $imageName); // Di chuyển ảnh vào thư mục public/backend/images
            }

            $category->name = $request->name;
            $category->featured = $request->featured === 'true' ? true : false;
            $category->status = $request->status === 'true' ? true : false;

            $category->fill([
                'name' => $request->name,
                'featured' => $request->featured === 'true' ? true : false,
                'status' => $request->status === 'true' ? true : false,
                'image' => $imageName !== '' ? $imageName : $category->image,
            ]);

            $category->save();

            // Redirect back with success message
            return redirect()->route('admin.category')->with('success', 'Chỉnh sửa thông tin danh mục thành công.');
        } catch (ModelNotFoundException $e) {
            // Handle case where user_id does not exist
            return redirect()->route('admin.category')->with('error', 'Danh mục này không tồn tại!');
        } catch (\Exception $e) {
            // Handle other exceptions
            return redirect()->back()->with('error', 'Đã có lỗi xảy ra khi thay đổi thông tin danh mục.');
        }
    }

    public function deleteCategory($category_id)
    {
        try {
            $category = Category::findOrFail($category_id);

            // Xóa hình ảnh nếu tồn tại
            if ($category->image) {
                $imagePath = public_path('backend/images/category') . '/' . $category->image;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $category->delete();

            return redirect()->back()->with('success', 'Đã xóa danh mục thành công.');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Danh mục này không tồn tại.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Đã có lỗi xảy ra khi xóa danh mục.');
        }
    }
}
