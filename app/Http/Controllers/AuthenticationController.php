<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends Controller
{
    //--- START ADMIN ---

    public function signIn()
    {
        return view('admin.sign-in.sign-in');
    }

    public function checkSignIn(Request $request)
    {
        // Validate the request
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Tên đăng nhập không được để trống.',
            'password.required' => 'Mật khẩu không được để trống.',
        ]);

        try {
            $user = User::where('username', $request->username)->first();
            if ($user != null) {

                if (Hash::check($request->password, $user->password)) {

                    if (Auth::loginUsingId($user->user_id)) {
                        // Đăng nhập thành công
                        Session::put('user', $user);
                        return redirect()->intended('/admin/dashboard');
                    }
                }
            }

            // Đăng nhập thất bại, hiển thị form đăng nhập với thông báo lỗi
            return back()->withErrors([
                'error' => 'Tên đăng nhập hoặc mặt khẩu không chính xác!',
            ])->withInput($request->only('username'));
        } catch (QueryException $e) {
            // Show a friendly error message to the user
            return back()->withErrors(['error' => 'Đã có lỗi gì đó xảy ra, vui lòng thử lại sau.']);
        }
    }

    public function signOut(Request $request)
    {
        Auth::logout();
        return redirect('/admin/sign-in');
    }

    //--- END ADMIN ---

    //--- START CLIENT ---

    public function checkAccount(Request $request)
    {
        // Lấy tên đăng nhập từ request
        $account = $request->input('account');

        // Kiểm tra xem tên đăng nhập đã tồn tại trong cơ sở dữ liệu hay chưa
        $customer = Customer::where('account', $account)->first();

        // Trả về kết quả
        if ($customer) {
            // Nếu tên đăng nhập đã tồn tại, trả về true
            return response()->json(['exists' => true]);
        } else {
            // Nếu tên đăng nhập chưa tồn tại, trả về false
            return response()->json(['exists' => false]);
        }
    }

    public function register(Request $request)
    {
        $customer = new Customer;
        $customer->fullname = $request->fullname;
        $customer->account = $request->account;
        $customer->password = bcrypt($request->password);
        $customer->status = true;
        $customer->save();

        return redirect()->back()->with('success', 'Tạo tài khoản thành công');
    }

    public function login(Request $request)
    {
        $customer = new Customer;
        $customer->fullname = $request->fullname;
        $customer->account = $request->account;
        $customer->password = bcrypt($request->password);
        $customer->status = true;
        $customer->save();

        return redirect()->back()->with('success', 'Đăng nhập khoản thành công');
    }

    //--- END CLIENT ---
}
