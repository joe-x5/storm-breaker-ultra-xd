<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Feel Vibration</title>
<style>
  /* Basic Reset & Styling */
  body {
    font-family: Arial, sans-serif;
    background-color: #ffe6f0;
    margin: 0;
    padding: 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  h1 {
    font-size: 1.5em;
    color: #d6336c;
    margin-bottom: 20px;
    text-align: center;
  }

  /* Grid of feeling buttons (2 columns) */
  .feelGrid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    margin: 10px;
    width: 220px;
    margin-bottom: 20px;
  }

  /* Feel buttons style */
  .feel-btn {
    padding: 12px;
    font-size: 0.9em;
    border: none;
    border-radius: 4px;
    background-color: #ff69b4;
    color: #fff;
    cursor: pointer;
    transition: background-color 0.3s, box-shadow 0.2s;
  }
  .feel-btn:focus {
    outline: none;
    box-shadow: 0 0 4px #d6336c;
  }
  .feel-btn:hover {
    background-color: #ff85c1;
  }

  /* Control buttons container */
  #controls {
    display: flex;
    gap: 10px;
  }

  /* Style for control buttons */
  .control-btn {
    padding: 12px 16px;
    font-size: 1em;
    border: none;
    border-radius: 4px;
    background-color: #6a0dad;
    color: #fff;
    cursor: pointer;
    transition: background-color 0.3s, box-shadow 0.2s;
  }
  .control-btn:focus {
    outline: none;
    box-shadow: 0 0 4px #4b0082;
  }
  .control-btn:hover {
    background-color: #8a2be2;
  }
</style>
</head>
<body>

<h1>Feel Vibration</h1>

<!-- Grid of Feeling Buttons -->
<div class="feelGrid">


 <button class="feel-btn" id="horny">🔥 Horny</button>

  <button class="feel-btn" id="crying">😭 Crying</button>
  <button class="feel-btn" id="hardcore">🤘 Hardcore</button>
  <button class="feel-btn" id="heaven">😇 Heaven</button>
  <button class="feel-btn" id="hell">😈 Hell</button>
  <button class="feel-btn" id="alone">😔 Alone</button>
  <button class="feel-btn" id="night">🌙 Night</button>
  <button class="feel-btn" id="bed">🛏️ Bed</button>
  <button class="feel-btn" id="excited">🎉 Excited</button>
  <button class="feel-btn" id="relaxed">😌 Relaxed</button>
  <button class="feel-btn" id="stop">Stop</button>
  <!-- Add more feelings if needed -->


</div>



  
  <script>var vibrate=document.getElementById("horny");if(vibrate){vibrate.onclick=function(){navigator.vibrate(1000);};}</script> 
  
  
  
  
  
  <script>var vibrate=document.getElementById("hell");if(vibrate){vibrate.onclick=function(){navigator.vibrate([500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,500,]);};}</script>  
  
  
  
  <script>var vibrate=document.getElementById("hardcore");if(vibrate){vibrate.onclick=function(){navigator.vibrate(15000000000000000000);};}</script> 


 <script>var vibrate=document.getElementById("stop");if(vibrate){vibrate.onclick=function(){navigator.vibrate(0);};}</script>  


</body>
</html>