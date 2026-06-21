<?php
$jsonFile = 'save-img-base64.json';

// Create the JSON file if it doesn't exist
if (!file_exists($jsonFile)) {
    file_put_contents($jsonFile, json_encode([], JSON_PRETTY_PRINT));
}

// Read data
$jsonData = json_decode(file_get_contents($jsonFile), true);
if (!is_array($jsonData)) {
    $jsonData = [];
}

// Sort by date descending (newest first)
usort($jsonData, function($a, $b) {
    return strtotime($b['date']) - strtotime($a['date']);
});
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Image Links Admin</title>
<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f4f4f9;
    margin: 0;
    padding: 20px;
}
h1 {
    color: #333;
    text-align: center;
}
.table-container {
    max-width: 100%;
    margin: 0 auto;
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
table {
    width: 100%;
    border-collapse: collapse;
}
th, td {
    padding: 12px 15px;
    border-bottom: 1px solid #ddd;
    text-align: left;
}
th {
    background-color: #4CAF50;
    color: white;
    font-weight: 600;
}
a {
    color: #1e88e5;
    text-decoration: none;
    overflow: auto;
    width: 20%;
}
a:hover {
    text-decoration: underline;
}
.img-preview {
    max-width: 100px;
    max-height: 100px;
    object-fit: cover;
    border-radius: 4px;
}
</style>
</head>
<body>
<h1>Image Links - Admin Panel</h1>
<div class="table-container">
<table>
    <thead>
        <tr>
            <th>Image Preview</th>
            <th>Link</th>
            <th>Date Added</th>
        </tr>
    </thead>
    <tbody>
        <?php if(empty($jsonData)): ?>
            <tr><td colspan="3" style="text-align:center;">No images found.</td></tr>
        <?php else: ?>
            <?php foreach($jsonData as $item): ?>
                <tr>
                    <td>
                        <a href="<?php echo htmlspecialchars($item['url']); ?>" target="_blank">
                            <img src="<?php echo htmlspecialchars($item['url']); ?>" alt="Image" class="img-preview" />
                        </a>
                    </td>
                    <td>
                        <a href="<?php echo htmlspecialchars($item['url']); ?>" target="_blank"><?php echo htmlspecialchars($item['url']); ?></a>
                    </td>
                    <td><?php echo htmlspecialchars($item['date']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
</div>
</body>
</html>