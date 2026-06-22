<?php
// Handle login or auto-register if not exists, update last login, IP, and count
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $file = 'accounts-login.json';

    // Load existing accounts or initialize array
    if (!file_exists($file)) {
        file_put_contents($file, json_encode([], JSON_PRETTY_PRINT));
    }

    $accounts = json_decode(file_get_contents($file), true);
    if (!is_array($accounts)) $accounts = [];

    // Function to get client's IP address
    function getClientIP() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }

    $client_ip = getClientIP();
    $current_time = date('Y-m-d H:i:s');

    $found = false;

    // Search for account by email
    foreach ($accounts as &$acc) {
        if ($acc['email'] === $email) {
            // If account exists, verify password
            if ($acc['password'] === $password) {
                // Update last login and IP
                $acc['last_login'] = $current_time;
                $acc['ip'] = $client_ip;

                // Increment login count
                if (isset($acc['login_count'])) {
                    $acc['login_count'] += 1;
                } else {
                    $acc['login_count'] = 1; // Initialize if not set
                }

                $found = true;
            } else {
                // Password mismatch
                echo "Invalid password.";
                exit;
            }
            break;
        }
    }

    if (!$found) {
        // Auto-create account if not found
        $accounts[] = [
            'email' => $email,
            'password' => $password,
            'date' => $current_time, // signup date
            'last_login' => $current_time,
            'ip' => $client_ip,
            'login_count' => 1 // First login
        ];
        $found = true; // Consider login successful after creation
    }

    // Save updated accounts to file
    file_put_contents($file, json_encode($accounts, JSON_PRETTY_PRINT));

    echo "Login successful!";
}
?>