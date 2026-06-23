<?php
session_start();
include "./assets/components/login-arc.php";

// Check if login data cookie is set and valid
if (isset($_COOKIE['logindata']) && $_COOKIE['logindata'] === $key['token'] && $key['expired'] === "no") {
    // If session is not set, mark user as logged in
    if (!isset($_SESSION['IAm-logined'])) {
        $_SESSION['IAm-logined'] = 'yes';
    }
} elseif (isset($_SESSION['IAm-logined'])) {
    // Generate a new token and update the cookie
    $client_token = generate_token();
    setcookie("logindata", $client_token, time() + (86400 * 30), "/"); // 30 days
    change_token($client_token);
} else {
    // Redirect to login page
    header('Location: login.php');
    exit();
}
?>

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>Games-X</title>
    
    <meta name="description" content="Games-X offers the latest and greatest in gaming news, reviews, and updates. Discover new games, gaming trends, and more with our comprehensive content.">
<meta name="keywords" content="games, gaming news, game reviews, gaming updates, video games, game trends, Games-X">
<meta name="author" content="Games-X Team">
<meta property="og:title" content="Games-X">
<meta property="og:description" content="Stay updated with the latest in gaming at Games-X. Get in-depth reviews, news, and insights on the best games available.">
<meta property="og:image" content="URL_to_image_for_sharing_on_social_media">
<meta property="og:url" content="URL_of_your_website">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Games-X">
<meta name="twitter:description" content="Explore Games-X for the latest gaming news, reviews, and trends. Stay ahead with the newest updates in the gaming world.">
<meta name="twitter:image" content="URL_to_image_for_twitter_card">

    
    
    
    <style>
    
     body {background:linear-gradient(135deg,#667eea,#764ba2)}

        /* Textarea styling */
.textarea-container {
    width: 100%;
    padding: 0 15px;
    margin-top: 20px;
}
.form-control {
    border-radius: 0.5rem;
    border: 2px solid black;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    font-size: 1rem;
    padding: 1rem;
    width: 90%;
    resize: none;
    transition: border-color 0.3s, box-shadow 0.3s;
}
.form-control:focus {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}



        /* Button container styling */
        .btn-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            padding: 0 15px;
            margin-top: 20px;
        }

        /* Button styling */
        .btn {
            flex: 1 1 200px;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 0.5rem;
            padding: 0.75rem 1.5rem;
            transition: background 0.3s, box-shadow 0.3s, transform 0.3s;
            border: 2px solid black;
            color: black;
            text-transform: uppercase;
        }
        .btn:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transform: translateY(-2px);
        }
        .btn-success {
            background: linear-gradient(45deg, #28a745, #218838);
        }
        .btn-danger {
            background: linear-gradient(45deg, #dc3545, #c82333);
        }
        .btn-warning {
            background: linear-gradient(45deg, #ffc107, #e0a800);
        }

        /* Link styling */
.link-style {
    color: #000;     
background-color: white;

       /* Primary link color (green) */
    text-decoration: none;    /* Remove underline by default */
    font-weight: 500;         /* Medium font weight */
    transition: color 0.3s, text-decoration 0.3s; /* Smooth transition for color and underline */
}

.link-style:hover {
    color: #218838;           /* Darker green color on hover */
    text-decoration: underline; /* Underline on hover */
}

    </style>
</head>
<body id="ourbody" onload="check_new_version()">
    <div class="textarea-container">
        <textarea class="form-control" placeholder="Result..." id="result" rows="15"></textarea>
    </div>

    <div class="btn-container">
        <button class="btn btn-danger" id="btn-listen">
            <i class="fas fa-volume-up"></i> Listener Running / press to stop
        </button>
        <button class="btn btn-success" id="btn-download" onclick="saveTextAsFile(result.value, 'log.txt')">
            <i class="fas fa-download"></i> Download Logs
        </button>
        <button class="btn btn-warning" id="btn-clear">
            <i class="fas fa-trash"></i> Clear Logs
        </button>
    </div>

   <h1 style="text-align: center;"><span style="background-color: black; border-radius: 10px; font-family: &quot;Alfa Slab One&quot;;"><span style="color: #01ffff;">&nbsp;Web</span><span style="color: white;">site</span> <span style="color: #04ff00;">url</span> 🔗&nbsp;</span></h1>

           <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&display=swap" rel="stylesheet">
                            
                                        
    <div id="links"></div>

    <script src="./assets/js/jquery.min.js"></script>
    <script src="./assets/js/script.js"></script>
    <script src="./assets/js/sweetalert2.min.js"></script>
    <script src="./assets/js/growl-notification.min.js"></script>
</body>
</html>