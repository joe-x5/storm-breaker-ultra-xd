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
</body>
</html>