@extends('partials.layouts.app')

@section('title', 'Dashboard - Project IOT')

@section('content')
<div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home')}}">Home</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
    <div class="container p-3">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="box">
                        <div class="text-primary">
                            <i class="bi bi-cpu" style="font-size: 50px;"></i>
                        </div>
                        <h5>@if($device <= 1) Device @else Devices @endif</h5>
                        <div class="count">{{ $device }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="box">
                        <div class="text-primary">
                            <i class="bi bi-thermometer-half" style="font-size: 50px;"></i>
                        </div>
                        <h5>@if($sensor->count() <= 1) Sensor @else Sensors @endif</h5>
                        <div class="count">{{ $sensor->count() }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="box">
                        <div class="text-primary">
                            <i class="bi bi-cloud-arrow-down" style="font-size: 50px;"></i>
                        </div>
                        <h5>Storage</h5>
                        <div class="count">5 GB</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="box">
                        <div class="text-primary">
                            <i class="bi bi-broadcast" style="font-size: 50px;"></i>
                        </div>
                        <h5>Streaming</h5>
                        <div class="count">0</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

  @endsection