<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Checkout;
use App\Models\Vehicle;
use App\Models\Checkin;
use Alert;


class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $checkout = new Checkout();

        $checkout->vehicle_name = $request->vehicle_name;
        $checkout->checkout_time = $request->checkout_time;
        $checkout->checkout_mileage = $request->checkout_mileage;




        $checkout->save();
        Alert::success('Congrats', 'Data submitted successfully. Thanks');

        return back();
    }
}
