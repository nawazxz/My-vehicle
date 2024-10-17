<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Vehicle;
use App\Models\Checkin;
use App\Models\Checkout;
use PDF;
use Alert; 


class VehicleController extends Controller
{
public function index()
{
    $checkins = Checkin::latest()->take(10)->get();
    $checkouts = Checkout::latest()->take(10)->get();

    // Initialize total mileage and record count
    $totalMileage = 0;
    $recordCount = 0;

    // Calculate the total mileage by matching check-ins with check-outs
    foreach ($checkins as $checkin) {
        // Find the corresponding checkout record
        $checkout = $checkouts->filter(function ($checkout) use ($checkin) {
            return $checkout->vehicle_name === $checkin->vehicle_name &&
                $checkout->checkout_time > $checkin->checkin_time;
        })->sortBy('checkout_time')->first();

        if ($checkout) {
            $totalMileage += $checkout->checkout_mileage - $checkin->mileage;
            $recordCount++;
        }
    }

    // Calculate average mileage
    $averageMileage = $recordCount ? $totalMileage / $recordCount : 0;

    // Fetch the latest vehicle (assuming you need this data in the view)
    $vehicle = Vehicle::latest()->take(1)->get();

    // Pass the data to the view
    return view('vehicle-management.index', compact('checkins', 'checkouts', 'averageMileage', 'vehicle'));
}

public function store(Request $request)
{
    $request->validate([
        'license_plate' => 'required|unique:vehicles',
        'model' => 'required',
    ]);
    Vehicle::create($request->all());
    return redirect()->route('vehicles.index');
}

public function showTripHistory()
{
    // Fetch recent check-ins and check-outs
    $checkins = Checkin::latest()->take(10)->get();
    $checkouts = Checkout::latest()->take(10)->get();

    // Initialize total mileage and record count
    $totalMileage = 0;
    $recordCount = 0;

    // Calculate the total mileage by matching check-ins with check-outs
    foreach ($checkins as $checkin) {
        // Find the corresponding checkout record
        $checkout = $checkouts->filter(function ($checkout) use ($checkin) {
            return $checkout->vehicle_name === $checkin->vehicle_name &&
                $checkout->checkout_time > $checkin->checkin_time;
        })->sortBy('checkout_time')->first();

        if ($checkout) {
            $totalMileage += $checkout->checkout_mileage - $checkin->mileage;
            $recordCount++;
        }
    }

    // Calculate average mileage
    $averageMileage = $recordCount ? $totalMileage / $recordCount : 0;

    return view('vehicle-management.trip-history', compact('checkins', 'checkouts', 'averageMileage'));
}
public function downloadReport()
{
    // Fetch data for the report
    $checkins = Checkin::all();
    $checkouts = Checkout::all();
    $averageMileage = // Calculate as needed

    // Load the view and pass the data
    $pdf = PDF::loadView('vehicle-management.report', compact('checkins', 'checkouts', 'averageMileage'));

    // Download the PDF
    return $pdf->download('trip_report.pdf');
}

public function getVehicleLocation()
{
    // Get the latest vehicle (you can modify this to suit your requirements)
    $vehicle = Vehicle::latest()->first();

    // Check if vehicle exists and has valid coordinates
    if ($vehicle && $vehicle->latitude && $vehicle->longitude) {
        return response()->json([
            'latitude' => $vehicle->latitude,
            'longitude' => $vehicle->longitude,
        ]);
    }

    // Return a default response or an error if no data is available
    return response()->json(['error' => 'Vehicle location not available'], 404);
}


// Store or update vehicle location (e.g., via a mobile phone)
public function updateVehicleLocation(Request $request)
{
    // Get the posted latitude and longitude
    $latitude = $request->input('latitude');
    $longitude = $request->input('longitude');

    // Logic to store or update the vehicle's location (e.g., in the database)
    // For example, update the latest location for a specific vehicle:
    Vehicle::where('id', 1) // Assuming one vehicle for now
        ->update([
            'latitude' => $latitude,
            'longitude' => $longitude,
        ]);

    return response()->json(['status' => 'Location updated successfully']);
}


}
