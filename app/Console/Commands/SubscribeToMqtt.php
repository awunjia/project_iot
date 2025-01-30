<?php

// app/Console/Commands/SubscribeToMqtt.php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;
use App\Models\SensorReading;

class SubscribeToMqtt extends Command
{
    protected $signature = 'mqtt:subscribe';
    protected $description = 'Subscribe to MQTT topics';

    public function handle()
    {
        // MQTT broker details
        $server = env('MQTT_HOST', 'localhost'); // MQTT broker host
        $port = env('MQTT_PORT', 1883);         // MQTT broker port
        $clientId = 'laravel_mqtt_subscriber';  // Unique client ID
        $username = env('MQTT_USERNAME', '');   // Optional: MQTT username
        $password = env('MQTT_PASSWORD', '');   // Optional: MQTT password

        // Initialize the MQTT client
        $mqtt = new MqttClient($server, $port, $clientId);

        // Configure connection settings
        $connectionSettings = (new ConnectionSettings)
            ->setUsername($username)
            ->setPassword($password)
            ->setKeepAliveInterval(60)
            ->setLastWillTopic('sensors/dht11/status')
            ->setLastWillMessage('disconnected')
            ->setLastWillQualityOfService(1);

        // Connect to the MQTT broker
        $mqtt->connect($connectionSettings, true);

        // Subscribe to topics
        $mqtt->subscribe('sensors/dht11/temperature', function ($topic, $message) {
            $this->saveSensorReading('temperature', $message);
        }, 0);

        $mqtt->subscribe('sensors/dht11/humidity', function ($topic, $message) {
            $this->saveSensorReading('humidity', $message);
        }, 0);

        // Start the loop to listen for messages
        $mqtt->loop(true);
    }

    private function saveSensorReading($type, $value)
    {
        SensorReading::create([
            'sensor_id' => 1, // Replace with your sensor ID
            $type => $value,
            'reading_time' => now(),
        ]);

        $this->info("$type: $value");
    }
}