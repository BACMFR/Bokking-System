<?php

namespace App\Http\Controllers\Business;

use App\Models\Business;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    public function index()
    {
        $business = Business::where('user_id', Auth::id())->first();
        $services = Service::where('business_id', $business->id)->paginate(10);
        return response()->json([
            'success' => true,
            'message' => 'Found Successfully',
            'data' => $services,
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400);
        }

        $business = Business::where('user_id', Auth::id())->first();
        $service = Service::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'business_id' => $business->id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Service Created Successfully',
            'data' => $service,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $service = Service::find($id);
        if (!$service) {
            return response()->json([
                'success' => false,
                'message' => 'Service not found',
                'data' => null
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|min:2|max:255',
            'price' => 'sometimes|required|numeric',
            'description' => 'sometimes|nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400);
        }

        $service->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Service updated successfully',
            'data' => $service,
        ], 200);
    }

    public function destroy($id)
    {
        $service = Service::find($id);
        if (!$service) {
            return response()->json([
                'success' => false,
                'message' => 'Service not found',
                'data' => null
            ], 404);
        }

        $service->delete();

        return response()->json([
            'success' => true,
            'message' => 'Service deleted successfully',
            'data' => null
        ], 200);
    }
}
