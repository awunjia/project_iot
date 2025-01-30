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
    <style>
    .gauge-card { /* Fixed typo */
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        padding: 5px;
    }
    .gauge {
        width: 300px;  /* Increased size */
        height: 300px; /* Increased size */
        margin: 20px;  /* Spacing between gauges */
    }
</style>

<div class="pagetitle">
    <h1>Sensor Chart</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home')}}">Home</a></li>
            <li class="breadcrumb-item active">Sensor Data</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<div class="container">
    <div class="card">
        <div class="card-title text-center">
            @foreach($sensorData as $data)
            <h6 class="text-secondary">Showing Sensor Data for <strong class="text-primary">{{ $data->sensor->device->name }} ({{ $data->sensor->name }})</strong></h6>
            @endforeach
        </div>

    </div>
</div>

<div class="container">
    <div class="card gauge-card my-3"> 
        <div class="card-body">
            <div class="row">
                <div id="tempGauge" class="gauge"></div>
                <div id="humidityGauge" class="gauge"></div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <canvas id="sensorChart" width="400" height="200"></canvas>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://www.gstatic.com/charts/loader.js"></script>
<script>
    const ctx = document.getElementById('sensorChart').getContext('2d');
    const maxDataPoints = 20; // Set the maximum number of data points to display
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'Temperature',
                data: [],
                borderColor: 'red',
                fill: false
            }, {
                label: 'Humidity',
                data: [],
                borderColor: 'blue',
                fill: false
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    google.charts.load('current', { 'packages': ['gauge'] });
    google.charts.setOnLoadCallback(initGauges);

    let tempGauge, humidityGauge;

    function initGauges() {
        tempGauge = new google.visualization.Gauge(document.getElementById('tempGauge'));
        humidityGauge = new google.visualization.Gauge(document.getElementById('humidityGauge'));
        drawGauges(0, 0); // Initial draw
    }

    function drawGauges(temp, humidity) {
        const data = google.visualization.arrayToDataTable([
            ['Label', 'Value'],
            ['Temperature', temp],
            ['Humidity', humidity]
        ]);

        tempGauge.draw(data, { 
            min: 0, max: 50, 
            greenFrom: 20, greenTo: 30, 
            yellowFrom: 30, yellowTo: 40, 
            redFrom: 40, redTo: 50 
        });
        humidityGauge.draw(data, { 
            min: 0, max: 100, 
            greenFrom: 30, greenTo: 70, 
            yellowFrom: 70, yellowTo: 90, 
            redFrom: 90, redTo: 100 
        });
    }

    function generateRandomData() {
        const temperature = Math.floor(Math.random() * 51); // Random temp between 0 and 50
        const humidity = Math.floor(Math.random() * 101);    // Random humidity between 0 and 100
        return { temperature, humidity };
    }

    function updateGraphAndGauges() {
        const data = generateRandomData();
        const currentTime = new Date().toLocaleTimeString();

        // Update chart data
        if (chart.data.labels.length >= maxDataPoints) {
            chart.data.labels.shift(); // Remove the first (oldest) label
            chart.data.datasets[0].data.shift(); // Remove the first (oldest) temperature data point
            chart.data.datasets[1].data.shift(); // Remove the first (oldest) humidity data point
        }

        chart.data.labels.push(currentTime); // Add new label
        chart.data.datasets[0].data.push(data.temperature); // Add new temperature data
        chart.data.datasets[1].data.push(data.humidity); // Add new humidity data
        chart.update();
        
        drawGauges(data.temperature, data.humidity);
    }

    // Simulate data every 2 seconds
    setInterval(updateGraphAndGauges, 2000);
</script>

@endsection