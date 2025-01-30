<?php

return [
    'default' => [
        'host' => env('MQTT_HOST', 'localhost'), // MQTT broker host
        'port' => env('MQTT_PORT', 1883),        // MQTT broker port
        'username' => env('MQTT_USERNAME', ''),  // Optional: MQTT username
        'password' => env('MQTT_PASSWORD', ''),  // Optional: MQTT password
        'client_id' => env('MQTT_CLIENT_ID', 'laravel_mqtt_client'), // Unique client ID
        'clean_session' => true,                 // Clean session flag
        'keep_alive' => 60,                      // Keep-alive interval in seconds
        'protocol' => 'mqtt',                    // MQTT protocol version
        'tls' => false,                          // Enable TLS (true/false)
        'ca_file' => null,                       // Path to CA file (for TLS)
        'cert_file' => null,                     // Path to client certificate (for TLS)
        'key_file' => null,                      // Path to client private key (for TLS)
    ],
];