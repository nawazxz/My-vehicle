@extends('layouts.user_type.auth')

@section('content')

<div class="row">
    <!-- Today's Check-ins Card -->
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Today's Check-ins</p>
                            <h5 class="font-weight-bolder mb-0">
                                {{ $checkins->count() }}
                                <span class="text-success text-sm font-weight-bolder">+{{ $checkinsIncreasePercentage }}%</span>
                            </h5>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                            <i class="ni ni-calendar-grid-58 text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Mileage Card -->
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Mileage</p>
                            <h5 class="font-weight-bolder mb-0">
                                {{ $totalMileage }} km
                                <span class="text-success text-sm font-weight-bolder">+{{ $mileageIncreasePercentage }}%</span>
                            </h5>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                            <i class="ni ni-map-big text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New Check-ins Card -->
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold">New Check-ins</p>
                            <h5 class="font-weight-bolder mb-0">
                                +{{ $newCheckins }}
                                <span class="text-danger text-sm font-weight-bolder">-{{ $checkinsDecreasePercentage }}%</span>
                            </h5>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                            <i class="ni ni-briefcase-24 text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Mileage Card -->
    <div class="col-xl-3 col-sm-6">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Today's Mileage</p>
                            <h5 class="font-weight-bolder mb-0">
                                {{ $todayMileage }} km
                                <span class="text-success text-sm font-weight-bolder">+{{ $todayMileageIncreasePercentage }}%</span>
                            </h5>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                            <i class="ni ni-bullet-list-67 text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4"> <!-- Added mt-4 for spacing -->
  <div class="col-xl-12 col-sm-12 mb-xl-0 mb-4">
      <div class="card">
          <div class="card-body p-3">
              <div class="row">
                  <div class="col-12">
                      <h5 class="font-weight-bolder mb-3">Map View</h5>
                      <!-- Map Container -->
                      <div id="map" style="height: 400px;"></div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>

<!-- Real-time Map Script for Leaflet -->
<script>
    // Initialize the map centered at Hunza
    var map = L.map('map').setView([36.3165, 74.6500], 13);

    // Add tile layer from OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Initialize the marker at a default position
    var marker = L.marker([36.3165, 74.6500]).addTo(map);

    // Function to update vehicle location
    function updateVehicleLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.watchPosition(
            function (position) {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;

                console.log(`Device Location: Latitude: ${latitude}, Longitude: ${longitude}`);

                // Update the marker's position on the map
                marker.setLatLng([latitude, longitude]);

                // Optionally, center the map to the new position
                map.setView([latitude, longitude], 13);

                // Send the updated location to the server (optional)
                fetch('/vehicle-location/update', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        latitude: latitude,
                        longitude: longitude,
                    }),
                })
                .then(response => response.json())
                .then(data => console.log("Server response:", data))
                .catch(error => console.error("Error updating vehicle location:", error));
            },
            function (error) {
                // Handle errors
                switch (error.code) {
                    case error.PERMISSION_DENIED:
                        console.error("User denied the request for Geolocation.");
                        alert("Location access is denied. Please enable it in your browser settings.");
                        break;
                    case error.POSITION_UNAVAILABLE:
                        console.error("Location information is unavailable.");
                        break;
                    case error.TIMEOUT:
                        console.error("The request to get user location timed out.");
                        break;
                    case error.UNKNOWN_ERROR:
                        console.error("An unknown error occurred.");
                        break;
                }
            },
            { enableHighAccuracy: true } // Options to get the most accurate location data
        );
    } else {
        console.warn("Geolocation is not supported by this browser.");
        alert("Geolocation is not supported by this browser.");
    }
}

// Run the function to start tracking
updateVehicleLocation();

// Run this function to start tracking

// Periodically fetch the vehicle's location every 5 seconds
setInterval(updateVehicleLocation, 2000);


// Call updateVehicleLocation every 5 seconds
</script>


@endsection

@push('dashboard')
<!-- Chart Scripts -->
<script>
    window.onload = function() {
        // Bar Chart for Sales
        var ctx = document.getElementById("chart-bars").getContext("2d");
        new Chart(ctx, {
            type: "bar",
            data: {
                labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Sales",
                    backgroundColor: "#fff",
                    data: [450, 200, 100, 220, 500, 100, 400, 230, 500],
                    maxBarThickness: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Line Chart for Mobile Apps
        var ctx2 = document.getElementById("chart-line").getContext("2d");
        new Chart(ctx2, {
            type: "line",
            data: {
                labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Mobile apps",
                    borderColor: "#cb0c9f",
                    data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }
</script>
@endpush
