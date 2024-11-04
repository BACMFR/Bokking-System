<?php

namespace App\Http\Controllers\Admin;

use App\Models\Business;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BusinessController extends Controller
{
    public function index()
    {
        $businesses = Business::paginate(10);
        return response()->json([
            'success' => true,
            'messsage' => 'found Successfully',
            'data' => $businesses
        ], 200);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'starting_hour' => 'required',
            'ending_hour' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400);
        }

        $business = Business::create([
            'name' => $request->name,
            'user_id' => Auth::user()->id,
            'starting_hour' => $request->starting_hour,
            'ending_hour' => $request->ending_hour,
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Business created successfully',
            'data' => $business
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $business = Business::find($id);
        if (!$business) {
            return response()->json([
                'success' => false,
                'message' => 'Business not found',
                'data' => null
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'starting_hour' => 'sometimes|required',
            'ending_hour' => 'sometimes|required',
            'status' => 'sometimes|required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400);
        }

        $business->update([
            'name' => $request->name,
            'starting_hour' => $request->starting_hour,
            'ending_hour' => $request->ending_hour,
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Business updated successfully',
            'data' => $business
        ], 200);
    }
    public function destroy($id)
    {
        $business = Business::find($id);
        if (!$business) {
            return response()->json([
                'success' => false,
                'message' => 'Business not found',
                'data' => null
            ], 404);
        }

        $business->delete();

        return response()->json([
            'success' => true,
            'message' => 'Business deleted successfully',
            'data' => null
        ], 200);
    }
}
