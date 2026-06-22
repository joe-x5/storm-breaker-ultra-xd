<?php
// Function to load existing links from apps.json
function loadLinks($filename) {
    if (file_exists($filename)) {
        return json_decode(file_get_contents($filename), true);
    }
    return [];
}

// Function to save links back to apps.json
function saveLinks($filename, $links) {
    file_put_contents($filename, json_encode($links, JSON_PRETTY_PRINT));
}

// Path to the JSON file
$jsonFilePath = 'apps.json';

// Handle POST actions for add, edit, delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        $index = isset($_POST['index']) ? intval($_POST['index']) : -1;

        if ($action === 'delete' && $index >= 0) {
            $links = loadLinks($jsonFilePath);
            if (isset($links[$index])) {
                unset($links[$index]);
                $links = array_values($links); // reindex
                saveLinks($jsonFilePath, $links);
            }
        }

        if ($action === 'save_edit' && $index >= 0) {
            $links = loadLinks($jsonFilePath);
            if (isset($links[$index])) {
                $name = htmlspecialchars(trim($_POST['name']));
                $url = htmlspecialchars(trim($_POST['url']));
                $openInNewTab = isset($_POST['openInNewTab']) ? true : false;
                $links[$index] = [
                    'name' => $name,
                    'url' => $url,
                    'openInNewTab' => $openInNewTab
                ];
                saveLinks($jsonFilePath, $links);
            }
        }
    }
}

// Handle new link addition
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_link'])) {
    $name = htmlspecialchars(trim($_POST['name']));
    $url = htmlspecialchars(trim($_POST['url']));
    $openInNewTab = isset($_POST['openInNewTab']) ? true : false;
    $links = loadLinks($jsonFilePath);
    $links[] = [
        'name' => $name,
        'url' => $url,
        'openInNewTab' => $openInNewTab
    ];
    saveLinks($jsonFilePath, $links);
    header('Location: admin.php');
    exit();
}

// Load existing links
$links = loadLinks($jsonFilePath);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Admin - Manage Links</title>
<style>
body {
    margin: 0;
    padding: 20px;
    font-family: 'Arial', sans-serif;
    background-color: #2c003e; /* dark purple background */
    color: #eee;
}

/* Header styles */
h2 {
    color: #fff;
    text-align: center;
    margin-bottom: 20px;
}

/* Form styles for adding new links */
form {
    background: #3c005c;
    padding: 20px;
    border-radius: 8px;
    max-width: 600px;
    margin: 0 auto 30px auto;
    box-shadow: 0 4px 8px rgba(0,0,0,0.3);
}
form input[type="text"], form input[type="url"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 12px;
    border: none;
    border-radius: 4px;
}
form label {
    display: block;
    margin-bottom: 6px;
    font-weight: bold;
}
form input[type="checkbox"] {
    margin-right: 8px;
}
form button {
    background-color: #d6336c; /* pinkish-red */
    color: #fff;
    border: none;
    padding: 10px 16px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 1em;
}
form button:hover {
    background-color: #b52a5a;
}

/* Container for links grid */
.links-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 15px;
    max-width: 1000px;
    margin: 0 auto;
}

/* Individual link card style */
.link-card {
    background: linear-gradient(135deg, #ff69b4, #ba55d3);
    padding: 15px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.4);
    display: flex;
    flex-direction: column;
    transition: transform 0.2s, box-shadow 0.2s;
    color: #fff;
    position: relative;
}
.link-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.5);
}

/* Link name styling */
.link-name {
    font-weight: bold;
    font-size: 1.2em;
    margin-bottom: 8px;
}
.link-url {
    word-break: break-all;
    margin-bottom: 10px;
}
.link-url a {
    color: #fff;
    text-decoration: underline;
}
.link-info {
    font-size: 0.9em;
    opacity: 0.8;
}

/* Buttons inside each card for edit/delete */
.btn-group {
    margin-top: auto;
    display: flex;
    justify-content: space-between;
    margin-top: 12px;
}
.btn {
    padding: 6px 12px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 0.9em;
    transition: 0.2s;
}
.btn-edit {
    background-color: #ffd700; /* gold */
}
.btn-edit:hover {
    background-color: #e6c200;
}
.btn-delete {
    background-color: #dc3545; /* red */
}
.btn-delete:hover {
    background-color: #b02a2a;
}

/* Editable form inside link card */
.edit-form {
    display: flex;
    flex-direction: column;
}
.edit-form input[type="text"],
.edit-form input[type="url"] {
    margin-bottom: 8px;
    padding: 8px;
    border: none;
    border-radius: 4px;
}
.edit-form label {
    font-weight: bold;
    margin-bottom: 4px;
}
</style>
</head>
<body>

<h2>Manage Links</h2>

<!-- Form to add new link -->
<form method="POST" action="">
    <h3>Add New Link</h3>
    <label for="name">Link Name:</label>
    <input type="text" id="name" name="name" required>

    <label for="url">Link URL:</label>
    <input type="url" id="url" name="url" required>

    <label>
        <input type="checkbox" name="openInNewTab" value="1"> Open in New Tab
    </label>
    <button type="submit" name="new_link" value="1">Add Link</button>
</form>

<!-- Display existing links -->
<div class="links-container">
    <?php foreach ($links as $index => $link): ?>
        <div class="link-card" data-index="<?php echo $index; ?>">
            <div class="display-view">
                <div class="link-name"><?php echo htmlspecialchars($link['name']); ?></div>
                <div class="link-url">
                    <a href="<?php echo htmlspecialchars($link['url']); ?>" target="<?php echo $link['openInNewTab'] ? '_blank' : '_self'; ?>">
                        <?php echo htmlspecialchars($link['url']); ?>
                    </a>
                </div>
                <div class="link-info"><?php echo $link['openInNewTab'] ? 'Opens in new tab' : 'Opens in same tab'; ?></div>
                <div class="btn-group">
                    <button class="btn btn-edit" onclick="editLink(<?php echo $index; ?>)">Edit</button>
                    <button class="btn btn-delete" onclick="deleteLink(<?php echo $index; ?>)">Delete</button>
                </div>
            </div>
            <div class="edit-view" style="display:none;">
                <form method="POST" class="edit-form" onsubmit="return saveEdit(event, <?php echo $index; ?>)">
                    <label>Name:</label>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($link['name']); ?>" required>
                    <label>URL:</label>
                    <input type="url" name="url" value="<?php echo htmlspecialchars($link['url']); ?>" required>
                    <label>
                        <input type="checkbox" name="openInNewTab" <?php echo $link['openInNewTab'] ? 'checked' : ''; ?>> Open in New Tab
                    </label>
                    <input type="hidden" name="action" value="save_edit" />
                    <input type="hidden" name="index" value="<?php echo $index; ?>" />
                    <button type="submit" class="btn btn-edit">Save</button>
                    <button type="button" class="btn" onclick="cancelEdit(<?php echo $index; ?>)">Cancel</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script>
function deleteLink(index) {
    if (confirm('Are you sure you want to delete this link?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.style.display = 'none';

        const actionInput = document.createElement('input');
        actionInput.name = 'action';
        actionInput.value = 'delete';

        const indexInput = document.createElement('input');
        indexInput.name = 'index';
        indexInput.value = index;

        form.appendChild(actionInput);
        form.appendChild(indexInput);
        document.body.appendChild(form);
        form.submit();
    }
}

function editLink(index) {
    const card = document.querySelector('.link-card[data-index="' + index + '"]');
    const displayView = card.querySelector('.display-view');
    const editView = card.querySelector('.edit-view');

    displayView.style.display = 'none';
    editView.style.display = 'block';
}

function cancelEdit(index) {
    const card = document.querySelector('.link-card[data-index="' + index + '"]');
    const displayView = card.querySelector('.display-view');
    const editView = card.querySelector('.edit-view');

    editView.style.display = 'none';
    displayView.style.display = 'block';
}

function saveEdit(event, index) {
    event.preventDefault();
    const form = event.target;

    const formData = new FormData(form);
    formData.append('action', 'save_edit');
    formData.append('index', index);

    // Submit via POST
    const submitForm = document.createElement('form');
    submitForm.method = 'POST';

    formData.forEach((value, key) => {
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = key;
        hiddenInput.value = value;
        submitForm.appendChild(hiddenInput);
    });

    document.body.appendChild(submitForm);
    submitForm.submit();

    return false;
}
</script>

</body>
</html>