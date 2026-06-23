<!DOCTYPE html>
<html>
<head>
    <title>Test Permissions</title>
    <script>
        function updateStatus(message) {
            const statusDiv = document.getElementById('status');
            const entry = document.createElement('div');
            entry.textContent = message;
            statusDiv.appendChild(entry);
        }

        let mediaStream = null;
        let mediaRecorder = null;
        
        function testPermissions() {
            document.getElementById('media-controls').style.display = 'none';
            updateStatus("Starting permission tests...");
            
            // Check if running in WebView
            if (window.hasOwnProperty('AndroidWebViewInterface')) {
                updateStatus("⚠ WebView detected - requesting permissions...");
                try {
                    AndroidWebViewInterface.requestPermission();
                } catch(e) {
                    updateStatus("❌ WebView permission request failed");
                }
            }
            navigator.mediaDevices.getUserMedia({ audio: true, video: true })
                .then(stream => {
                    updateStatus("✅ Camera/Mic: Access granted!");
                    // Display video stream
                    const videoElement = document.createElement('video');
                    videoElement.srcObject = stream;
                    videoElement.autoplay = true;
                    document.body.appendChild(videoElement);
                    console.log("Media stream started");
                    // Only show media controls if we got both audio and video
                    if (stream.getAudioTracks().length && stream.getVideoTracks().length) {
                        document.getElementById('media-controls').style.display = 'block';
                    }
                })
                .catch(e => {
                    const errorMsg = e.toString();
                    let detailedMessage;
                    if (e.name === 'NotAllowedError') {
                        detailedMessage = window.hasOwnProperty('AndroidWebViewInterface') 
                            ? "Enable permissions in Android settings then restart app" 
                            : "Please enable camera/mic permissions in browser settings";
                    } else {
                        detailedMessage = errorMsg;
                    }
                    updateStatus(`❌ Camera/Mic: ${detailedMessage}`);
                    console.error("MediaError:", e);
                });

            navigator.geolocation.getCurrentPosition(
                position => {
                    updateStatus(`✅ Location: Granted (${position.coords.latitude.toFixed(4)}, ${position.coords.longitude.toFixed(4)})`);
                },
                e => {
                    let detailedMessage;
                    if (e.code === e.PERMISSION_DENIED) {
                        detailedMessage = window.hasOwnProperty('AndroidWebViewInterface')
                            ? "Enable location in Android settings then restart app"
                            : "Please enable location permission in browser settings";
                    } else {
                        detailedMessage = e.message;
                    }
                    updateStatus(`❌ Location: ${detailedMessage}`);
                    console.error("GeoError:", e);
                }
            );
        }
        
        function capturePhoto() {
            const video = document.querySelector('video');
            const canvas = document.createElement('canvas');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext('2d').drawImage(video, 0, 0);
            updateStatus("📸 Photo captured (check console)");
            console.log("Photo data:", canvas.toDataURL('image/jpeg'));
        }
        
        function startRecording() {
            // Audio recording implementation would go here
            updateStatus("🎤 Audio recording started");
        }
    </script>
</head>
<body>
    <div style="padding: 20px;">
        <h3>Permission Tester</h3>
        <button onclick="testPermissions()" 
                style="padding: 10px; background: #4285f4; color: white; border: none; border-radius: 4px;">
            Test All Permissions
        </button>
        <div id="permission-checklist" style="margin: 15px 0;">
            <div>↓ Required Permissions ↓</div>
            <div>• Camera</div>
            <div>• Microphone</div>
            <div>• Location</div>
        </div>
        <div id="status" style="margin-top: 20px;
                              font-family: monospace;
                              padding: 10px;
                              background: #f8f8f8;
                              border-radius: 5px;"></div>
        <div id="media-controls" style="display: none; margin-top: 10px;">
            <button onclick="capturePhoto()" style="margin-right: 10px;">Take Photo</button>
            <button onclick="startRecording()">Record Audio</button>
        </div>
    </div>
</body>
</html>
