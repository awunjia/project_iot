@extends('partials.layouts.app')

@section('title', 'Sensors - Project IOT')

@section('content')

<div class="pagetitle">
    <h1>All Sensors</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Sensors</li>
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
                        <h5 class="card-title mb-0">Showing All Active Sensors</h5>
                        <i class="bi bi-thermometer-half ms-3"></i>
                    </span>
                    
                    <!-- Default Tabs -->
                    <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link w-100 active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">All Sensors</button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link w-100" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Create New Sensor</button>
                        </li>
                    </ul>

                    <div class="tab-content pt-2" id="myTabContent">
                        
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            @if($sensors->isEmpty())
                                <div class="text-center my-5 text-warning">
                                    <span>No sensor found!</span>
                                </div>
                            @else
                                <table class="table table-striped table-responsive">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Device</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Type</th>
                                            <th scope="col">GPIO Pin</th>
                                            <th scope="col">Created On</th>
                                            <th scope="col">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($sensors as $index => $sensor)
                                            <tr>
                                                <th scope="row">{{ $index + 1 }}</th>
                                                <td>{{ $sensor->device->name }}</td>
                                                <td>{{ ucfirst($sensor->name) }}</td>
                                                <td>{{ ucfirst($sensor->type) }}</td>
                                                <td>{{ $sensor->pin }}</td>
                                                <td>{{ $sensor->created_at->format('jS M Y') }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{ $sensor->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="bi bi-ellipsis-v"></i>
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $sensor->id }}">
                                                            <li>
                                                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#showModalSensor" 
                                                                    data-id="{{ $sensor->id }}" data-name="{{$sensor->device->name}}" data-type="{{ $sensor->type }}" data-pin="{{ $sensor->pin }}"
                                                                    data-created="{{ $sensor->created_at->format('jS M Y') }}" data-location="{{ $sensor->device->location }}">
                                                                    <i class="bi bi-eye text-primary"></i> View Sensor
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="{{ route('sensors.edit', $sensor->id) }}">
                                                                    <i class="bi bi-pen text-warning"></i> Edit Sensor
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#confirmDeleteSensor" 
                                                                    data-id="{{ $sensor->id }}" data-title="{{ $sensor->device->name }}">
                                                                    <i class="bi bi-trash text-danger"></i> Delete Sensor
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <!-- Pagination Links -->
                                <div class="d-flex justify-content-center mt-4">
                                    {{ $sensors->links('vendor.pagination.bootstrap-5') }}
                                </div>
                            @endif
                        </div>

                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="col-12">
                                <form action="{{ route('sensors.store') }}" method="POST">
                                    @csrf 

                                    <div class="row my-5">
                                        <!-- Device Select -->
                                        <div class="col-4">
                                            <label for="device_id" class="form-label">Device <span class="text-danger">*</span></label>
                                            <select name="device_id" id="device_id" class="form-select" required>
                                                <option value="" selected disabled>Select a Device</option>
                                                @foreach($devices as $device)
                                                    <option value="{{ $device->id }}" {{ old('device_id') == $device->id ? 'selected' : '' }}>
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
                                            <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}">
                                            @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Sensor Type -->
                                        <div class="col-4">
                                            <label for="type" class="form-label">Sensor Type <span class="text-danger">*</span></label>
                                            <select name="type" id="type" class="form-select" required>
                                                <option value="" selected disabled>Select Sensor Type</option>
                                                <option value="temperature" {{ old('type') == 'temperature' ? 'selected' : '' }}>Temperature</option>
                                                <option value="temphum" {{ old('type') == 'temphum' ? 'selected' : '' }}>Temperature & Humidity</option>
                                                <option value="humidity" {{ old('type') == 'humidity' ? 'selected' : '' }}>Humidity</option>
                                                <option value="motion" {{ old('type') == 'motion' ? 'selected' : '' }}>Motion</option>
                                                <option value="light" {{ old('type') == 'light' ? 'selected' : '' }}>Light</option>
                                                <option value="vibration" {{ old('type') == 'vibration' ? 'selected' : '' }}>Vibration</option>
                                                <option value="smoke" {{ old('type') == 'smoke' ? 'selected' : '' }}>Smoke</option>
                                                <option value="gas" {{ old('type') == 'gas' ? 'selected' : '' }}>Gas</option>
                                                <option value="co" {{ old('type') == 'co' ? 'selected' : '' }}>Carbon Monoxide (CO)</option>
                                                <option value="co2" {{ old('type') == 'co2' ? 'selected' : '' }}>Carbon Dioxide (CO₂)</option>
                                                <option value="pressure" {{ old('type') == 'pressure' ? 'selected' : '' }}>Pressure</option>
                                                <option value="distance" {{ old('type') == 'distance' ? 'selected' : '' }}>Distance/Proximity</option>
                                                <option value="infrared" {{ old('type') == 'infrared' ? 'selected' : '' }}>Infrared (IR)</option>
                                                <option value="sound" {{ old('type') == 'sound' ? 'selected' : '' }}>Sound/Noise</option>
                                                <option value="ph" {{ old('type') == 'ph' ? 'selected' : '' }}>pH Level</option>
                                                <option value="water_level" {{ old('type') == 'water_level' ? 'selected' : '' }}>Water Level</option>
                                                <option value="gps" {{ old('type') == 'gps' ? 'selected' : '' }}>GPS/Location</option>
                                                <option value="current" {{ old('type') == 'current' ? 'selected' : '' }}>Current Sensor</option>
                                                <option value="voltage" {{ old('type') == 'voltage' ? 'selected' : '' }}>Voltage Sensor</option>
                                                <option value="magnetic" {{ old('type') == 'magnetic' ? 'selected' : '' }}>Magnetic Field</option>
                                                <option value="air_quality" {{ old('type') == 'air_quality' ? 'selected' : '' }}>Air Quality</option>
                                                <option value="soil_moisture" {{ old('type') == 'soil_moisture' ? 'selected' : '' }}>Soil Moisture</option>
                                                <option value="uv" {{ old('type') == 'uv' ? 'selected' : '' }}>UV Radiation</option>
                                                <option value="rfid" {{ old('type') == 'rfid' ? 'selected' : '' }}>RFID/NFC</option>
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
                                                    <input class="form-check-input" type="radio" name="pin" id="pin{{ $i }}" value="{{ $i }}" {{ old('pin') == $i ? 'checked' : '' }} required>
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
                                        <button type="submit" class="btn btn-primary"><i class="bi bi-plus-lg me-2"></i>Create Sensor</button>
                                    </div>
                                </form>

                            </div>
                        </div>        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmDeleteSensor" tabindex="-1" aria-labelledby="confirmDeleteSensorLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteSensorLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete sesnor for device <strong><span id="sensor"></span></strong>? This action CANNOT be undone!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" action="" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- show Sensor Modal -->
<div class="modal fade" id="showModalSensor" tabindex="-1" aria-labelledby="confirmDeleteSensorLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteSensorLabel">More About this.getAttribute('data-id')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete sesnor for device <strong><span id="sensor"></span></strong>? This action CANNOT be undone!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" action="" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const deleteButtons = document.querySelectorAll('[data-bs-target="#confirmDeleteSensor"]');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const sensorId = this.getAttribute('data-id');
            const sensorTitle = this.getAttribute('data-title');
            const formAction = `/sensors/${sensorId}`;
            document.getElementById('deleteForm').action = formAction;
            document.getElementById('sensor').textContent = sensorTitle;
        });
    });
</script>

@endsection