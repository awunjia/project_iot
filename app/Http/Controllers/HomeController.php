<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\DeviceRepo;
use App\Repositories\SensorRepo;
use App\Repositories\UserRepo;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    protected  $device, $sensor, $user;

    public function __construct(DeviceRepo $device, SensorRepo $sensor, UserRepo $user)
    {
        $this->device = $device;
        $this->sensor = $sensor;
        $this->user = $user;
    }

    public function home()
    {
        $user = $this->user->findUserById(Auth::user()->id);
        $d['device'] = $this->device->deviceCount();
        $d['sensor'] = $user->sensors;
        return view('pages.dashboard', $d);
    }
}
