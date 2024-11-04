<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReviewsController extends Controller
{
    public function index()
    {
        $reviews = Review::paginate(10);
        return response()->json([
            'success' => true,
            'message' => 'Reviews Found Successfully',
            'data' => $reviews
        ], 200);
    }

    public function business_review($id)
    {
        $reviews = Review::where('business_id', $id)->paginate(10);
        return response()->json([
            'success' => true,
            'message' => 'Business Reviews Found Successfully',
            'data' => $reviews
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'review' => 'required|string|max:255',
            'stars' => 'required|',
            'business_id' => 'required|exists:businesses,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400);
        }

        $review = Review::create([
            'review' => $request->review,
            'stars' => $request->stars,
            'business_id' => $request->business_id,
            'user_id' => Auth::id()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Review Created Successfully',
            'data' => $review
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'review' => 'sometimes|required|string|max:255',
            'stars' => 'sometimes|required',
            'business_id' => 'sometimes|required|exists:businesses,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400);
        }

        $review = Review::findOrFail($id);
        $review->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Review Updated Successfully',
            'data' => $review
        ], 200);
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return response()->json([
            'success' => true,
            'message' => 'Review Deleted Successfully'
        ], 200);
    }
}
