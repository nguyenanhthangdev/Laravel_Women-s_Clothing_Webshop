<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function banner()
    {
        $banners = Banner::all();
        return view('admin.banner.banner', compact('banners'));
    }

    public function addbanner()
    {
        return view('admin.banner.add-banner');
    }

    public function savebanner(Request $request)
    {
        try {
            // Tạo một bản ghi mới trong cơ sở dữ liệu
            $banner = new banner();
            $banner->link = $request->link;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('backend/images/banner'), $imageName);
                $banner->image = $imageName;
            }

            $banner->save();

            return redirect()->intended('/admin/banner')->with('success', 'Thêm mới ảnh banner thành công!');
        } catch (Exception $e) {
            // Xử lý ngoại lệ
            return back()->with('error', 'Đã xảy ra lỗi khi thêm ảnh banner.');
        }
    }

    public function deleteBanner($banner_id)
    {
        try {
            $banner = Banner::findOrFail($banner_id);

            // Xóa hình ảnh nếu tồn tại
            if ($banner->image) {
                $imagePath = public_path('backend/images/banner') . '/' . $banner->image;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $banner->delete();

            return redirect()->back()->with('success', 'Đã xóa ảnh banner thành công.');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Ảnh banner này không tồn tại.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Đã có lỗi xảy ra khi xóa ảnh banner.');
        }
    }
}
