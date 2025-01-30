@extends('partials.layouts.app')

@section('title', 'Account Settings - Project IOT')

@section('content')

@include('_message')

<div class="pagetitle">
    <h1>Account Settings</h1>
    <nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home')}}">Home</a></li>
        <li class="breadcrumb-item active">Account Settings</li>
    </ol>
    </nav>
</div><!-- End Page Title -->


<section class="section profile">
    <div class="row">
        <div class="card">
            <div class="card-body pt-3">
                <!-- Bordered Tabs -->
                <ul class="nav nav-tabs nav-tabs-bordered">
                    
                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Settings</button>
                    </li>

                </ul>

                <div class="tab-content pt-2">
                    <div class="tab-pane fade pt-3 show active" id="profile-change-password">
                        <form action="{{ route('password.change') }}" method="POST">
                            @csrf

                            <div class="row mb-3">
                                <label for="currentPassword" class="col-md-4 col-lg-6 col-form-label">Current Password</label>
                                <div class="col-md-8 col-lg-6">
                                    <input name="current_password" type="password" class="form-control" id="currentPassword">
                                    @error('current_password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="newPassword" class="col-md-4 col-lg-6 col-form-label">New Password</label>
                                <div class="col-md-8 col-lg-6">
                                    <input name="new_password" type="password" class="form-control" id="newPassword">
                                    @error('new_password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="renewPassword" class="col-md-4 col-lg-6 col-form-label">Re-enter New Password</label>
                                <div class="col-md-8 col-lg-6">
                                    <input name="new_password_confirmation" type="password" class="form-control" id="renewPassword">
                                    @error('new_password_confirmation')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Change Password</button>
                            </div>
                        </form>
                    </div>

                    <div class="tab-pane fade pt-3" id="profile-settings">

                        <!-- Settings Form -->
                        <form>
                            <div class="row mb-4">
                                <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Email Notifications</label>
                                <div class="col-md-8 col-lg-9">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="changesMade" checked>
                                    <label class="form-check-label" for="changesMade">
                                        Changes made to your account
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="newProducts" checked>
                                    <label class="form-check-label" for="newProducts">
                                    Information on new products and services
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="proOffers">
                                    <label class="form-check-label" for="proOffers">
                                    Marketing and promo offers
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="securityNotify" checked disabled>
                                    <label class="form-check-label" for="securityNotify">
                                    Security alerts
                                    </label>
                                </div>
                                </div>
                            </div>

                            <div class="text-center mb-4">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form><!-- End settings Form -->

                    </div>
                </div><!-- End Bordered Tabs -->

            </div>
        </div>
    </div>
</section>


  @endsection