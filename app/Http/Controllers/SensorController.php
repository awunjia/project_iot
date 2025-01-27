<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\SensorRepo;
use App\Repositories\DeviceRepo;
use App\Http\Requests\Sensor\CreateSensor;

class SensorController extends Controller
{
    protected  $sensor;

    public function __construct(SensorRepo $sensor, DeviceRepo $device)
    {
        $this->sensor = $sensor;
        $this->device = $device;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $d['devices'] = $this->device->getAllDevices();
        $d['sensors'] = $this->sensor->getAllSensors();
        return view('pages.sensor.index', $d);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateSensor $req)
    {
        $data = $req->only(['device_id', 'type', 'pin']);
        $this->sensor->createSensor($data);
        return redirect()->back()->with('success', 'Sensor created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $d['sensors'] = $this->sensor->getAllSensors();
        $d['devices'] = $this->device->getAllDevices();
        $d['sensor'] = $this->sensor->findSensorById($id);
        return view('pages.sensor.edit', $d);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateSensor $req, $id)
    {
        $data = $req->only(['device_id', 'type', 'pin']);
        $this->sensor->updateSensor($id, $data);
        return redirect()->route('sensors.index')->with('success', 'Sensor updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->sensor->deleteSensor($id);
        return redirect()->back()->with('success', 'Sensor deleted successfully!');
    }
}
