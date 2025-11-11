<?php

// Load environment variables from .env file
require __DIR__ . '/env-loader.php';

return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Book Catalog',
    'smspilot' => [
        'apiKey' => getenv('SMSPILOT_API_KEY') ?: '',
        'apiUrl' => getenv('SMSPILOT_API_URL') ?: 'https://smspilot.ru/api.php',
    ],
];
