<?php

// app/Models/Sensor.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    use HasFactory;

    protected $fillable = ['device_id', 'name', 'type', 'pin'];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function readings()
    {
        return $this->hasMany(SensorReading::class);
    }
}
