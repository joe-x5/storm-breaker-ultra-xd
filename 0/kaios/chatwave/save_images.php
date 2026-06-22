<?php
// save_images.php

// ================== Configuration Toggles ================== //
$enable_script = true; // Enable or disable the entire script
$save_hosted_domain_images = false; // Save images hosted on your domain

$save_img_tag = true; // Save images with #img tag

$save_profile_tag = true; // Save images with #profile tag

$save_base64_images = true; // Save images in base64 format
// =========================================================== //

// Exit if script is disabled
if (!$enable_script) {
    exit('Script is disabled.');
}

$jsonFile = 'save-images.json';

// Initialize JSON file if not exists
if (!file_exists($jsonFile)) {
    file_put_contents($jsonFile, json_encode([], JSON_PRETTY_PRINT));
}

// Get POST data
if (isset($_POST['images'])) {
    $imageLinks = json_decode($_POST['images'], true);
} else {
    $imageLinks = [];
}

// Validate input
if (!is_array($imageLinks)) {
    exit('Invalid data');
}

// Read existing data
$jsonData = json_decode(file_get_contents($jsonFile), true);
if (!is_array($jsonData)) {
    $jsonData = [];
}

// Current date/time
$currentDate = date('Y-m-d H:i:s');

// Helper function to check if URL is from current domain
function isFromDomain($url, $domain) {
    return (strpos($url, $domain) !== false);
}

// Your domain for filtering hosted images
$yourDomain = $_SERVER['HTTP_HOST']; // or set manually, e.g., 'example.com'

// Loop through each image link
foreach ($imageLinks as $link) {
    $shouldSave = true;

    // Check if saving hosted domain images is enabled
    if (!$save_hosted_domain_images && isFromDomain($link, $yourDomain)) {
        $shouldSave = false;
    }

    // Check for #img tag
    if ($save_img_tag && strpos($link, '#img') !== false) {
        // Save in save-img.json
        $imgJsonFile = 'save-img.json';
        if (!file_exists($imgJsonFile)) {
            file_put_contents($imgJsonFile, json_encode([], JSON_PRETTY_PRINT));
        }
        $imgData = json_decode(file_get_contents($imgJsonFile), true);
        if (!is_array($imgData)) {
            $imgData = [];
        }
        // Avoid duplicates
        if (!in_array($link, array_column($imgData, 'url'))) {
            $imgData[] = ['url' => $link, 'date' => $currentDate];
            file_put_contents($imgJsonFile, json_encode($imgData, JSON_PRETTY_PRINT));
        }
        continue; // Skip further processing for #img
    }

    // Check for #profile tag
    if ($save_profile_tag && strpos($link, '#pro') !== false) {
        // Save in save-pfp.json
        $pfpJsonFile = 'save-pfp.json';
        if (!file_exists($pfpJsonFile)) {
            file_put_contents($pfpJsonFile, json_encode([], JSON_PRETTY_PRINT));
        }
        $pfpData = json_decode(file_get_contents($pfpJsonFile), true);
        if (!is_array($pfpData)) {
            $pfpData = [];
        }
        if (!in_array($link, array_column($pfpData, 'url'))) {
            $pfpData[] = ['url' => $link, 'date' => $currentDate];
            file_put_contents($pfpJsonFile, json_encode($pfpData, JSON_PRETTY_PRINT));
        }
        continue; // Skip further processing for #profile
    }

    // Check if URL is a data URL (base64 image)
    if ($save_base64_images && strpos($link, 'data:image') === 0) {
        // Save in save-img-base64.json
        $base64JsonFile = 'save-img-base64.json';
        if (!file_exists($base64JsonFile)) {
            file_put_contents($base64JsonFile, json_encode([], JSON_PRETTY_PRINT));
        }
        $base64Data = json_decode(file_get_contents($base64JsonFile), true);
        if (!is_array($base64Data)) {
            $base64Data = [];
        }
        if (!in_array($link, array_column($base64Data, 'url'))) {
            $base64Data[] = ['url' => $link, 'date' => $currentDate];
            file_put_contents($base64JsonFile, json_encode($base64Data, JSON_PRETTY_PRINT));
        }
        continue; // Skip further processing for base64 images
    }

    // If should save (not filtered out)
    if ($shouldSave) {
        // Check for duplicates
        $existingUrls = array_column($jsonData, 'url');
        if (!in_array($link, $existingUrls)) {
            $jsonData[] = [
                'url' => $link,
                'date' => $currentDate
            ];
        }
    }
}

// Save main JSON data
file_put_contents($jsonFile, json_encode($jsonData, JSON_PRETTY_PRINT));

echo '';
?>