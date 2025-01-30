@extends('partials.layouts.app')

@section('title', 'Select Target - Project IOT')

@section('content')

<style>
    .gauge-card {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        padding: 5px;
    }
    .gauge {
        width: 300px;
        height: 300px;
        margin: 20px;
    }
</style>

<div class="pagetitle">
    <h1>Select Target</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Select Target</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('data.show') }}" method="GET">
            <div class="row g-3 my-4">
                <div class="col-5">
                    <select id="deviceSelect" name="device_id" class="form-select">
                        <option selected disabled>Select a device...</option>
                        @foreach($devices as $device)
                            <option value="{{ $device->id }}">{{ $device->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-5">
                    <select id="sensorSelect" name="sensor_id" class="form-select" disabled>
                        <option selected disabled>Select a sensor...</option>
                    </select>
                </div>

                <div class="col-2">
                    <button type="submit" class="btn btn-primary" disabled id="viewDataBtn">View Data</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#deviceSelect').change(function() {
            const deviceId = $(this).val();
            $('#sensorSelect').empty().append('<option selected disabled>Select a sensor...</option>').prop('disabled', true);
            $('#viewDataBtn').prop('disabled', true);

            if (deviceId) {
                $.ajax({
                    url: `/my-sensors/${deviceId}`,
                    method: 'GET',
                    success: function(data) {
                        if (data.sensors.length > 0) {
                            data.sensors.forEach(sensor => {
                                $('#sensorSelect').append(`<option value="${sensor.id}">${sensor.name}</option>`);
                            });
                            $('#sensorSelect').prop('disabled', false);
                        }
                    }
                });
            }
        });

        $('#sensorSelect').change(function() {
            $('#viewDataBtn').prop('disabled', $(this).val() === null);
        });
    });
</script>

@endsection