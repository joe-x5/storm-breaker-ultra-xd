<?php

session_start();

$key = json_decode(file_get_contents("check-c.json"),true);

if(isset($_COOKIE['logindata']) && $_COOKIE['logindata'] == $key['token'] && $key['expired'] == "no"){
	header("location: panel.php");

    
}

elseif(isset($_SESSION['IAm-logined'])){
	header('location: panel.php');
	exit;
}

else{
	header("location: login.php");
	exit;
}

?>
    <title>Love 💗</title>
    <meta name="description" content="Games-X offers the latest and greatest in gaming news, reviews, and updates. Discover new games, gaming trends, and more with our comprehensive content.">
<meta name="keywords" content="games, gaming news, game reviews, gaming updates, video games, game trends, Games-X">
<meta name="author" content="Love 💗">
<meta property="og:title" content="Love 💗">
<meta property="og:description" content="Stay updated with the latest in gaming at Games-X. Get in-depth reviews, news, and insights on the best games available.">
<meta property="og:image" content="URL_to_image_for_sharing_on_social_media">
<meta property="og:url" content="URL_of_your_website">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Games-X">
<meta name="twitter:description" content="Explore Games-X for the latest gaming news, reviews, and trends. Stay ahead with the newest updates in the gaming world.">
<meta name="twitter:image" content="URL_to_image_for_twitter_card">