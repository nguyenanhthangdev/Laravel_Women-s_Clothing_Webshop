<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function user()
    {
        $users = User::all();
        return view('admin.user.user', compact('users'));
    }

    public function addUser()
    {
        return view('admin.user.add-user');
    }

    public function saveUser(Request $request)
    {
        try {
            // Tạo một bản ghi mới trong cơ sở dữ liệu
            $user = new User();
            $user->fullname = $request->fullname;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->username = $request->username;
            $user->password = bcrypt($request->password);
            $user->status = $request->status === 'true' ? true : false;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('backend/images/user'), $imageName); // Di chuyển ảnh vào thư mục public/backend/images
                $user->image = $imageName;
            }

            $user->save();

            return redirect()->intended('/admin/user')->with('success', 'Thêm mới nhân viên thành công!');
        } catch (Exception $e) {
            // Xử lý ngoại lệ
            return back()->with('error', 'Đã xảy ra lỗi khi thêm nhân viên.');
        }
    }

    public function checkUsername(Request $request)
    {
        // Lấy tên đăng nhập từ request
        $username = $request->input('username');

        // Kiểm tra xem tên đăng nhập đã tồn tại trong cơ sở dữ liệu hay chưa
        $user = User::where('username', $username)->first();

        // Trả về kết quả
        if ($user) {
            // Nếu tên đăng nhập đã tồn tại, trả về true
            return response()->json(['exists' => true]);
        } else {
            // Nếu tên đăng nhập chưa tồn tại, trả về false
            return response()->json(['exists' => false]);
        }
    }

    public function editUser($user_id)
    {
        try {
            $user = User::findOrFail($user_id);
            return view('admin.user.edit-user', compact('user'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.user')->with('error', 'Nhân viên này không tồn tại!');
        }
    }

    public function updateUser(Request $request)
    {
        try {
            // Find the user by ID
            $user = User::findOrFail($request->user_id);
            $imageName = '';
            // Handle image upload if present
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($user->image) {
                    $oldImagePath = public_path('/backend/images/user') . '/' . $user->image;
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('backend/images/user'), $imageName); // Di chuyển ảnh vào thư mục public/backend/images
            }

            $user->fullname = $request->fullname;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->status = $request->status === 'true' ? true : false;

            $user->fill([
                'fullname' => $request->fullname,
                'email' => $request->email,
                'phone' => $request->phone,
                'status' => $request->status === 'true' ? true : false,
                'image' => $imageName !== '' ? $imageName : $user->image,
            ]);

            $user->save();

            // Redirect back with success message
            return redirect()->route('admin.user')->with('success', 'Chỉnh sửa thông tin nhân viên thành công.');
        } catch (ModelNotFoundException $e) {
            // Handle case where user_id does not exist
            return redirect()->route('admin.user')->with('error', 'Nhân viên này không tồn tại!');
        } catch (\Exception $e) {
            // Handle other exceptions
            return redirect()->back()->with('error', 'Đã có lỗi xảy ra khi thay đổi thông tin nhân viên.');
        }
    }

    public function deleteUser($user_id)
    {
        try {
            $user = User::findOrFail($user_id);

            // Xóa hình ảnh nếu tồn tại
            if ($user->image) {
                $imagePath = public_path('backend/images/user') . '/' . $user->image;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            // Xóa user
            $user->delete();

            return redirect()->back()->with('success', 'Đã xóa nhân viên thành công.');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Nhân viên này không tồn tại.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Đã có lỗi xảy ra khi xóa nhân viên.');
        }
    }
}
