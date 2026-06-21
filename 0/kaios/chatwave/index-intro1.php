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
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>ChatWave Pro - KaiOS</title>
<style>
  body {
    margin: 0;
    padding: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #667eea, #764ba2);
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #fff;
  }

  .card {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 15px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    padding: 20px;
    width: 90%;
    max-width: 350px;
    backdrop-filter: blur(10px);
    animation: fadeIn 1s ease-in-out;
  }

  @keyframes fadeIn {
    from {opacity: 0; transform: translateY(-20px);}
    to {opacity: 1; transform: translateY(0);}
  }

  h1 {
    font-size: 22px;
    text-align: center;
    margin-bottom: 10px;
  }

  p {
    font-size: 14px;
    text-align: center;
    margin-bottom: 20px;
  }

  .button-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
  }

  .btn {
    background: linear-gradient(135deg, #ff7e5f, #feb47b);
    padding: 10px;
    border-radius: 10px;
    text-align: center;
    font-size: 14px;
    font-weight: bold;
    cursor: pointer;
    box-shadow: 0 4px 6px rgba(0,0,0,0.2);
    transition: transform 0.2s, box-shadow 0.2s;
  }

  .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 12px rgba(0,0,0,0.3);
  }

  .footer {
    margin-top: 20px;
    font-size: 12px;
    text-align: center;
  }

  /* Highlight selected button for key navigation */
  .selected {
    outline: 3px solid #fff;
    outline-offset: -4px;
  }
</style>
</head>
<body>

<div class="card" id="menu">
  <h1>🤖 ChatWave Pro</h1>
  <p>Press number keys (1-6) to open apps<br/>or use arrow keys & Enter</p>
  <div class="button-grid">
  <div class="btn" id="btn0">ChatWave Pro</div>
    <div class="btn" id="btn1">1️⃣ PVT Chat 💬</div>
    <div class="btn" id="btn2">2️⃣ Global Chat 🌐</div>
    <div class="btn" id="btn3">3️⃣ Chat Batasa 🗣️</div>
    <div class="btn" id="btn4">4️⃣ Draw-IT 🎨</div>
    <div class="btn" id="btn5">5️⃣ AI Chatbot 🧠</div>
    <div class="btn" id="btn6">6️⃣ Exit 🚪</div>
  </div>
  <div class="footer">Use arrow keys & Enter or number keys for quick access</div>
</div>

<script>
  const buttons = [
    {id: 'btn0', url: 'main.php'},
    {id: 'btn1', url: 'https://x0.rf.gd/a/pvtchat/'},
    {id: 'btn2', url: 'https://wxfire.yzz.me/tools/kaios/apps/global-chat/'},
    {id: 'btn3', url: 'https://chat-max-all.blogspot.com/2025/04/chat-batasa.html'},
    {id: 'btn4', url: 'https://vivekgyan7.rf.gd/tools/kaios/apps/Draw-IT/'},
    {id: 'btn5', url: 'https://vivekgyan7.rf.gd/tools/kaios/apps/AI_Chatbot/'},
    {id: 'btn6', url: 'exit'}
  ];

  let currentIndex = 0;

  function highlightButton(index) {
    buttons.forEach((btn, i) => {
      const element = document.getElementById(btn.id);
      if(i === index) {
        element.classList.add('selected');
      } else {
        element.classList.remove('selected');
      }
    });
  }

  function activateButton(index) {
    const btn = buttons[index];
    if(btn.url === 'exit') {
      alert('👋 Goodbye! Closing...');
      // You can add code to close app if supported
    } else {
      window.location.href = btn.url;
    }
  }

  document.addEventListener('keydown', (e) => {
    if(e.key === 'ArrowRight') {
      currentIndex = (currentIndex + 1) % buttons.length;
      highlightButton(currentIndex);
    } else if(e.key === 'ArrowLeft') {
      currentIndex = (currentIndex - 1 + buttons.length) % buttons.length;
      highlightButton(currentIndex);
    } else if(e.key === 'ArrowDown') {
      // optional: move down
    } else if(e.key === 'ArrowUp') {
      // optional: move up
    } else if(e.key === 'Enter') {
      activateButton(currentIndex);
    } else if(e.key >= '1' && e.key <= '6') {
      currentIndex = parseInt(e.key) -1;
      highlightButton(currentIndex);
      activateButton(currentIndex);
    }
  });

  // initial highlight
  highlightButton(currentIndex);
</script>

</body>
</html>