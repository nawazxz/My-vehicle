@extends('layouts.user_type.auth')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <!-- Check-In Form -->
        <div class="mb-4 col-lg-6">
            <div class="card">
                <h5 class="card-header">Vehicle Check-In</h5>
                <div class="card-body">
                    <form action="{{ route('checkin.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="vehicle_name_checkin" class="form-label">Vehicle Name</label>
                            <input type="text" class="form-control" id="vehicle_name_checkin" name="vehicle_name" value="Revo Champ 2021" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="checkin_time" class="form-label">Check-In Time</label>
                            <input type="datetime-local" class="form-control" id="checkin_time" name="checkin_time" required>
                        </div>
                        <div class="mb-3">
                            <label for="checkin_mileage" class="form-label">Mileage at Check-In (km)</label>
                            <input type="number" step="0.01" class="form-control" id="checkin_mileage" name="mileage" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Check In</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Check-Out Form -->
        <div class="mb-4 col-lg-6">
            <div class="card">
                <h5 class="card-header">Vehicle Check-Out</h5>
                <div class="card-body">
                    <form action="{{ route('checkout.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="vehicle_name_checkout" class="form-label">Vehicle Name</label>
                            <input type="text" class="form-control" id="vehicle_name_checkout" name="vehicle_name" value="Revo Champ 2021" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="checkout_time" class="form-label">Check-Out Time</label>
                            <input type="datetime-local" class="form-control" id="checkout_time" name="checkout_time" required>
                        </div>
                        <div class="mb-3">
                            <label for="checkout_mileage" class="form-label">Mileage at Check-Out (km)</label>
                            <input type="number" step="0.01" class="form-control" id="checkout_mileage" name="checkout_mileage" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Check Out</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Average Mileage -->
        <div class="col-lg-12">
            <div class="card mb-4">
                <h5 class="card-header">Average Mileage</h5>
                <div class="card-body">
                    <p>The average mileage for the vehicle is: {{ number_format($averageMileage, 2) }} km</p>
                </div>
            </div>
        </div>

        <!-- Recent Check-Ins -->
       
    </div>
</div>

@endsection
