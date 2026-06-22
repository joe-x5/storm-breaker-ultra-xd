<?php
// Save as "love_camera_fixed.php"
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Love Camera Fixed for KaiOS</title>
<style>
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #74ebd5, #ACB6E5);
    color: #fff;
    margin: 0;
    padding: 5px;
    font-size: 14px;
  }
  h1 {
    font-size: 1.2em;
    margin: 5px 0;
  }
  #video {
    width: 100%;
    max-width: 300px;
    height: auto;
    border-radius: 5px;
    border: 1px solid #fff;
  }
  #canvas { display: none; }
  /* Buttons styling with focus effects and additional effects */
  .btn {
    display: inline-block;
    padding: 4px 8px;
    margin: 4px;
    font-size: 0.8em;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    background: linear-gradient(45deg, #ff7e5f, #feb47b);
    color: #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    transition: background 0.3s, box-shadow 0.3s, filter 0.3s;
  }
  .btn:focus {
    outline: none;
    box-shadow: 0 0 10px 3px #fff inset, 0 2px 4px rgba(0,0,0,0.2);
  }
  /* Effects classes for visual effects */
  .effect-blur { filter: blur(2px); }
  .effect-rgb { filter: sepia(1) saturate(5) hue-rotate(180deg); }
  .effect-rainbow { background: linear-gradient(60deg, red, orange, yellow, green, blue, indigo, violet); -webkit-background-clip: text; color: transparent; animation: rainbow 3s linear infinite; }
  @keyframes rainbow {
    0% {background-position: 0%;}
    100% {background-position: 100%;}
  }
  .effect-love { filter: hue-rotate(90deg); }
  #buttons {
    margin-top: 5px;
    text-align: center;
  }
  #settings {
    margin-top: 5px;
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
  }
  #settings label {
    margin: 2px 4px;
  }
  #filterButtons {
    margin-top: 5px;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
  }
  #filterButtons .btn {
    padding: 4px 6px;
  }
</style>
</head>
<body>
<h1>Love Camera Fixed</h1>

<!-- Camera container -->
<div id="cameraContainer">
  <video id="video" autoplay></video>
</div>

<!-- Canvas for capturing images -->
<canvas id="canvas"></canvas>

<!-- Image preview after capture -->
<div id="previewContainer" style="display:none; flex-direction:column; align-items:center;">
  <img id="capturedImage" src="" style="max-width:100%; border-radius:5px; margin-top:10px;" />
  <div style="margin-top:10px;">
    <button class="btn" id="retakeBtn">🔄 Retake</button>
    <button class="btn" id="saveBtn" style="display:none;">⬇️ Save</button>
  </div>
</div>

<!-- Controls -->
<div id="buttons">
  <button class="btn" id="captureBtn">📸 Capture</button>
  <button class="btn" id="emojiBtn">😊 Emojis</button>
  <button class="btn" id="clearBtn">🧹 Clear</button>
</div>

<!-- Emoji settings -->
<div id="settings">
  <label>Qty:
    <input type="number" id="emojiCount" min="1" max="20" value="5" style="width:40px; font-size:12px;"/>
  </label>
  <label>Size:
    <input type="number" id="emojiSize" min="10" max="100" value="30" style="width:50px; font-size:12px;"/>
  </label>
</div>

<!-- Filter buttons -->
<div id="filterButtons">
  <button class="btn" data-filter="none">No Filter</button>
  <button class="btn" data-filter="grayscale(100%)">Gray</button>
  <button class="btn" data-filter="sepia(100%)">Sepia</button>
  <button class="btn" data-filter="invert(100%)">Invert</button>
  <button class="btn" data-filter="contrast(200%)">High Contrast</button>
  <button class="btn" data-filter="blur(2px)">Blur</button>
</div>

<script>
const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const ctx = canvas.getContext('2d');

const captureBtn = document.getElementById('captureBtn');
const retakeBtn = document.getElementById('retakeBtn');
const saveBtn = document.getElementById('saveBtn');
const emojiBtn = document.getElementById('emojiBtn');
const clearBtn = document.getElementById('clearBtn');

const emojiCountInput = document.getElementById('emojiCount');
const emojiSizeInput = document.getElementById('emojiSize');

const capturedImage = document.getElementById('capturedImage');
const previewContainer = document.getElementById('previewContainer');

let currentEmojis = '';
let emojiQuantity = parseInt(emojiCountInput.value);
let emojiSize = parseInt(emojiSizeInput.value);
let currentFilter = 'none';

navigator.mediaDevices.getUserMedia({ video: true }).then(stream => {
  video.srcObject = stream;
}).catch(() => {
  alert('Camera access denied or not available.');
});

// Utility: random position within canvas
function getRandomPos() {
  return {
    x: Math.random() * (canvas.width - emojiSize),
    y: Math.random() * (canvas.height - emojiSize)
  };
}

// Draw emojis on canvas
function drawEmojis() {
  const emojis = currentEmojis.split(/[\s,]+/).filter(t => t !== '');
  if (emojis.length === 0) return;
  for (let i=0; i<emojiQuantity; i++) {
    const emoji = emojis[Math.floor(Math.random() * emojis.length)];
    const pos = getRandomPos();
    ctx.font = emojiSize + 'px Arial';
    ctx.fillStyle = 'white';
    ctx.shadowColor = 'black';
    ctx.shadowBlur = 4;
    ctx.fillText(emoji, pos.x, pos.y + emojiSize);
  }
}

// Capture photo
captureBtn.onclick = () => {
  // Set canvas size to video
  canvas.width = video.videoWidth;
  canvas.height = video.videoHeight;
  ctx.filter = currentFilter;
  ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
  drawEmojis();
  // Show preview
  const dataUrl = canvas.toDataURL('image/png');
  capturedImage.src = dataUrl;
  previewContainer.style.display = 'flex';
  document.getElementById('cameraContainer').style.display = 'none';
  // Show save button
  saveBtn.style.display = 'inline-block';
};

retakeBtn.onclick = () => {
  previewContainer.style.display = 'none';
  document.getElementById('cameraContainer').style.display = 'block';
};

// Save function
saveBtn.onclick = () => {
  const dataURL = canvas.toDataURL('image/png');
  const a = document.createElement('a');
  a.href = dataURL;
  a.download = 'love_photo.png';
  document.body.appendChild(a);
  a.click();
  document.body.removeChild(a);
};

// Emoji button
emojiBtn.onclick = () => {
  const input = prompt('Write emojis or names (separated by space or comma):', '');
  if (input !== null && input.trim() !== '') {
    currentEmojis = input.trim();
  }
};

// Clear emojis
clearBtn.onclick = () => {
  currentEmojis = '';
};

// Settings
emojiCountInput.onchange = () => { emojiQuantity = parseInt(emojiCountInput.value); };
emojiSizeInput.onchange = () => { emojiSize = parseInt(emojiSizeInput.value); };

// Filter effects
document.querySelectorAll('#filterButtons .btn').forEach(btn => {
  btn.onclick = () => {
    currentFilter = btn.dataset.filter;
  };
});

// Draw emojis dynamically on the captured image
function drawEmojis() {
  const emojis = currentEmojis.split(/[\s,]+/).filter(t => t !== '');
  if (emojis.length === 0) return;
  for (let i=0; i<emojiQuantity; i++) {
    const emoji = emojis[Math.floor(Math.random() * emojis.length)];
    const pos = getRandomPos();
    ctx.font = emojiSize + 'px Arial';
    ctx.fillStyle = 'white';
    ctx.shadowColor = 'black';
    ctx.shadowBlur = 4;
    ctx.fillText(emoji, pos.x, pos.y + emojiSize);
  }
}
</script>
</body>
</html>