@extends('partials.layouts.app')

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
                                            <th scope="col">Sensor Type</th>
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
                                                                <a class="dropdown-item" href="{{ route('sensors.edit', $sensor->id) }}">
                                                                    <i class="bi bi-pen text-primary"></i> Edit Sensor
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

                                    <div class="row  my-5">
                                        <div class="col-6">
                                            <label for="device_id" class="form-label">Device <span class="text-danger">*</span></label>
                                            <select name="device_id" id="device_id" class="form-select" required>
                                                <option value="" selected disabled>Select a Device</option>
                                                @foreach($devices as $device)
                                                    <option value="{{ $device->id }}">{{ $device->name }} ({{ $device->location }})</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-6">
                                            <label for="type" class="form-label">Sensor Type <span class="text-danger">*</span></label>
                                            <select name="type" id="type" class="form-select" required>
                                                <option value="" selected disabled>Select Sensor Type</option>
                                                <option value="temperature">Temperature</option>
                                                <option value="temphum">Temphum</option>
                                                <option value="motion">Motion</option>
                                                <option value="light">Light</option>
                                                <option value="vibration">Vibration</option>
                                                <option value="smoke">Smoke</option>
                                                <option value="co_h2o">Co/H2O</option>
                                                <option value="humidity">Humidity</option>
                                                <option value="distance">Distance</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-12 my-5">
                                        <label for="pin" class="form-label">Select GPIO Pin<span class="text-danger">*</span></label>
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
                                    
                                    </div>

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