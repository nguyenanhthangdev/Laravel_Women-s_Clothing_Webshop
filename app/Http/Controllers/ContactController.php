<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Manufacturer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // --- CLIENT: START CONTACT ---
    public function contact()
    {
        $categories = Category::active()->get();
        $manufacturers = Manufacturer::active()->get();
        return view('client.contact.contact', compact('categories', 'manufacturers'));
    }

    public function sendContact(Request $request)
    {
        try {
            $fullName = $request->input('fullName');
            $phoneNumber = $request->input('phoneNumber');
            $email = $request->input('email');
            $title = $request->input('title');
            $detail = $request->input('detail');

            $contact = new Contact();
            $contact->name = $fullName;
            $contact->phone = $phoneNumber;
            $contact->email = $email;
            $contact->title = $title;
            $contact->detail = $detail;

            $contact->save();

            return response()->json(['success' => true, 'message' => 'Đánh giá của bạn đã được gửi thành công.'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Đã xảy ra lỗi, vui lòng thử lại.'], 500);
        }
    }
    // --- CLIENT: END CONTACT ---

    // --- ADMIN: START CONTACT ---
    public function allContact()
    {
        $contacts = Contact::all();
        return view('admin.contact.contact', compact('contacts'));
    }

    public function contactDetails($contact_id)
    {
        try {
            $contact = Contact::findOrFail($contact_id);
            return view('admin.contact.contact-details', compact('contact'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.contact')->with('error', 'Phản hồi này không tồn tại!');
        }
    }
    // --- ADMIN: END CONTACT ---
}
