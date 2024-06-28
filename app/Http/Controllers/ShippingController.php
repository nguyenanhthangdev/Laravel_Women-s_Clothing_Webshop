<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Shipping;
use App\Models\Ward;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShippingController extends Controller
{
    public function getDistricts($cityId)
    {
        $districts = District::where('city_id', $cityId)->get();
        return response()->json($districts);
    }

    public function getWards($districtId)
    {
        $wards = Ward::where('district_id', $districtId)->get();
        return response()->json($wards);
    }

    public function addShipping(Request $request)
    {
        try {
            if ($request->session()->has('customer')) {
                $customer = $request->session()->get('customer');
                $customerId = $customer->customer_id;

                $fullName = $request->input('fullName');
                $phoneNumber = $request->input('phoneNumber');
                $email = $request->input('email');
                $city = $request->input('city');
                $district = $request->input('district');
                $ward = $request->input('ward');
                $specific = $request->input('specific');
                $addressType = $request->input('addressType');

                // Kiểm tra xem đã có địa chỉ giao hàng nào với customer_id chưa
                $existingShippingCount = Shipping::where('customer_id', $customerId)->count();

                $shipping = new Shipping();
                $shipping->fullname = $fullName;
                $shipping->phone_number = $phoneNumber;
                $shipping->email = $email;
                $shipping->city_id = $city;
                $shipping->district_id = $district;
                $shipping->ward_id = $ward;
                $shipping->address_specific = $specific;
                $shipping->address_type = $addressType;
                $shipping->status = $existingShippingCount == 0;;
                $shipping->customer_id = $customerId;

                $shipping->save();

                return response()->json(['success' => true, 'message' => 'Địa chỉ giao hàng đã được thêm thành công.'], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'Đã xảy ra lỗi, vui lòng thử lại.'], 401);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Đã xảy ra lỗi, vui lòng thử lại.'], 500);
        }
    }

    public function getAllShippingByCustomerId(Request $request)
    {
        try {
            $customer = $request->session()->get('customer');
            $customerId = $customer->customer_id;

            // Lấy danh sách shipping của khách hàng
            $shippings = Shipping::with('ward', 'district', 'city')
                ->where('customer_id', $customerId)
                ->get();

            // Trả về dữ liệu dưới dạng JSON
            return response()->json(['shippings' => $shippings]);
        } catch (QueryException $e) {
            // Trả về lỗi cho client
            return response()->json(['error' => "Đã có lỗi xảy ra. Vui lòng thử lại sau"], 500);
        }
    }

    public function setDefaultShipping(Request $request)
    {
        DB::beginTransaction();
        try {
            $customer = $request->session()->get('customer');
            $customerId = $customer->customer_id;
            $idDefaultShipping = $request->input('idDefaultShipping');

            // Cập nhật tất cả các bản ghi của customer này thành status = false
            DB::table('shipping')
                ->where('customer_id', $customerId)
                ->update(['status' => false]);

            // Cập nhật bản ghi với idDefaultShipping thành status = true
            DB::table('shipping')
                ->where('customer_id', $customerId)
                ->where('shipping_id', $idDefaultShipping)
                ->update(['status' => true]);

            DB::commit();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function deleteShipping($shipping_id)
    {
        try {
            $shipping = Shipping::find($shipping_id);

            if (!$shipping) {
                return response()->json(['success' => false, 'message' => 'Địa chỉ không tồn tại.'], 404);
            }

            if ($shipping->status) {
                return response()->json(['success' => false, 'message' => 'Không thể xóa địa chỉ mặc định.'], 400);
            }

            $shipping->delete();

            return response()->json(['success' => true, 'message' => 'Địa chỉ đã được xóa thành công.'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Không thể xóa địa chỉ này.'], 500);
        }
    }

    public function checkShippingAddress(Request $request)
    {
        $customer = $request->session()->get('customer');
        $customerId = $customer->customer_id;

        // Kiểm tra xem có địa chỉ giao hàng nào với status=true cho người dùng hiện tại hay không
        $hasShippingAddress = Shipping::where('customer_id', $customerId)
            ->where('status', true)
            ->exists();

        if ($hasShippingAddress) {
            return response()->json(['hasShippingAddress' => true]);
        } else {
            return response()->json(['hasShippingAddress' => false]);
        }
    }
}
