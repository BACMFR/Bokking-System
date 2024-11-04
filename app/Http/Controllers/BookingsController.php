<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BookingsController extends Controller
{
    public function index()
    {
        $bookings = Booking::where('user_id', Auth::user()->id)->paginate(10);
        return response()->json([
            'success' => true,
            'message' => 'Found successfully',
            'data' => $bookings
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'time' => 'required|string',
            'service_id' => 'required|exists:services,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400);
        }

        $booking = Booking::create([
            'time' => $request->time,
            'user_id' => Auth::id(),
            'service_id' => $request->service_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Booking Created Successfully',
            'data' => $booking
        ], 201);
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return response()->json([
            'success' => true,
            'message' => 'Booking Deleted Successfully'
        ], 200);
    }
}
