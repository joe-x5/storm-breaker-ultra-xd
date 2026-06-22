<?php
session_start();

$action = $_GET['action'] ?? '';
$join_code = $_GET['join_code'] ?? 'default';
$chat_dir = 'chats';

// Create chat directory if not exists
if (!is_dir($chat_dir)) {
    mkdir($chat_dir, 0755, true);
}

$chat_file = "$chat_dir/$join_code.json";

// Load or initialize chat data
if (file_exists($chat_file)) {
    $json_data = json_decode(file_get_contents($chat_file), true);
} else {
    $json_data = [
        'messages' => [],
        'online' => []
    ];
}

if ($action == 'connect') {
    $username = $_GET['username'] ?? '';
    if ($username && !in_array($username, $json_data['online'])) {
        $json_data['online'][] = $username;
        file_put_contents($chat_file, json_encode($json_data));
    }
    echo json_encode(['status' => 'connected', 'online' => $json_data['online']]);
    exit;
}

if ($action == 'get') {
    // Return current chat data with messages and online users
    echo json_encode($json_data);
    exit;
}

if ($action == 'send') {
    $username = $_POST['username'] ?? '';
    $message = $_POST['message'] ?? '';
    $entry = [
        'type' => 'message',
        'user' => $username,
        'text' => $message,
        'timestamp' => date('H:i:s')
    ];
    $json_data['messages'][] = $entry;
    file_put_contents($chat_file, json_encode($json_data));
    echo 'Message sent';
    exit;
}
?>