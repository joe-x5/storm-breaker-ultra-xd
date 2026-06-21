<?php
// total-visits.php

// Initialize total visits
$totalVisitsFile = 'total-visits.json';
if (file_exists($totalVisitsFile)) {
    $totalVisitsData = json_decode(file_get_contents($totalVisitsFile), true);
    $totalVisits = $totalVisitsData['totalVisits'] + 1;
} else {
    $totalVisits = 1;
}

// Update total visits
file_put_contents($totalVisitsFile, json_encode(['totalVisits' => $totalVisits]));

// Initialize daily visits
$dailyVisitsFile = 'daily-visits.json';
if (file_exists($dailyVisitsFile)) {
    $dailyVisitsData = json_decode(file_get_contents($dailyVisitsFile), true);
} else {
    $dailyVisitsData = [];
}

$today = date('Y-m-d');
$ip = $_SERVER['REMOTE_ADDR'];

// Get the name of the day for today
$dayName = date('l');

// Check if today's date exists in daily visits
if (!isset($dailyVisitsData[$today])) {
    $dailyVisitsData[$today] = [$dayName => []]; // Create a new array for the day
}

// Increment the visit count for the IP address
if (isset($dailyVisitsData[$today][$dayName][$ip])) {
    $dailyVisitsData[$today][$dayName][$ip]++;
} else {
    $dailyVisitsData[$today][$dayName][$ip] = 1;
}

// Sort dates in descending order
uksort($dailyVisitsData, function($a, $b) {
    return strtotime($b) - strtotime($a);
});

// Update daily visits
file_put_contents($dailyVisitsFile, json_encode($dailyVisitsData, JSON_PRETTY_PRINT));
?>

<?php
// Set the path for your JSON file
$jsonFilePath = 'traffic_data.json';

// Get the referrer
$referrer = isset($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST) : 'Direct Access';
$currentDate = date("Y-m-d");

// Load existing traffic data
if (file_exists($jsonFilePath)) {
    $existingData = json_decode(file_get_contents($jsonFilePath), true);
    if (!is_array($existingData)) {
        $existingData = []; // Initialize as an empty array if there was an issue
    }
} else {
    $existingData = []; // Create an empty array if file does not exist
}

// Check if today's date already exists in the data
if (!isset($existingData[$currentDate])) {
    $existingData[$currentDate] = []; // Initialize the date entry if it doesn't exist
}

// Check if the referrer already exists for today
if (isset($existingData[$currentDate][$referrer])) {
    // Increment visit count from this referrer for today
    $existingData[$currentDate][$referrer]['visits'] += 1;
} else {
    // Initialize visit count for this referrer for today
    $existingData[$currentDate][$referrer] = ['visits' => 1];
}

// Sort the data so that the newest dates come first
krsort($existingData);

// Save updated data to JSON file
file_put_contents($jsonFilePath, json_encode($existingData, JSON_PRETTY_PRINT));

// Output success message (or you can simply redirect or show the website content)
echo "";
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Update</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
      background: #ffffff;
      color: #000;
      font-size: 12px;
      line-height: 1.4;
    }

    .container {
      padding: 8px 10px;
    }

    h1 {
      font-size: 16px;
      color: #0066cc;
      text-align: center;
      margin: 5px 0;
    }

    p.intro {
      text-align: center;
      font-weight: 500;
      margin: 6px 0;
    }

    .android-support {
      background: #d9f8df;
      color: #2a7c4d;
      text-align: center;
      padding: 5px;
      border-radius: 5px;
      font-weight: bold;
      margin: 5px 0;
    }

    ul {
      margin: 8px 0;
      padding-left: 18px;
    }

    ul li {
      margin-bottom: 5px;
    }

    ul li::before {
      content: "✔ ";
      color: #0066cc;
      font-weight: bold;
    }

    .double-check::before {
      content: "✔✔ ";
      color: #0066cc;
    }

    .note {
      text-align: center;
      margin-top: 10px;
      font-style: italic;
      color: #333;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>🎉 New Update Released!</h1>
    <p class="intro">ChatWave App just got better:</p>

    <div class="android-support">📱 Now fully supported on Android too!</div>

    <ul>
      <li>Sign up/login improved</li>
      <li>Search improved</li>
      <li>You Don't need to use your own email/Gmail.</li>
      <li>Use Our Email for Create Account or Login.</li>
      <li>already added email and password, Just enter and and login and signup, don't need waste time</li>
      <li>Faster app loading</li>
      <li>Profile picture feature added</li>
      <li>Some issues fixed</li>
      <li class="double-check">Blue ✔✔ for seen</li>
      <li>✔ for delivered/sent</li>
      <li>Message stability improved</li>
      <li>Lighter and easier to use</li>
       <li>Long Press 5 Button to Magic Animation.</li>
    <li>If you want use Chatwave on Your Mobile or Laptop then Visit on : https://chatwavekaios.iblogger.org</li>
    </ul>

    <p class="note">➡️ Press Enter to open app</p>
  </div>


<div class="android-support">Update Coming Soon...</div>


    <ul>
      <li>Thank you for your suggestions. Adding unseen message count, hiding blocked users from the chat list, and adding bio and gender in the profile are all good ideas. I will try to include these features in future updates.
</li>


      <li>Currently I am a bit busy with my exams, so development may be a little slow. But I really appreciate your feedback and support for ChatWave.</li>

      <li>I developed ChatWave alone in my free time. Currently I am also busy with exams, so development may be a bit slow. If anyone enjoys the app and would like to support its development, small donations are always appreciated. It helps me spend more time improving the app.</li>
     
 <li>Thank you for the suggestion. The idea about restricting 18+ users from messaging 13+ users (unless enabled in settings) is a very good safety feature.</li>


      <li>Thanks for using the app 🙂</li>

    </ul>

  <script>
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Enter') {
        window.location.href = 'main.php';
      }
    });
  </script>


<script src="falling.js"></script>


</body>
</html>
