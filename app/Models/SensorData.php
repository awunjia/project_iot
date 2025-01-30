<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SensorData extends Model
{
    protected $fillable = ['sensor_id', 'temperature', 'humidity'];

    public function sensor()
    {
        return $this->belongsTo(Sensor::class);
    }
}
