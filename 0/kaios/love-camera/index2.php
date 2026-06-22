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
  /* Small buttons style for KaiOS */
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
    transition: background 0.3s;
  }
  .btn:hover {
    background: linear-gradient(45deg, #feb47b, #ff7e5f);
  }
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
<video id="video" autoplay></video><br/>
<canvas id="canvas"></canvas>

<div id="buttons">
  <button class="btn" id="captureBtn">📸 Capture</button>
  <button class="btn" id="downloadBtn" style="display:none;">⬇️ Save</button>
  <button class="btn" id="emojiBtn">😊 Emojis</button>
  <button class="btn" id="clearBtn">🧹 Clear</button>
</div>

<div id="settings">
  <label>Qty:
    <input type="number" id="emojiCount" min="1" max="20" value="5" style="width:40px; font-size:12px;"/>
  </label>
  <label>Size:
    <input type="number" id="emojiSize" min="10" max="100" value="30" style="width:50px; font-size:12px;"/>
  </label>
</div>

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
const downloadBtn = document.getElementById('downloadBtn');
const emojiBtn = document.getElementById('emojiBtn');
const clearBtn = document.getElementById('clearBtn');

const emojiCountInput = document.getElementById('emojiCount');
const emojiSizeInput = document.getElementById('emojiSize');

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

// Draw multiple emojis randomly
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
    ctx.fillText(emoji, pos.x, pos.y + emojiSize); // y adjusted for baseline
  }
}

// Capture image with emojis
captureBtn.onclick = () => {
  ctx.filter = currentFilter;
  ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
  drawEmojis();
  document.getElementById('downloadBtn').style.display = 'inline-block';
  updatePreview();
};

// Input emojis/names
emojiBtn.onclick = () => {
  const input = prompt('Write emojis or names (separated by space or comma):', '');
  if (input !== null && input.trim() !== '') {
    currentEmojis = input.trim();
  }
};

// Clear overlays
clearBtn.onclick = () => {
  currentEmojis = '';
};

// Save image
downloadBtn.onclick = () => {
  const dataURL = canvas.toDataURL('image/png');
  const a = document.createElement('a');
  a.href = dataURL;
  a.download = 'love_photo.png';
  document.body.appendChild(a);
  a.click();
  document.body.removeChild(a);
};

// Settings
emojiCountInput.onchange = () => { emojiQuantity = parseInt(emojiCountInput.value); };
emojiSizeInput.onchange = () => { emojiSize = parseInt(emojiSizeInput.value); };

// Filter buttons
document.querySelectorAll('#filterButtons .btn').forEach(btn => {
  btn.onclick = () => {
    currentFilter = btn.dataset.filter;
    updatePreview();
  };
});

function updatePreview() {
  ctx.filter = currentFilter;
  ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
  drawEmojis();
  ctx.filter = 'none';
}
</script>
</body>
</html>