<?php

header('Content-Type: application/json');

$logFile = __DIR__ . '/abiaishu_visits.json';

// Get raw JSON input
$data = json_decode(file_get_contents('php://input'), true);

// Add server-side details
$entry = [
    'ip_address'  => $_SERVER['REMOTE_ADDR'],
    'user_agent'  => $_SERVER['HTTP_USER_AGENT'] ?? null,
    'visited_at'  => date('Y-m-d H:i:s'),
    'unique_id'   => $_SERVER['UNIQUE_ID'] ?? null,
    'details'     => $data,
];

// Load existing logs
$logs = [];
if (file_exists($logFile)) {
    $logs = json_decode(file_get_contents($logFile), true) ?? [];
}

// Append new entry
$logs[] = $entry;

// Save back to JSON file
file_put_contents(
    $logFile,
    json_encode($logs, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
);

echo json_encode(['status' => 'success']);

?>