<?php

namespace App\Repositories;

use App\Models\Device;
use Illuminate\Support\Facades\Auth;

class DeviceRepo
{
    public function createDevice(array $data): Device
    {
        return Device::create($data);
    }

    public function findDeviceById(int $id): ? Device
    {
        return Device::find($id);
    }

    public function updateDevice(int $id, array $data): Device
    {
        $device = $this->findDeviceById($id);
        $device->update($data);
        return $device;
    }

    public function deleteDevice(int $id): bool
    {
        $device = $this->findDeviceById($id);
        return $device ? $device->delete() : false;
    }

    public function getAllUserDevices()
    {
        $user_id = Auth::user()->id;
        return Device::where('user_id', $user_id)->paginate(10);
    }

    public function deviceCount()
    {
        $user_id = Auth::user()->id;
        return Device::where('user_id', $user_id)->count();
    }
    
}