@extends('partials.layouts.app')

@section('title', 'My Profile - Project IOT')

@section('content')

@include('_message')

<div class="pagetitle">
    <h1>My Profile</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">My Profile</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section profile">
    <div class="row">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body profile-card pt-5 d-flex flex-column align-items-center">
                    <img src="assets/img/avatar.png" alt="Profile" class="rounded-circle mt-3">
                    <h2>{{ $user->name }}</h2>
                    <h3>{{ $user->email }}</h3>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="card">
                <div class="card-body pt-3">
                    <!-- Bordered Tabs -->
                    <ul class="nav nav-tabs nav-tabs-bordered d-flex" id="borderedTabJustified">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                        </li>
                    </ul>

                    <div class="tab-content pt-2">
                        <div class="tab-pane fade show active profile-overview" id="profile-overview">
                            @foreach ([
                                'Phone' => $user->phone ?: '-',
                                'Gender' => ucfirst($user->gender) ?: '-',
                                'Address' => $user->address ?: '-',
                                'Joined On' => $user->created_at->format('jS M Y h:i A')
                            ] as $label => $value)
                                <div class="row mt-4">
                                    <div class="col-lg-3 col-md-4 label">{{ $label }}</div>
                                    <div class="col-lg-9 col-md-8">{{ $value }}</div>
                                </div>
                            @endforeach
                        </div>

                        <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                            <!-- Profile Edit Form -->
                            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf 
                                @method('PUT')

                                @foreach ([
                                    'avatar' => 'Profile Image',
                                    'name' => 'Name',
                                    'address' => 'Address',
                                    'phone' => 'Phone',
                                ] as $field => $label)
                                    <div class="row mb-3">
                                        <label for="{{ $field }}" class="col-md-4 col-lg-3 col-form-label">{{ $label }}</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input 
                                                name="{{ $field }}" 
                                                type="{{ $field === 'avatar' ? 'file' : 'text' }}" 
                                                class="form-control" 
                                                id="{{ $field }}" 
                                                value="{{ old($field, $user->$field) }}"
                                            >
                                            @error($field)
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                @endforeach

                                <div class="row mb-3">
                                    <label class="col-md-4 col-lg-3 col-form-label">Gender</label>
                                    <div class="col-md-8 col-lg-9 d-flex align-items-center">
                                        @foreach (['male', 'female', 'other'] as $gender)
                                            <div class="form-check me-3">
                                                <input 
                                                    type="radio" 
                                                    name="gender" 
                                                    id="{{ $gender }}" 
                                                    value="{{ $gender }}" 
                                                    class="form-check-input" 
                                                    {{ old('gender', $user->gender) == $gender ? 'checked' : '' }}
                                                >
                                                <label for="{{ $gender }}" class="form-check-label">{{ ucfirst($gender) }}</label>
                                            </div>
                                        @endforeach
                                        @error('gender')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form><!-- End Profile Edit Form -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection