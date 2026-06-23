<?php
// total-visits.php

// Initialize total visits
$totalVisitsFile = 'total-visits.json';
if (file_exists($totalVisitsFile)) {
    $totalVisitsData = json_decode(file_get_contents($totalVisitsFile), true);
    $totalVisits = $totalVisitsData['totalVisits'] + 1;
} else {
    $totalVisits = 1;
}

// Update total visits
file_put_contents($totalVisitsFile, json_encode(['totalVisits' => $totalVisits]));

// Initialize daily visits
$dailyVisitsFile = 'daily-visits.json';
if (file_exists($dailyVisitsFile)) {
    $dailyVisitsData = json_decode(file_get_contents($dailyVisitsFile), true);
} else {
    $dailyVisitsData = [];
}

$today = date('Y-m-d');
$ip = $_SERVER['REMOTE_ADDR'];

// Get the name of the day for today
$dayName = date('l');

// Check if today's date exists in daily visits
if (!isset($dailyVisitsData[$today])) {
    $dailyVisitsData[$today] = [$dayName => []]; // Create a new array for the day
}

// Increment the visit count for the IP address
if (isset($dailyVisitsData[$today][$dayName][$ip])) {
    $dailyVisitsData[$today][$dayName][$ip]++;
} else {
    $dailyVisitsData[$today][$dayName][$ip] = 1;
}

// Sort dates in descending order
uksort($dailyVisitsData, function($a, $b) {
    return strtotime($b) - strtotime($a);
});

// Update daily visits
file_put_contents($dailyVisitsFile, json_encode($dailyVisitsData, JSON_PRETTY_PRINT));

?>

<?php
// Set the path for your JSON file
$jsonFilePath = 'traffic_data.json';

// Get the referrer
$referrer = isset($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST) : 'Direct Access';
$currentDate = date("Y-m-d");

// Load existing traffic data
if (file_exists($jsonFilePath)) {
    $existingData = json_decode(file_get_contents($jsonFilePath), true);
    if (!is_array($existingData)) {
        $existingData = []; // Initialize as an empty array if there was an issue
    }
} else {
    $existingData = []; // Create an empty array if file does not exist
}

// Check if today's date already exists in the data
if (!isset($existingData[$currentDate])) {
    $existingData[$currentDate] = []; // Initialize the date entry if it doesn't exist
}

// Check if the referrer already exists for today
if (isset($existingData[$currentDate][$referrer])) {
    // Increment visit count from this referrer for today
    $existingData[$currentDate][$referrer]['visits'] += 1;
} else {
    // Initialize visit count for this referrer for today
    $existingData[$currentDate][$referrer] = ['visits' => 1];
}

// Sort the data so that the newest dates come first
krsort($existingData);

// Save updated data to JSON file
file_put_contents($jsonFilePath, json_encode($existingData, JSON_PRETTY_PRINT));

// Output success message (or you can simply redirect or show the website content)
echo "";
?>




<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>KaiOS Apps Links</title>
<style>
    /* Reset and basic styles */
    body {
        margin: 0;
        padding: 10px;
        font-family: Arial, sans-serif;
        min-height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
        background: linear-gradient(270deg, #89f7fe, #66a6ff);
        background-size: 600% 600%;
        animation: gradientAnimation 15s ease infinite;
        color: #333;
        position: relative; /* for overlay button positioning */
    }

    @keyframes gradientAnimation {
        0% {background-position: 0% 50%;}
        50% {background-position: 100% 50%;}
        100% {background-position: 0% 50%;}
    }

    /* Title style */
    h2 {
        color: #fff;
        text-shadow: 1px 1px 3px rgba(0,0,0,0.3);
        margin-bottom: 10px;
        z-index: 1;
    }

    /* Theme toggle button */
    #theme-toggle {
        position: fixed;
        top: 15px;
        right: 15px;
        padding: 8px 12px;
        background: linear-gradient(45deg, #ff69b4, #ba55d3);
        border: none;
        border-radius: 20px;
        cursor: pointer;
        font-weight: bold;
        color: #fff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        z-index: 10;
        transition: background 0.3s, transform 0.2s;
    }
    #theme-toggle:hover {
        transform: scale(1.05);
        background: linear-gradient(45deg, #ff85c1, #d493d4);
    }

    /* Container for links */
    #linksContainer {
        width: 100%;
        max-width: 600px;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        margin-top: 20px;
        z-index: 1;
    }

    /* Style for each link div */
    .link-box {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 2px solid rgba(255,255,255,0.4);
        border-radius: 8px;
        padding: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        cursor: pointer;
        text-align: center;
        font-size: 14px;
        font-weight: bold; /* Make text bold */
        transition: all 0.3s ease;
        user-select: none;
        outline: none;
        color: #fff; /* default color for focus state */
    }

    /* Hover effect */
    .link-box:hover {
        background: rgba(255, 255, 255, 0.3);
        box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        transform: translateY(-2px);
    }

    /* Focus styles with different colors */
    .link-box:focus {
        outline: 3px solid #ff69b4; /* pink */
        outline-offset: -2px;
        background: rgba(255, 255, 255, 0.4);
        box-shadow: 0 0 10px #ff69b4, 0 0 20px #ff69b4 inset;
        color: #fff;
    }

    /* Small screens adjustments */
    @media(max-width: 500px){
        body {
            padding: 5px;
        }
        #linksContainer {
            grid-template-columns: 1fr; /* single column on small screens */
        }
        .link-box {
            font-size: 12px;
            padding: 10px;
        }
        #theme-toggle {
            padding: 6px 10px;
            font-size: 14px;
        }
    }

    /* Footer styles */
    footer {
        margin-top: 20px;
        font-size: 12px;
        color: #fff;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
        z-index: 1;
    }

    /* Themes (light/dark) */
    body.light-theme {
        background: linear-gradient(270deg, #fbc7d4, #d4b0f2);
        color: #222;
    }
    body.dark-theme {
        background: linear-gradient(270deg, #222, #111);
        color: #eee;
    }
    /* Additional theme styles can be added as needed */

</style>
</head>
<body>

<h2>Love Tools</h2>
<div id="linksContainer">Loading...</div>

<!-- Theme toggle button -->
<button id="theme-toggle" aria-label="Toggle Theme">Theme</button>

<!-- Copyright footer -->
<footer>
    &copy; Love Tools
</footer>

<script>
    // Theme toggle logic
    const themeButton = document.getElementById('theme-toggle');
    const body = document.body;

    // Load saved theme from localStorage
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme) {
        body.className = savedTheme;
    }

    themeButton.onclick = () => {
        if (body.className === 'light-theme') {
            body.className = 'dark-theme';
            localStorage.setItem('theme', 'dark-theme');
        } else {
            body.className = 'light-theme';
            localStorage.setItem('theme', 'light-theme');
        }
    };

    const container = document.getElementById('linksContainer');

    // Load apps.json via XMLHttpRequest
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'apps.json', true); // Make sure this URL is correct and accessible
    xhr.onreadystatechange = () => {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                try {
                    const links = JSON.parse(xhr.responseText);
                    // Clear loading text
                    container.innerHTML = '';

                    // Generate link divs
                    links.forEach(link => {
                        const div = document.createElement('div');
                        div.className = 'link-box';
                        div.tabIndex = 0; // make focusable
                        div.innerText = link.name;

                        // Open link on click
                        div.onclick = () => {
                            if (link.openInNewTab) {
                                window.open(link.url, '_blank');
                            } else {
                                window.location.href = link.url;
                            }
                        };

                        // Handle Enter/Space keys
                        div.onkeydown = (e) => {
                            if (e.key === 'Enter' || e.key === ' ') {
                                if (link.openInNewTab) {
                                    window.open(link.url, '_blank');
                                } else {
                                    window.location.href = link.url;
                                }
                            }
                        };

                        container.appendChild(div);
                    });
                } catch (e) {
                    console.error('Error parsing JSON:', e);
                    container.innerHTML = 'Failed to load links.';
                }
            } else {
                console.error('Failed to load apps.json', xhr.status);
                container.innerHTML = 'Failed to load links.';
            }
        }
    };
    xhr.send();
</script>

</body>
</html>