<?php

namespace App\Http\Controllers;

use App\Models\Sizes;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function size()
    {
        $sizes = Sizes::all();
        return view('admin.sizes.sizes', compact('sizes'));
    }

    public function addSize()
    {
        return view('admin.sizes.add-size');
    }

    public function saveSize(Request $request)
    {
        try {
            // Tạo một bản ghi mới trong cơ sở dữ liệu
            $size = new Sizes();
            $size->name = $request->name;
            $size->save();

            return redirect()->intended('/admin/size')->with('success', 'Thêm mới kích thước sản phẩm thành công!');
        } catch (Exception $e) {
            // Xử lý ngoại lệ
            return back()->with('error', 'Đã xảy ra lỗi khi thêm kích thước sản phẩm.');
        }
    }

    public function editSize($size_id)
    {
        try {
            $size = Sizes::findOrFail($size_id);
            return view('admin.sizes.edit-size', compact('size'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.size')->with('error', 'Kích thước này không tồn tại!');
        }
    }

    public function updateSize(Request $request)
    {
        try {
            // Find the user by ID
            $size = Sizes::findOrFail($request->size_id);
            $size->name = $request->name;

            $size->fill([
                'name' => $request->name,
            ]);

            $size->save();

            // Redirect back with success message
            return redirect()->route('admin.size')->with('success', 'Chỉnh sửa thông tin kích thước sản phẩm thành công.');
        } catch (ModelNotFoundException $e) {
            // Handle case where user_id does not exist
            return redirect()->route('admin.size')->with('error', 'Kích thước này không tồn tại!');
        } catch (\Exception $e) {
            // Handle other exceptions
            return redirect()->back()->with('error', 'Đã có lỗi xảy ra khi thay đổi thông tin kích thước.');
        }
    }

    public function deleteSize($size_id)
    {
        try {
            $size = Sizes::findOrFail($size_id);
            $size->delete();

            return redirect()->back()->with('success', 'Đã xóa kích thước sản phẩm thành công.');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Kích thước này không tồn tại.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Đã có lỗi xảy ra khi xóa kích thước sản phẩm.');
        }
    }
}
