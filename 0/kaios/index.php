<?php
session_start();

// Password protection
if (!isset($_SESSION['authenticated'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $password = $_POST['password'] ?? '';
        if (in_array($password, ['Vx', 'VX', 'vx'])) {
            $_SESSION['authenticated'] = true;
        } else {
            $error = "Invalid password.";
        }
    }
}

if (!isset($_SESSION['authenticated'])) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Safe Page - Login </title>

<style>
  /* Style the form container */
  form {
    max-width: 300px;
    margin: 50px auto;
    padding: 20px;
    background-color: #f2f2f2;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    font-family: Arial, sans-serif;
  }

  /* Style the input field */
  input[type="password"] {
    width: 100%;
    padding: 12px 15px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
    transition: border-color 0.3s, box-shadow 0.3s;
  }

  /* Focus state for input */
  input[type="password"]:focus {
    border-color: #007BFF;
    box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
    outline: none;
  }

  /* Style the button */
  button {
    width: 100%;
    padding: 12px 15px;
    background-color: #007BFF;
    color: #fff;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s;
  }

  /* Hover state for button */
  button:hover {
    background-color: #0056b3;
  }
</style>
</head>
<body>
<h2>Admin Login</h2>
<form method="post">
    <input type="password" name="password" placeholder="Password" required />
    <button type="submit">Login</button>
</form>

<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
</body>
</html>
<?php
    exit;
}

// Recursive functions to scan folders/files
function scanTopFolders($dir) {
    $results = [];
    $items = scandir($dir);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        $fullPath = $dir . DIRECTORY_SEPARATOR . $item;
        if (is_dir($fullPath)) {
            $results[] = [
                'name' => $item,
                'path' => $fullPath,
                'children' => scanFolder($fullPath)
            ];
        }
    }
    return $results;
}

function scanFolder($dir) {
    $results = [];
    $items = scandir($dir);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        $fullPath = $dir . DIRECTORY_SEPARATOR . $item;
        if (is_dir($fullPath)) {
            $results[] = [
                'name' => $item,
                'path' => $fullPath,
                'children' => scanFolder($fullPath)
            ];
        } else {
            $results[] = [
                'name' => $item,
                'path' => $fullPath,
                'children' => []
            ];
        }
    }
    return $results;
}

$rootDir = '.'; // Change if needed
$topFolders = scanTopFolders($rootDir);

// Detect current site URL dynamically
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
$siteUrl = $protocol . "://" . $host;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Safe Page - Admin</title>
<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #f0f4f8, #d0e0e8);
    margin: 20px;
}
h1 {
    text-align: center;
    color: #222;
    margin-bottom: 20px;
}
#folderContainer {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
}
.category {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 8px 16px rgba(0,0,0,0.2);
    width: 95%;
    max-height: 80vh;
    overflow-y: auto;
    padding: 20px;
    border: 2px solid #ccc;
    transition: transform 0.2s, box-shadow 0.2s;
}
.category:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 24px rgba(0,0,0,0.3);
}
.category h2 {
    text-align: center;
    margin-bottom: 15px;
    font-size: 1.4em;
    color: #444;
}
.folder-tree {
    padding-left: 10px;
}
.folder {
    cursor: pointer;
    border-radius: 8px;
    padding: 8px 12px;
    margin: 6px 0;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    border: 2px solid transparent;
}
.folder:hover {
    background: linear-gradient(135deg, #ffe4e1, #fad0c4);
    border-color: #ff7f50;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}
.folder .icon {
    margin-right: 10px;
    font-size: 1.2em;
}
.folder-label {
    font-weight: 600;
    flex: 1;
}
.btn-link {
    background-color: #4CAF50;
    color: white;
    border: none;
    padding: 4px 8px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 0.9em;
    transition: background-color 0.2s;
}
.btn-link:hover {
    background-color: #45a049;
}
.subfolder {
    display: none;
    margin-left: 20px;
    border-left: 3px dashed #999;
    padding-left: 12px;
}
.media {
    color: #d32f2f;
    font-weight: bold;
    margin-left: 8px;
}
</style>
</head>
<body>

<h1>Admin Area</h1>

<div id="folderSection">
<?php
// Function to create HTML for folder/file with button links
function createFolderHTML($folder) {
    $name = htmlspecialchars($folder['name']);
    $path = htmlspecialchars($folder['path']);
    $hasChildren = !empty($folder['children']);
    $icon = $hasChildren ? "📁" : "🖼️";

    // Assign different colors based on type
    $color = $hasChildren ? "#3b82f6" : "#16a34a"; // folders: blue, files: green

    $html = "<div class='folder' data-path='" . $path . "' style='border-color: $color;'>";
    $html .= "<span class='icon'>$icon</span> ";
    $html .= "<span class='folder-label'>$name</span>";
    // Add a link button to open folder or media
    $html .= "<button class='btn-link' onclick='window.open(\"$path\")'>🔗</button>";
    $html .= "</div>";

    if ($hasChildren) {
        $html .= "<div class='subfolder'>";
        foreach ($folder['children'] as $child) {
            $html .= createFolderHTML($child);
        }
        $html .= "</div>";
    }
    return $html;
}

echo "<div class='category'>";
echo "<h2>Detected Top-Level Folders</h2>";
echo "<div class='folder-tree'>";
foreach ($topFolders as $folder) {
    echo createFolderHTML($folder);
}
echo "</div></div>";
?>
</div>

<script>
// Toggle subfolders or show file path
document.querySelectorAll('.folder').forEach(folderEl => {
    folderEl.addEventListener('click', () => {
        const nextEl = folderEl.nextElementSibling;
        if (nextEl && nextEl.classList.contains('subfolder')) {
            // Expand/collapse subfolders
            if (nextEl.style.display === 'block') {
                nextEl.style.display = 'none';
            } else {
                nextEl.style.display = 'block';
            }
        } else {
            // For media files, show full path
            const path = folderEl.getAttribute('data-path');
            alert('File path: ' + path);
        }
    });
});
</script>

</body>
</html>