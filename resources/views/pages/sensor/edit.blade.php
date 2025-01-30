@extends('partials.layouts.app')

@section('title', 'Edit Sensor - Project IOT')

@section('content')

<div class="pagetitle">
    <h1>All Sensors</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('sensors.index') }}">Sensors</a></li>
            <li class="breadcrumb-item active">Edit Sensor</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

@include('_message')

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <span class="d-flex align-items-center my-5">
                        <h5 class="card-title mb-0">Editting <strong>{{$sensor->device->name}}</strong> Sensor</h5>
                        <i class="bi bi-cpu ms-3"></i>
                    </span>
                    
                    <div class="col-12">
                        <form action="{{ route('sensors.update', $sensor->id) }}" method="POST">
                            @csrf 
                            @method('PUT')

                            <div class="row my-5">
                                <!-- Device Selection -->
                                <div class="col-4">
                                    <label for="device_id" class="form-label">Device <span class="text-danger">*</span></label>
                                    <select name="device_id" id="device_id" class="form-select" required>
                                        <option value="" disabled>Select a Device</option>
                                        @foreach($devices as $device)
                                            <option value="{{ $device->id }}" 
                                                {{ (old('device_id', $sensor->device_id) == $device->id) ? 'selected' : '' }}>
                                                {{ $device->name }} ({{ $device->location }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('device_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Sensor Name -->
                                <div class="col-4">
                                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" id="name" 
                                        value="{{ old('name', $sensor->name) }}">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Sensor Type Selection -->
                                <div class="col-4">
                                    <label for="type" class="form-label">Sensor Type <span class="text-danger">*</span></label>
                                    <select name="type" id="type" class="form-select" required>
                                        <option value="" disabled>Select Sensor Type</option>
                                        <option value="temperature" {{ old('type', $sensor->type) == 'temperature' ? 'selected' : '' }}>Temperature</option>
                                        <option value="temphum" {{ old('type', $sensor->type) == 'temphum' ? 'selected' : '' }}>Temperature & Humidity</option>
                                        <option value="humidity" {{ old('type', $sensor->type) == 'humidity' ? 'selected' : '' }}>Humidity</option>
                                        <option value="motion" {{ old('type', $sensor->type) == 'motion' ? 'selected' : '' }}>Motion</option>
                                        <option value="light" {{ old('type', $sensor->type) == 'light' ? 'selected' : '' }}>Light</option>
                                        <option value="vibration" {{ old('type', $sensor->type) == 'vibration' ? 'selected' : '' }}>Vibration</option>
                                        <option value="smoke" {{ old('type', $sensor->type) == 'smoke' ? 'selected' : '' }}>Smoke</option>
                                        <option value="gas" {{ old('type', $sensor->type) == 'gas' ? 'selected' : '' }}>Gas</option>
                                        <option value="co" {{ old('type', $sensor->type) == 'co' ? 'selected' : '' }}>Carbon Monoxide (CO)</option>
                                        <option value="co2" {{ old('type', $sensor->type) == 'co2' ? 'selected' : '' }}>Carbon Dioxide (CO₂)</option>
                                        <option value="pressure" {{ old('type', $sensor->type) == 'pressure' ? 'selected' : '' }}>Pressure</option>
                                        <option value="distance" {{ old('type', $sensor->type) == 'distance' ? 'selected' : '' }}>Distance/Proximity</option>
                                        <option value="infrared" {{ old('type', $sensor->type) == 'infrared' ? 'selected' : '' }}>Infrared (IR)</option>
                                        <option value="sound" {{ old('type', $sensor->type) == 'sound' ? 'selected' : '' }}>Sound/Noise</option>
                                        <option value="ph" {{ old('type', $sensor->type) == 'ph' ? 'selected' : '' }}>pH Level</option>
                                        <option value="water_level" {{ old('type', $sensor->type) == 'water_level' ? 'selected' : '' }}>Water Level</option>
                                        <option value="gps" {{ old('type', $sensor->type) == 'gps' ? 'selected' : '' }}>GPS/Location</option>
                                        <option value="current" {{ old('type', $sensor->type) == 'current' ? 'selected' : '' }}>Current Sensor</option>
                                        <option value="voltage" {{ old('type', $sensor->type) == 'voltage' ? 'selected' : '' }}>Voltage Sensor</option>
                                        <option value="magnetic" {{ old('type', $sensor->type) == 'magnetic' ? 'selected' : '' }}>Magnetic Field</option>
                                        <option value="air_quality" {{ old('type', $sensor->type) == 'air_quality' ? 'selected' : '' }}>Air Quality</option>
                                        <option value="soil_moisture" {{ old('type', $sensor->type) == 'soil_moisture' ? 'selected' : '' }}>Soil Moisture</option>
                                        <option value="uv" {{ old('type', $sensor->type) == 'uv' ? 'selected' : '' }}>UV Radiation</option>
                                        <option value="rfid" {{ old('type', $sensor->type) == 'rfid' ? 'selected' : '' }}>RFID/NFC</option>
                                    </select>
                                    @error('type')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- GPIO Pin Selection -->
                            <div class="mb-12 my-5">
                                <label for="pin" class="form-label">Select GPIO Pin <span class="text-danger">*</span></label>
                                <div class="d-flex flex-wrap">
                                    @for ($i = 1; $i <= 25; $i++)
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="radio" name="pin" id="pin{{ $i }}" 
                                                value="{{ $i }}" {{ old('pin', $sensor->pin) == $i ? 'checked' : '' }} required>
                                            <label class="form-check-label" for="pin{{ $i }}">
                                                Pin {{ $i }}
                                            </label>
                                        </div>
                                    @endfor
                                </div>
                                @error('pin')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="mt-5">
                                <button type="submit" class="btn btn-primary"><i class="bi bi-pencil me-2"></i>Update Sensor</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection