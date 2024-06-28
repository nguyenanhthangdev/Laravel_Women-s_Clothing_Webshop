<?php

namespace App\Http\Controllers;

use App\Models\ProductReview;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    public function addReview(Request $request, $product_id)
    {
        try {
            $customer = $request->session()->get('customer');
            $customerId = $customer->customer_id;

            // Create the review
            $review = new ProductReview();
            $review->product_id = $product_id;
            $review->customer_id = $customerId;
            $review->rating = $request->input('rating');
            $review->comment = $request->input('comment');
            $review->save();

            return response()->json(['success' => true, 'message' => 'Review submitted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()]);
        }
    }
}
