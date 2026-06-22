<?php
/**
 * Secure Image Gallery (v2‑May‑2025)
 *
 *  • Multiple passwords
 *  • Multiple image folders
 *  • 10 images per page (responsive grid)
 *  • Click thumbnail → fullscreen viewer (Prev / Next)
 *  • Dark/light aesthetic, soft shadows, subtle animations
 *  • Video support
 *  • Folder thumbnails with names and navigation from root only
 *  • Clicking folder shows images/videos inside as gallery
 */
/***************************************************************************
 * CONFIGURATION
 ***************************************************************************/
$passwords = [
    'talha',        // original
    'kaios2025',    // original
    '5123',         // original
    'darkpics',     // NEW extra
    '2025'          // NEW extra
];

$imageDirs = [
    './images/',
    './images/Dark V1/',   
    './images/Lana/',  // main gallery
    './gallery/'    // secondary (add more as desired)
];

$imagesPerPage = 10;   // thumbnails per page
/***************************************************************************/

session_start();

/***************************** HELPERS ***********************************/
/**
 * Lists media files in directories.
 * If $folder is null, lists media & folders at root dir.
 * If $folder specified, lists only media files inside that folder,
 * no subfolders shown for cleaner navigation.
 * @param array $dirs Base directories to scan (root only).
 * @param string|null $folder Folder path inside base dir.
 * @return array List of media items. Each item: ['name'=>string, 'path'=>string, 'isFolder'=>bool (optional)]
 */
function listMedia(array $dirs, $folder = null): array {
    $all = [];
    $baseDir = $folder ? $folder : $dirs[0];
    if (!is_dir($baseDir)) return $all;

    // Scan files (images and videos) inside target directory
    $scan = array_filter(scandir($baseDir), fn($f) =>
        is_file($baseDir.$f) &&
        preg_match('/\.(jpe?g|png|gif|webp|bmp|mp4|webm|ogg)$/i', $f)
    );
    foreach ($scan as $file) {
        $all[] = ['name' => $file, 'path' => $baseDir.$file];
    }

    // Only show folders if we are at root (no folder param)
    if (!$folder) {
        $folders = array_filter(scandir($baseDir), fn($f) =>
            is_dir($baseDir.$f) && $f !== '.' && $f !== '..'
        );
        foreach ($folders as $folderName) {
            $folderPath = $baseDir . $folderName . '/';
            $firstImage = array_filter(scandir($folderPath), fn($f) =>
                is_file($folderPath.$f) &&
                preg_match('/\.(jpe?g|png|gif|webp|bmp)$/i', $f)
            );
            if ($firstImage) {
                $firstImage = array_values($firstImage)[0];
                $all[] = ['name' => $folderName, 'path' => $folderPath.$firstImage, 'isFolder' => true];
            }
        }
    }
    usort($all, fn($a, $b) => filemtime($b['path']) <=> filemtime($a['path']));
    return $all;
}

function randToken($len = 10) { return bin2hex(random_bytes($len / 2)); }
function shareURL(string $file) { return '?img=' . urlencode(randToken() . '_' . date('YmdHis') . '_' . $file); }
/***************************** AUTH ***********************************/
if (!isset($_SESSION['auth'])) {
    $errorMsg = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $pass = $_POST['pass'] ?? '';
        if (in_array($pass, $passwords, true)) {
            $_SESSION['auth'] = true;
            header('Location: ?');
            exit;
        } else {
            $errorMsg = 'Wrong password — access denied';
        }
    }
    echo '<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Login | Secure Gallery</title><style>
    html,body{height:100%;margin:0;display:flex;justify-content:center;align-items:center;background:linear-gradient(135deg,#141e30,#243b55);font-family:Arial,sans-serif;color:#fff}
    .card{width:90%;max-width:400px;background:rgba(255,255,255,.1);padding:40px 32px;border-radius:16px;backdrop-filter:blur(12px);box-shadow:0 10px 24px rgba(0,0,0,.35);text-align:center;animation:fade .6s ease}
    @keyframes fade{from{opacity:0;transform:scale(.9)}to{opacity:1;transform:scale(1)}}
    input,button{width:90%;padding:14px 12px;border:none;border-radius:8px;font-size:16px;margin-top:18px}
    input{background:rgba(255,255,255,.85);color:#000}
    button{background:#00d8ff;color:#000;font-weight:bold;cursor:pointer;transition:transform .2s,box-shadow .2s}
    button:hover{transform:translateY(-2px);box-shadow:0 6px 12px rgba(0,0,0,.3)}
    .err{color:#ffb3b3;font-size:14px;margin-top:10px}
    </style></head><body><div class="card">
      <h2>🔒 Secure Image Gallery</h2>
      <p>Enter the password to continue.</p>
      <form method="post" autocomplete="off">
        <input type="password" name="pass" placeholder="Password" required>
        <button type="submit">Unlock</button>
      </form>' . ($errorMsg ? '<div class="err">' . htmlspecialchars($errorMsg) . '</div>' : '') . '
      <p style="margin-top:30px;font-size:12px;opacity:.8">© ' . date('Y') . ' Dark Pics 9. All rights reserved.</p>
    </div></body></html>';
    exit;
}
/***************************** MEDIA DATA ***********************************/
$folder = $_GET['folder'] ?? null;
if ($folder) {
    // Add trailing slash if missing
    $folder = rtrim($folder, '/') . '/';
    // Prevent directory traversal; sanitize folder path
    foreach ($imageDirs as $base) {
        $realBase = realpath($base);
        $realFolder = realpath($folder);
        if ($realFolder !== false && strpos($realFolder, $realBase) === 0) {
            $folder = $realFolder . DIRECTORY_SEPARATOR;
            break;
        }
    }
}
$media = listMedia($imageDirs, $folder);
$total = count($media);
$page = max(1, (int)($_GET['page'] ?? 1));
$pages = max(1, ceil($total / $imagesPerPage));
$page = min($page, $pages);
$start = ($page - 1) * $imagesPerPage;
$subset = array_slice($media, $start, $imagesPerPage);
/***************************** FULLSCREEN VIEW ***********************************/
if (isset($_GET['img'])) {
    $parts = explode('_', $_GET['img'], 3);
    if (count($parts) === 3) {
        $filename = $parts[2];
        $idx = array_search($filename, array_column($media, 'name'));
        if ($idx !== false) {
            $filepath = $media[$idx]['path'];
            $prevIdx = ($idx - 1 + $total) % $total;
            $nextIdx = ($idx + 1) % $total;
            $prevURL = shareURL($media[$prevIdx]['name']);
            $nextURL = shareURL($media[$nextIdx]['name']);
            echo '<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Viewer</title><style>
            html,body{margin:0;height:100%;background:#000;display:flex;justify-content:center;align-items:center}
            img,video{max-width:100%;max-height:100%;border-radius:6px;box-shadow:0 0 24px rgba(0,0,0,.8);animation:fade .4s ease}
            @keyframes fade{from{opacity:0;transform:scale(.9)}to{opacity:1;transform:scale(1)}}
            .btn{position:fixed;top:50%;transform:translateY(-50%);background:rgba(0,0,0,.5);border:none;color:#fff;font-size:30px;padding:12px 18px;border-radius:50%;cursor:pointer;backdrop-filter:blur(4px);transition:background .2s}
            .btn:hover{background:rgba(0,0,0,.8)}
            #close{top:16px;right:16px;transform:none;font-size:18px;border-radius:8px}
            #prev{left:18px}
            #next{right:18px}
            </style></head><body>
            <button id="close" class="btn" onclick="location.href=\'index.php?page=' . $page . ($folder ? '&folder=' . urlencode(trim($folder, '/')) : '') . '\'">✕</button>
            <button id="prev" class="btn" onclick="location.href=\'' . $prevURL . '\'">‹</button>';
            if (preg_match('/\.(mp4|webm|ogg)$/i', $filename)) {
                echo '<video controls autoplay playsinline><source src="' . $filepath . '" type="video/mp4">Your browser does not support the video tag.</video>';
            } else {
                echo '<img src="' . $filepath . '" alt="image" src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/67e0975a-4bc0-425f-96d1-17f7729d0f23.png">';
            }
            echo '<button id="next" class="btn" onclick="location.href=\'' . $nextURL . '\'">›</button>
            </body></html>';
            exit;
        }
    }
}
/***************************** GALLERY PAGE ***********************************/
?><!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
<title>Gallery</title>
<style>
  body {
    margin: 0;
    font-family: Arial, Helvetica, sans-serif;
    background: #f5f7fa;
    color: #222;
    -webkit-text-size-adjust: none; /* prevent zoom on some devices */
  }
  header {
    background: #fff;
    padding: 14px 20px;
    box-shadow: 0 2px 6px rgba(0,0,0,.12);
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: sticky;
    top: 0;
    z-index: 20;
  }
  header h1 {
    margin: 0;
    font-size: 22px;
    background: linear-gradient(90deg,#00d8ff,#0066ff);
    -webkit-background-clip: text;
    color: transparent;
    font-weight: 700;
    white-space: nowrap;
  }
  /* show folder path if inside folder */
  .folder-path {
    font-size: 14px;
    color: #555;
    font-style: italic;
    margin-left: 8px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    max-width: 50%;
  }
  .grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
    padding: 16px 16px 24px 16px;
  }
  @media (min-width: 640px) {
    .grid {
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
      padding: 20px 24px 32px 24px;
    }
  }
  @media (min-width: 1024px) {
    .grid {
      grid-template-columns: repeat(4, 1fr);
      gap: 24px;
      padding: 32px 48px 40px 48px;
      max-width: 1280px;
      margin: 0 auto;
    }
  }
  .box {
    border-radius: 14px;
    overflow: hidden;
    cursor: pointer;
    box-shadow: 0 4px 10px rgba(0,0,0,.12);
    transition: transform .2s, box-shadow .2s;
    position: relative;
    background: white;
    display: flex;
    flex-direction: column;
    height: 160px;
  }
  /* Folder box styling distinct */
  .box.folder {
    border: 2px solid #00aaff;
    background: #f0f9ff;
  }
  .box:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 18px rgba(0,0,0,.18);
  }
  /* Image and video thumbnails fill box width */
  .box img, .box video {
    width: 100%;
    height: 120px;
    object-fit: cover;
    display: block;
    transition: transform .4s ease;
  }
  .box:hover img, .box:hover video {
    transform: scale(1.06);
  }
  /* Folder name shown below thumbnail */
  .folder-name {
    padding: 8px 8px 0 8px;
    text-align: center;
    font-weight: 700;
    font-size: 14px;
    color: #0077cc;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    flex-grow: 1;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  /* Play icon overlay for videos */
  .play-icon {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 36px;
    color: white;
    text-shadow: 0 0 8px #000000bb;
    pointer-events: none;
  }
  /* Pagination container */
  .pagination {
    display: flex;
    justify-content: center;
    gap: 10px;
    padding: 18px 8px 30px 8px;
    flex-wrap: wrap;
  }
  .pagination a {
    padding: 8px 12px;
    background: #0066ff;
    color: #fff;
    font-size: 14px;
    border-radius: 6px;
    text-decoration: none;
    box-shadow: 0 2px 4px rgba(0,0,0,.18);
    transition: background .2s;
    white-space: nowrap;
    min-width: 42px;
    text-align: center;
  }
  .pagination a:hover {
    background: #004dcc;
  }
  .pagination .current {
    background: #333;
  }
  footer {
    text-align: center;
    font-size: 12px;
    color: #666;
    padding: 16px 10px 32px 10px;
  }
</style>
</head>
<body>
<header>
  <h1>📸 Image Gallery</h1>
  <?php if ($folder): ?>
    <span class="folder-path">Folder: <?=htmlspecialchars(rtrim($folder,'/'))?></span>
  <?php endif; ?>
  <span>Page <?=$page?> / <?=$pages?></span>
</header>

<div class="grid">
<?php foreach ($subset as $rec):
    // Build the URL
    if ($rec['isFolder'] ?? false) {
        $urlFolder = $folder ? rtrim($folder, '/') . '/' . $rec['name'] : $rec['name'];
        $url = '?folder=' . urlencode($urlFolder);
    } else {
        $url = shareURL($rec['name']);
    }
?>
  <a class="box <?=($rec['isFolder'] ?? false) ? 'folder' : ''?>" href="<?=$url?>" title="<?=htmlspecialchars($rec['isFolder'] ? $rec['name'] : $rec['name'])?>">
    <img src="<?=$rec['path']?>" alt="<?=htmlspecialchars(($rec['isFolder'] ?? false) ? 'Folder: ' . $rec['name'] : 'Image/Video: ' . $rec['name'])?>">
    <?php if (!empty($rec['isFolder'])): ?>
      <div class="folder-name"><?=htmlspecialchars($rec['name'])?></div>
    <?php elseif (preg_match('/\.(mp4|webm|ogg|3gp)$/i', $rec['name'])): ?>
      <div class="play-icon">▶</div>
    <?php endif; ?>
  </a>
<?php endforeach; ?>
</div>

<div class="pagination">
<?php if ($page > 1): ?>
  <a href="?page=<?=$page - 1?><?= $folder ? '&folder=' . urlencode(trim($folder,'/')) : '' ?>">‹ Prev</a>
<?php endif; ?>
<?php for ($p = 1; $p <= $pages; $p++): ?>
  <a href="?page=<?=$p?><?= $folder ? '&folder=' . urlencode(trim($folder,'/')) : '' ?>" class="<?=$p == $page ? 'current' : ''?>"><?=$p?></a>
<?php endfor; ?>
<?php if ($page < $pages): ?>
  <a href="?page=<?=$page + 1?><?= $folder ? '&folder=' . urlencode(trim($folder,'/')) : '' ?>">Next ›</a>
<?php endif; ?>
</div>

<footer>
  © <?=date('Y')?> Dark Pics 9. Built with ♥ for KaiOS & Web. All images auto‑indexed; click a picture to view fullscreen and swipe through your collection.
  <br>
  <a href="upload.php">Upload Now</a>
</footer>
</body>
</html>

