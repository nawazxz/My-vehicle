@extends('layouts.user_type.auth')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <!-- Average Mileage -->
            <div class="card mb-4">
                <h5 class="card-header">Average Mileage</h5>
                <div class="card-body">
                    <p>Average Mileage: {{ $averageMileage }} km</p>
                </div>
            </div>

            <!-- Recent Check-Ins -->
            <div class="card mb-4">
                <h5 class="card-header">Recent Check-Ins</h5>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Vehicle Name</th>
                                <th>Check-In Time</th>
                                <th>Check-In Mileage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($checkins as $checkin)
                                <tr>
                                    <td>{{ $checkin->vehicle_name }}</td>
                                    <td>{{ $checkin->checkin_time }}</td>
                                    <td>{{ $checkin->mileage }} km</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Check-Outs -->
            <div class="card mb-4">
                <h5 class="card-header">Recent Check-Outs</h5>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Vehicle Name</th>
                                <th>Check-Out Time</th>
                                <th>Check-Out Mileage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($checkouts as $checkout)
                                <tr>
                                    <td>{{ $checkout->vehicle_name }}</td>
                                    <td>{{ $checkout->checkout_time }}</td>
                                    <td>{{ $checkout->checkout_mileage }} km</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Download Report Button -->
            <div class="mb-4">
                <a href="{{ route('vehicle.tripHistory') }}" class="btn btn-secondary">Download Report as PDF</a>
            </div>
        </div>
    </div>
</div>
@endsection
