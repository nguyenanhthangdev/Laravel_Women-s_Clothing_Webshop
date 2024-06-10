<?php

namespace App\Http\Controllers;

use App\Models\Manufacturer;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ManufacturerController extends Controller
{
    public function manufacturer()
    {
        $manufacturers = Manufacturer::all();
        return view('admin.manufacturer.manufacturer', compact('manufacturers'));
    }

    public function addManufacturer()
    {
        return view('admin.manufacturer.add-manufacturer');
    }

    public function saveManufacturer(Request $request)
    {
        try {
            // Tạo một bản ghi mới trong cơ sở dữ liệu
            $manufacturer = new Manufacturer();
            $manufacturer->name = $request->name;
            $manufacturer->featured = $request->featured === 'true' ? true : false;
            $manufacturer->status = $request->status === 'true' ? true : false;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('backend/images/manufacturer'), $imageName);
                $manufacturer->image = $imageName;
            }

            $manufacturer->save();

            return redirect()->intended('/admin/manufacturer')->with('success', 'Thêm mới thương hiệu thành công!');
        } catch (Exception $e) {
            // Xử lý ngoại lệ
            return back()->with('error', 'Đã xảy ra lỗi khi thêm thương hiệu.');
        }
    }

    public function editManufacturer($manufacturer_id)
    {
        try {
            $manufacturer = Manufacturer::findOrFail($manufacturer_id);
            return view('admin.manufacturer.edit-manufacturer', compact('manufacturer'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.manufacturer')->with('error', 'Thương hiệu này không tồn tại!');
        }
    }

    public function updateManufacturer(Request $request)
    {
        try {
            // Find the user by ID
            $manufacturer = Manufacturer::findOrFail($request->manufacturer_id);
            $imageName = '';
            // Handle image upload if present
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($manufacturer->image) {
                    $oldImagePath = public_path('/backend/images/manufacturer') . '/' . $manufacturer->image;
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('backend/images/manufacturer'), $imageName); // Di chuyển ảnh vào thư mục public/backend/images
            }

            $manufacturer->fill([
                'name' => $request->name,
                'featured' => $request->featured === 'true' ? true : false,
                'status' => $request->status === 'true' ? true : false,
                'image' => $imageName !== '' ? $imageName : $manufacturer->image,
            ]);

            $manufacturer->save();

            // Redirect back with success message
            return redirect()->route('admin.manufacturer')->with('success', 'Chỉnh sửa thông tin thương hiệu thành công.');
        } catch (ModelNotFoundException $e) {
            // Handle case where user_id does not exist
            return redirect()->route('admin.manufacturer')->with('error', 'Thương hiệu này không tồn tại!');
        } catch (\Exception $e) {
            // Handle other exceptions
            return redirect()->back()->with('error', 'Đã có lỗi xảy ra khi thay đổi thông tin thương hiệu.');
        }
    }

    public function deleteManufacturer($manufacturer_id)
    {
        try {
            $manufacturer = Manufacturer::findOrFail($manufacturer_id);

            // Xóa hình ảnh nếu tồn tại
            if ($manufacturer->image) {
                $imagePath = public_path('backend/images/manufacturer') . '/' . $manufacturer->image;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $manufacturer->delete();

            return redirect()->back()->with('success', 'Đã xóa thương hiệu thành công.');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Thương hiệu này không tồn tại.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Đã có lỗi xảy ra khi xóa thương hiệu.');
        }
    }
}
