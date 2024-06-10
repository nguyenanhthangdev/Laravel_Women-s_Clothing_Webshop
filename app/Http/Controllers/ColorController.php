<?php

namespace App\Http\Controllers;

use App\Models\Colors;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function color()
    {
        $colors = Colors::all();
        return view('admin.colors.colors', compact('colors'));
    }

    public function addColor()
    {
        return view('admin.colors.add-color');
    }

    public function saveColor(Request $request)
    {
        try {
            // Tạo một bản ghi mới trong cơ sở dữ liệu
            $color = new Colors();
            $color->name = $request->name;
            $color->save();

            return redirect()->intended('/admin/color')->with('success', 'Thêm mới màu sản phẩm thành công!');
        } catch (Exception $e) {
            // Xử lý ngoại lệ
            return back()->with('error', 'Đã xảy ra lỗi khi thêm màu sản phẩm.');
        }
    }

    public function editColor($color_id)
    {
        try {
            $color = Colors::findOrFail($color_id);
            return view('admin.colors.edit-color', compact('color'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.color')->with('error', 'Màu này không tồn tại!');
        }
    }

    public function updateColor(Request $request)
    {
        try {
            // Find the user by ID
            $color = Colors::findOrFail($request->color_id);
            $color->name = $request->name;

            $color->fill([
                'name' => $request->name,
            ]);

            $color->save();

            // Redirect back with success message
            return redirect()->route('admin.color')->with('success', 'Chỉnh sửa thông tin màu sản phẩm thành công.');
        } catch (ModelNotFoundException $e) {
            // Handle case where user_id does not exist
            return redirect()->route('admin.color')->with('error', 'Màu này không tồn tại!');
        } catch (\Exception $e) {
            // Handle other exceptions
            return redirect()->back()->with('error', 'Đã có lỗi xảy ra khi thay đổi thông tin màu.');
        }
    }

    public function deleteColor($color_id)
    {
        try {
            $color = Colors::findOrFail($color_id);
            $color->delete();

            return redirect()->back()->with('success', 'Đã xóa màu sản phẩm thành công.');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Màu này không tồn tại.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Đã có lỗi xảy ra khi xóa màu sản phẩm.');
        }
    }
}
