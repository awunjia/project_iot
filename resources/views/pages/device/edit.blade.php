@extends('partials.layouts.app')

@section('content')

<div class="pagetitle">
    <h1>All Devices</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('devices.index') }}">Devices</a></li>
            <li class="breadcrumb-item active">Edit Device</li>
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
                        <h5 class="card-title mb-0">Editting <strong>{{$device->name}}</strong> Device</h5>
                        <i class="bi bi-cpu ms-3"></i>
                    </span>
                    
                    <div class="col-12">
                        <form action="{{ route('devices.update', $device->id) }}" method="POST">
                            @csrf 
                            @method('PUT') 

                            <div class="row">
                                <div class="col-6 mt-3">
                                    <label for="name" class="form-label">Device Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $device->name) }}" required>
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-6 mt-3">
                                    <label for="location" class="form-label">Location <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="location" name="location" value="{{ old('location', $device->location) }}" required>
                                    @error('location')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-12 mt-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea style="height: 100px;" class="form-control" id="description" name="description">{{ old('description', $device->description) }}</textarea>
                                @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary"><i class="bi bi-pencil me-2"></i>Update Device</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection