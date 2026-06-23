<?php
session_start();

$action = $_GET['action'] ?? '';
$join_code = $_GET['join_code'] ?? '';

$chat_folder = 'chat_files/';
if (!is_dir($chat_folder)) {
    mkdir($chat_folder, 0755, true);
}
$chat_file = $chat_folder . $join_code . '.json';

if ($action == 'connect') {
    $username = $_GET['username'] ?? 'Anon';
    $data = file_exists($chat_file) ? json_decode(file_get_contents($chat_file), true) : ['messages'=>[], 'users'=>[], 'online_count'=>0];
    if (!in_array($username, $data['users'])) {
        $data['users'][]= $username;
        $data['online_count']= count($data['users']);
        $data['messages'][]= ['user'=>'(Bot 🤖)', 'msg'=>"Joined [ $username ]", 'time'=>date('H:i:s')];
        file_put_contents($chat_file, json_encode($data));
    }
    echo json_encode(['status'=>'connected','online'=>$data['online_count']]);
    exit;
}

if ($action == 'disconnect') {
    $username = $_GET['username'] ?? 'Anon';
    if (file_exists($chat_file)) {
        $data= json_decode(file_get_contents($chat_file), true);
        if (($k=array_search($username,$data['users']))!==false) {
            unset($data['users'][$k]);
            $data['users']= array_values($data['users']);
            $data['online_count']= count($data['users']);
            $data['messages'][]= ['user'=>'(Bot 🤖)', 'msg'=>"Left [ $username ]", 'time'=>date('H:i:s')];
            file_put_contents($chat_file, json_encode($data));
        }
    }
    echo 'ok'; exit;
}

if ($action=='message') {
    $username= $_POST['username'] ?? 'Anon';
    $msg= $_POST['message'] ?? '';
    $data= file_exists($chat_file) ? json_decode(file_get_contents($chat_file), true) : ['messages'=>[], 'users'=>[], 'online_count'=>0];
    $data['messages'][]= ['user'=>$username, 'msg'=>$msg, 'time'=>date('H:i:s')];
    file_put_contents($chat_file, json_encode($data));
    echo 'ok'; exit;
}

if ($action=='get') {
    $data= file_exists($chat_file) ? json_decode(file_get_contents($chat_file), true) : ['messages'=>[], 'users'=>[], 'online_count'=>0];
    $html= '';
    foreach ($data['messages'] as $m) {
        $usr= htmlspecialchars($m['user']);
        $txt= htmlspecialchars($m['msg']);
        $time= htmlspecialchars($m['time']);

        if($usr=='{Bot 🤖}') $color= '#888';
        elseif($usr==$_GET['username']) $color= '#2e8b57';
        else $color= '#1e90ff';

        $html.= "<div style='font-size:12px; margin:2px 0; color:$color;'><strong>$usr</strong>: $txt <span style='font-size:8px;'>($time)</span></div>";
    }
    echo json_encode(['chat'=>$html, 'online'=>$data['online_count']]);
    exit;
}

$page= $_GET['page'] ?? 'join';

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<title>Love Vibrator</title>
<style>
body {
  font-family: Arial, sans-serif;
  background:#ffe6f0;
  margin:0; padding:0;
  font-size:14px;
}



/* Style for the container div */
#container {
  padding: 20px;
  background-color: #ffffff; /* White background */
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Shadow effect */
  max-width: 300px;
  margin: auto;
}

/* Style for the heading */
#container h2 {
  font-size: 1.2em;
  color: #333;
  text-align: center;
  margin-bottom: 15px;
}

/* Style for labels */
#container label {
  display: block;
  margin-top: 10px;
  font-size: 0.9em;
  color: #555;
}

/* Style for input text box */
#join_code_input {
  width: 100%;
  padding: 8px 10px;
  margin-top: 5px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-shadow: inset 0 1px 3px rgba(0,0,0,0.1);
  font-size: 1em;
  box-sizing: border-box;
}

/* Style for select dropdown */
#type {
  width: 100%;
  padding: 8px 10px;
  margin-top: 5px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-shadow: inset 0 1px 3px rgba(0,0,0,0.1);
  font-size: 1em;
  box-sizing: border-box;
}

/* Default button style */
#joinBtn {
  width: 100%;
  padding: 10px;
  margin-top: 15px;
  background-color: #007BFF; /* Your preferred color */
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 1em;
  box-shadow: 0 2px 4px rgba(0,0,0,0.2);
  transition: background-color 0.3s ease, box-shadow 0.2s ease;
}

/* Hover state */
#joinBtn:hover {
  background-color: #0056b3; /* Darker shade for hover */
}

/* Focus state */
#joinBtn:focus {
  outline: none; /* Optional: remove default outline */
  box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.5); /* Blue glow for focus */
}


/* Header: small fixed at top, code left, online right */
#header {
  position: fixed;
  top: 0; left: 0; right: 0;
  height: 30px;
  background:#fff;
  display:flex;
  justify-content: space-between;
  align-items: center;
  padding: 0 8px;
  z-index: 1000;
  border-bottom: 1px solid #ccc;
  font-size:14px;
}
#header div {
  font-size:8px;
}
#header .left {
  flex:1;
  text-align:left;
}
#header .right {
  flex:1;
  text-align:right;
}
/* Chat container below header */
#chatContainer {
  margin-top: 40px;
  padding: 0 10px;
  height: calc(100vh - 90px);
  display:flex;
  flex-direction:column;
}
#chat {
  flex:1;
  overflow-y: auto;
  border:1px solid #d147a3;
  background:#fff;
  padding:4px;
  font-size:12px;
  border-radius:4px;
}




#bottom {
  position: fixed;
  bottom: 0; left: 0; right: 0;
  background:#fff;
  padding:6px 8px;
  display:flex;
  align-items:center;
  z-index: 1000;
  border-top: 1px solid #ccc;
 margin-bottom: 8px;
}

#bottom button, #bottom input {
  font-size:12px;
}

#messageInput {
  flex:1;
   max-width: 59%;
  margin:0 8px;
  padding:4px;
  border-radius:4px;
  border:1px solid #ccc;
}
</style>
</head>
<body>

<?php if($page=='join'): ?>



<div style="padding:20px;">
<h2>🔑 Join Love Vibrator</h2>
<label>Join Code:</label>
<input type="text" id="join_code_input" placeholder="Enter join code" />
<label>Type:</label>
<select id="type">
  <option value="local">📍 Local</option>
  <option value="remote">🌐 Remote</option>
</select>
<button id="joinBtn">🔗 Join</button>
</div>



<script>
window.onload= function() {
  if(!localStorage.getItem('username')){
    var uname= prompt("Enter your username:");
    if(uname) localStorage.setItem('username', uname);
  }
  alert("Join the chat.\nUse Vibrate button.\nPress SoftRight to exit.");
};
document.getElementById('joinBtn').onclick= function() {
  var code= document.getElementById('join_code_input').value.trim();
  if(!code){ alert('Enter join code'); return; }
  var username= localStorage.getItem('username');
  if(!username){
    var uname= prompt("Enter your username:");
    if(uname) localStorage.setItem('username', uname);
  }
  var xhr= new XMLHttpRequest();
  xhr.open('GET', '?page=love_vibrator&action=connect&join_code=' + encodeURIComponent(code) + '&username=' + encodeURIComponent(username), true);
  xhr.onreadystatechange= function() {
    if(xhr.readyState== 4 && xhr.status==200){
      var res= JSON.parse(xhr.responseText);
      if(res.status== 'connected'){
        localStorage.setItem('join_code', code);
        window.location.href= '?page=love_vibrator&join_code=' + encodeURIComponent(code);
      }
    }
  };
  xhr.send();
};
</script>
<?php elseif($page=='love_vibrator'): ?>
<!-- Header: code left, online right -->
<div id="header">
  <div class="left">Code: <?=htmlspecialchars($join_code)?></div>
  <div class="right">Online: <span id="online">0</span></div>
</div>
<!-- Chat area -->
<div id="chatContainer">
  <div id="chat"></div>
</div>
<!-- Bottom controls -->
<div id="bottom">
  <button id="vibrateBtn" title="Vibrate">🔊</button>
  <input type="text" id="messageInput" placeholder="Type message" />
  <button id="sendBtn">💬</button>
</div>

<script>
// Variables
const join_code='<?=htmlspecialchars($join_code)?>';
const username= localStorage.getItem('username')|| 'Anon';

// Update online
function updateOnline(count){ document.getElementById('online').innerText= count; }

// Fetch messages
function fetchMessages() {
  var xhr= new XMLHttpRequest();
  xhr.open('GET', '?page=love_vibrator&action=get&join_code=' + encodeURIComponent(join_code) + '&username=' + encodeURIComponent(username), true);
  xhr.onreadystatechange= function() {
    if(xhr.readyState== 4 && xhr.status== 200){
      var data= JSON.parse(xhr.responseText);
      document.getElementById('chat').innerHTML= data.chat;
      updateOnline(data.online);
      var chatDiv= document.getElementById('chat');
      chatDiv.scrollTop= chatDiv.scrollHeight; // auto scroll

      // Detect remote vibrate command
      var lines= data.chat.match(/<div[^>]*>.*?<\/div>/g) || [];
      for(let line of lines){
        if(line.includes('Vibrate:')){
          const match= line.match(/Vibrate:(\d+)/);
          if(match && match[1]){
            const t= parseInt(match[1]);
            if(navigator.vibrate){ navigator.vibrate(t); }
          }
        }
      }
    }
  };
  xhr.send();
}

// Start polling
function startPoll() {
  fetchMessages();
  setInterval(fetchMessages, 2000); // refresh every 2 sec
}

// Send message
function sendMsg() {
  const msg= document.getElementById('messageInput').value.trim();
  if(!msg){ return; }
  var xhr= new XMLHttpRequest();
  xhr.open('POST', '?page=love_vibrator&action=message&join_code=' + encodeURIComponent(join_code), true);
  xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
  xhr.onreadystatechange= function() {
    if(xhr.readyState== 4 && xhr.status== 200){
      document.getElementById('messageInput').value= '';
      fetchMessages();
    }
  };
  xhr.send('username=' + encodeURIComponent(username)+ '&message=' + encodeURIComponent(msg));
}

// Send vibrate command
document.getElementById('vibrateBtn').onclick= function() {
  const t= prompt("Vibrate for seconds:", "0.5");
  const sec= parseFloat(t);
  if(isNaN(sec)||sec<=0){ alert('Invalid'); return; }
  const ms= sec*1000;
  if(navigator.vibrate){ navigator.vibrate(ms); }
  sendVibrateMsg('Vibrate:' + sec);
  // Notify others
  var xhr= new XMLHttpRequest();
  xhr.open('GET', '?page=love_vibrator&action=vibrate&join_code=' + encodeURIComponent(join_code)+ '&time=' + encodeURIComponent(sec), true);
  xhr.send();
};

// Function to send remote vibrate message
function sendVibrateMsg(msg){
  var xhr= new XMLHttpRequest();
  xhr.open('POST', '?page=love_vibrator&action=message&join_code=' + encodeURIComponent(join_code), true);
  xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
  xhr.onreadystatechange= function() {
    if(xhr.readyState== 4 && xhr.status== 200){ fetchMessages(); }
  };
  xhr.send('username=' + encodeURIComponent(username)+ '&message=' + encodeURIComponent(msg));
}

// Send message
document.getElementById('sendBtn').onclick= sendMsg;
// Send on Enter
document.getElementById('messageInput').addEventListener('keydown', function(e){
  if(e.key==='Enter'){ sendMsg(); }
});

// Exit on SoftRight
document.addEventListener('keydown', function(e){
  if(e.key==='SoftRight'){
    var xhr= new XMLHttpRequest();
    xhr.open('GET', '?page=love_vibrator&action=disconnect&join_code=' + encodeURIComponent(join_code)+ '&username=' + encodeURIComponent(username), true);
    xhr.onreadystatechange= function() {
      if(xhr.readyState== 4 && xhr.status== 200){ window.location.href= '?page=join'; }
    };
    xhr.send();
  }
});

// Start polling
startPoll();
</script>
<?php endif; ?>
</body>
</html>