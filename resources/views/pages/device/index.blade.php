@extends('partials.layouts.app')

@section('title', 'Devices - Project IOT')

@section('content')

<div class="pagetitle">
    <h1>All Devices</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Devices</li>
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
                        <h5 class="card-title mb-0">Showing All Active Devices</h5>
                        <i class="bi bi-cpu ms-3"></i>
                    </span>
                    
                    <!-- Default Tabs -->
                    <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link w-100 active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">All Devices</button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link w-100" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Create New Device</button>
                        </li>
                    </ul>

                    <div class="tab-content pt-2" id="myTabContent">
                        
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            @if($devices->isEmpty())
                                <div class="text-center my-5 text-warning">
                                    <span>No device found!</span>
                                </div>
                            @else
                                <table class="table table-striped table-responsive">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Location</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Created On</th>
                                            <th scope="col">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($devices as $index => $device)
                                            <tr>
                                                <th scope="row">{{ $index + 1 }}</th>
                                                <td>{{ $device->name }}</td>
                                                <td>{{ $device->location }}</td>
                                                <td>{{ $device->description }}</td>
                                                <td>{{ $device->created_at->format('jS M Y') }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{ $device->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="bi bi-ellipsis-v"></i>
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $device->id }}">
                                                            <li>
                                                                <a class="dropdown-item" href="{{ route('devices.edit', $device->id) }}">
                                                                    <i class="bi bi-pen text-primary"></i> Edit Device
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#confirmDeleteDevice" 
                                                                    data-id="{{ $device->id }}" data-title="{{ $device->name }}">
                                                                    <i class="bi bi-trash text-danger"></i> Delete Device
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
                                    {{ $devices->links('vendor.pagination.bootstrap-5') }}
                                </div>
                            @endif
                        </div>

                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="col-12">
                                <form action="{{ route('devices.store') }}" method="POST">
                                    @csrf 

                                    <div class="row">
                                        <div class="col-6 mt-3">
                                            <label for="name" class="form-label">Device Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="name" name="name" required>
                                            @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-6 mt-3">
                                            <label for="location" class="form-label">Location <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="location" name="location" required>
                                            @error('location')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-12 mt-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea style="height: 100px;" class="form-control" id="description" name="description"></textarea>
                                        @error('description')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-primary"><i class="bi bi-plus-lg me-2"></i>Create Device</button>
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
<div class="modal fade" id="confirmDeleteDevice" tabindex="-1" aria-labelledby="confirmDeleteDeviceLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteDeviceLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete <strong><span id="device"></span></strong>? This action CANNOT be undone!
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
    const deleteButtons = document.querySelectorAll('[data-bs-target="#confirmDeleteDevice"]');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const deviceId = this.getAttribute('data-id');
            const deviceTitle = this.getAttribute('data-title');
            const formAction = `/devices/${deviceId}`;
            document.getElementById('deleteForm').action = formAction;
            document.getElementById('device').textContent = deviceTitle;
        });
    });
</script>

@endsection