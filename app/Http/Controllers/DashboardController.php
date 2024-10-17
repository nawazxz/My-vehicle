<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Checkin;
use App\Models\Checkout;


class DashboardController extends Controller
{
    //

    public function index()
    {
        // Fetch the latest 10 check-ins and check-outs
        $checkins = Checkin::latest()->take(10)->get();
        $checkins = Checkin::all();
        $checkouts = Checkin::all();


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
};