<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;
    protected $fillable = [
        'vehicle_id', 
        'trip_start_time', 
        'trip_end_time', 
        'mileage'
    ];
}
