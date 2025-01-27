@extends('partials.layouts.app')

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
                                <div class="col-6">
                                    <label for="device_id" class="form-label">Device <span class="text-danger">*</span></label>
                                    <select name="device_id" id="device_id" class="form-select" required>
                                        <option value="" disabled>Select a Device</option>
                                        @foreach($devices as $device)
                                            <option value="{{ $device->id }}" {{ $sensor->device_id == $device->id ? 'selected' : '' }}>
                                                {{ $device->name }} ({{ $device->location }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-6">
                                    <label for="type" class="form-label">Sensor Type <span class="text-danger">*</span></label>
                                    <select name="type" id="type" class="form-select" required>
                                        <option value="" disabled>Select Sensor Type</option>
                                        <option value="temperature" {{ $sensor->type == 'temperature' ? 'selected' : '' }}>Temperature</option>
                                        <option value="temphum" {{ $sensor->type == 'temphum' ? 'selected' : '' }}>Temphum</option>
                                        <option value="motion" {{ $sensor->type == 'motion' ? 'selected' : '' }}>Motion</option>
                                        <option value="light" {{ $sensor->type == 'light' ? 'selected' : '' }}>Light</option>
                                        <option value="vibration" {{ $sensor->type == 'vibration' ? 'selected' : '' }}>Vibration</option>
                                        <option value="smoke" {{ $sensor->type == 'smoke' ? 'selected' : '' }}>Smoke</option>
                                        <option value="co_h2o" {{ $sensor->type == 'co_h2o' ? 'selected' : '' }}>Co/H2O</option>
                                        <option value="humidity" {{ $sensor->type == 'humidity' ? 'selected' : '' }}>Humidity</option>
                                        <option value="distance" {{ $sensor->type == 'distance' ? 'selected' : '' }}>Distance</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-12 my-5">
                                <label for="pin" class="form-label">Select GPIO Pin<span class="text-danger">*</span></label>
                                <div class="d-flex flex-wrap">
                                    @for ($i = 1; $i <= 25; $i++)
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="radio" name="pin" id="pin{{ $i }}" value="{{ $i }}" {{ $sensor->pin == $i ? 'checked' : '' }} required>
                                            <label class="form-check-label" for="pin{{ $i }}">
                                                Pin {{ $i }}
                                            </label>
                                        </div>
                                    @endfor
                                </div>
                            </div>

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