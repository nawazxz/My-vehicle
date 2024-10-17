<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Checkin;
use App\Models\Checkout;
use Carbon\Carbon; // Import Carbon for date manipulation

class HomeController extends Controller
{
    public function home()
    {
        // Fetch all check-in and check-out records
        $checkins = Checkin::latest()->take(10)->get();
        $totalMileage = 100; // Replace with your calculation logic
        $newCheckins = $checkins->count(); // Count of new check-ins
        $todayMileage = 50; // Replace with today's mileage logic
    
        // Example of percentage calculations
        $checkinsIncreasePercentage = 5; // Example value
        $checkinsDecreasePercentage = 2; // Example value for decrease percentage
        $mileageIncreasePercentage = 10; // Example value for mileage increase
    
        // Calculate today's mileage increase percentage
        $todayMileageIncreasePercentage = 15; // Example percentage or calculation logic
    
        return view('dashboard', compact(
            'checkins',
            'totalMileage',
            'newCheckins',
            'todayMileage',
            'checkinsIncreasePercentage',
            'checkinsDecreasePercentage',
            'mileageIncreasePercentage',
            'todayMileageIncreasePercentage' // Pass this to the view
        ));
    }
    
    public function getVehicleLocation() {
        // Fetch the current latitude and longitude for vehicle ID 1
        $vehicle = Vehicle::where('id', 1)->first(['latitude', 'longitude']);
        
        if ($vehicle) {
            return response()->json($vehicle);
        } else {
            return response()->json(['error' => 'Vehicle not found'], 404);
        }
    }
}
