<?php
// Save signup info with date
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $file = 'accounts-signup.json';

    if (!file_exists($file)) {
        file_put_contents($file, json_encode([], JSON_PRETTY_PRINT));
    }

    $accounts = json_decode(file_get_contents($file), true);
    if (!is_array($accounts)) $accounts = [];

    // Check if email already exists
    foreach ($accounts as $acc) {
        if ($acc['email'] === $email) {
            echo "Email already registered.";
            exit;
        }
    }

    // Add date/time of signup
    $date = date('Y-m-d H:i:s');

    $accounts[] = [
        'fullname' => $fullname,
        'email' => $email,
        'password' => $password,
        'date' => $date
    ];

    // Sort by signup date descending
    usort($accounts, function($a, $b) {
        return strtotime($b['date']) - strtotime($a['date']);
    });

    file_put_contents($file, json_encode($accounts, JSON_PRETTY_PRINT));
    echo "Signup successful!";
}
?>