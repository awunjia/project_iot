<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\Sensor;
use App\Models\SensorData;
use App\Events\SensorDataUpdated;
use Illuminate\Support\Facades\Auth;

class SensorDataController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $devices = Auth::user()->devices ?? collect();
        return view('pages.sensor_data.selector', compact('devices'));
    }

    public function getSensors($deviceId)
    {
        $sensors = Sensor::where('device_id', $deviceId)->get();
        return response()->json(['sensors' => $sensors]);
    }

    public function showData(Request $request)
    {
        $request->validate([
            'device_id' => 'required|exists:devices,id',
            'sensor_id' => 'required|exists:sensors,id',
        ]);

        $sensorData = SensorData::with('sensor')
            ->whereHas('sensor', function ($query) use ($request) {
                $query->where('device_id', $request->device_id);
            })
            ->where('sensor_id', $request->sensor_id)
            ->get();

        return view('pages.sensor_data.sensor_chart', compact('sensorData'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'temperature' => 'required|numeric',
            'humidity' => 'required|numeric',
        ]);

        $sensorData = SensorData::create([
            'sensor_id' => 1, 
            'temperature' => $data['temperature'],
            'humidity' => $data['humidity'],
        ]);

        event(new SensorDataUpdated($data['temperature'], $data['humidity']));

        return response()->json(['message' => 'Data stored successfully'], 201);
    }

}