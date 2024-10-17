<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Checkin;
use App\Models\Checkout;

use App\Models\Vehicle;
use Alert;

class CheckinController extends Controller
{
   
    public function store(Request $request)
    {
        $checkin = new Checkin();

        $checkin->vehicle_name = $request->vehicle_name;
        $checkin->checkin_time = $request->checkin_time;
        $checkin->mileage = $request->mileage;




        $checkin->save();
        Alert::success('Congrats', 'Data submitted successfully. Thanks');

        return back();
    }
}
