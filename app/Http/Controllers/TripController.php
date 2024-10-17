<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TripController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'trip_start_time' => 'required|date',
            'trip_end_time' => 'nullable|date',
            'mileage' => 'nullable|numeric|min:0',
        ]);

        Trip::create([
            'vehicle_id' => $request->vehicle_id,
            'trip_start_time' => $request->trip_start_time,
            'trip_end_time' => $request->trip_end_time,
            'mileage' => $request->mileage,
        ]);

        return redirect()->back()->with('success', 'Trip recorded successfully.');
}


};
