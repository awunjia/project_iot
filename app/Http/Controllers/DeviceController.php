<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\DeviceRepo;
use App\Http\Requests\Device\CreateDevice;
use App\Http\Requests\Device\UpdateDevice;
use Illuminate\Support\Facades\Auth;

class DeviceController extends Controller
{

    protected  $device;

    public function __construct(DeviceRepo $device)
    {
        $this->device = $device;
    }

    public function index()
    {
        $d['devices'] = $this->device->getAllUserDevices();
        return view('pages.device.index', $d);
    }

    public function store(CreateDevice $req)
    {
        $user_id = Auth::user()->id;
        $data = [
            'user_id' => $user_id,
            'name' => $req->name,
            'description' => $req->description,
            'location' => $req->location
        ];
        $this->device->createDevice($data);
        return redirect()->back()->with('success', 'Device created successfully!');
    }

    public function edit($id)
    {
        $d['device'] = $this->device->findDeviceById($id);
        return view('pages.device.edit', $d);
    }

    public function update(UpdateDevice $req, $id)
    {
        $data = $req->only(['name', 'location', 'description']);
        $this->device->updateDevice($id, $data);
        return redirect()->route('devices.index')->with('success', 'Device updated successfully!');
    }

    public function destroy($id)
    {
        $this->device->deleteDevice($id);
        return redirect()->back()->with('success', 'Device deleted successfully!');
    }
}
