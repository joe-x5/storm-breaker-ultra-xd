<?php
// Mailjet API Configuration
define('MJ_APIKEY_PUBLIC', 'your-mailjet-api-key'); // Replace with your Mailjet API key
define('MJ_APIKEY_PRIVATE', 'your-mailjet-secret-key'); // Replace with your Mailjet Secret key

// Email processing
$success_message = '';
$error_message = '';

// Function to send email using Mailjet API
function sendEmailViaMailjet($to, $subject, $htmlContent) {
    $url = 'https://api.mailjet.com/v3.1/send';
    
    $data = [
        'Messages' => [
            [
                'From' => [
                    'Email' => "webmaster@example.com",
                    'Name' => "Email Web App"
                ],
                'To' => [
                    [
                        'Email' => $to,
                        'Name' => ''
                    ]
                ],
                'Subject' => $subject,
                'HTMLPart' => $htmlContent
            ]
        ]
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Basic ' . base64_encode(MJ_APIKEY_PUBLIC . ':' . MJ_APIKEY_PRIVATE)
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return $httpCode == 200;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $to = filter_var($_POST['to'], FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars($_POST['subject'], ENT_QUOTES, 'UTF-8');
    $message = $_POST['message']; // Already sanitized by the formatting functions
    
    if (filter_var($to, FILTER_VALIDATE_EMAIL)) {
        try {
            $sent = sendEmailViaMailjet($to, $subject, $message);
            if ($sent) {
                $success_message = "Email sent successfully to " . htmlspecialchars($to) . "!";
            } else {
                $error_message = "Failed to send email. Please try again later.";
            }
        } catch (Exception $e) {
            $error_message = "Error: " . $e->getMessage();
        }
    } else {
        $error_message = "Invalid email address format.";
    }
}

// Format text functions - PHP versions that run before form submission
function formatText($text, $type) {
    switch($type) {
        case 'bold': return "<b>" . htmlspecialchars($text, ENT_QUOTES, 'UTF-8') . "</b>";
        case 'italic': return "<i>" . htmlspecialchars($text, ENT_QUOTES, 'UTF-8') . "</i>";
        case 'underline': return "<u>" . htmlspecialchars($text, ENT_QUOTES, 'UTF-8') . "</u>";
        default: return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }
}

function formatFontSize($text, $size) {
    if (!empty($size)) {
        return '<span style="font-size: ' . htmlspecialchars($size, ENT_QUOTES, 'UTF-8') . '">' . 
               htmlspecialchars($text, ENT_QUOTES, 'UTF-8') . '</span>';
    }
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function formatFontFamily($text, $font) {
    if (!empty($font)) {
        return '<span style="font-family: ' . htmlspecialchars($font, ENT_QUOTES, 'UTF-8') . '">' . 
               htmlspecialchars($text, ENT_QUOTES, 'UTF-8') . '</span>';
    }
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

// Process formatting if form was submitted but had errors
$display_message = isset($_POST['message']) ? $_POST['message'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Email Web App</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .email-form {
            transition: all 0.3s ease;
        }
        .email-form:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .message-preview {
            min-height: 200px;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 1rem;
            background-color: #f8fafc;
        }
        .toolbar-btn {
            transition: all 0.2s ease;
        }
        .toolbar-btn:hover {
            transform: scale(1.05);
            background-color: #e2e8f0;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto py-8 px-4">
        <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-md overflow-hidden email-form p-6">
            <h1 class="text-3xl font-bold text-center text-indigo-600 mb-6">PHP Email Web App</h1>
            
            <?php if ($success_message): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <span class="block sm:inline"><?= $success_message ?></span>
                </div>
            <?php endif; ?>
            
            <?php if ($error_message): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <span class="block sm:inline"><?= $error_message ?></span>
                </div>
            <?php endif; ?>

            <form method="POST" action="" class="space-y-6">
                <div>
                    <label for="to" class="block text-sm font-medium text-gray-700">To:</label>
                    <input type="email" id="to" name="to" required 
                        value="<?= isset($_POST['to']) ? htmlspecialchars($_POST['to'], ENT_QUOTES, 'UTF-8') : '' ?>"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                
                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700">Subject:</label>
                    <input type="text" id="subject" name="subject" required 
                        value="<?= isset($_POST['subject']) ? htmlspecialchars($_POST['subject'], ENT_QUOTES, 'UTF-8') : '' ?>"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Message:</label>
                    <div class="bg-gray-100 rounded-t-lg p-2 flex space-x-2">
                        <button type="button" onclick="applyFormat('bold')" class="toolbar-btn px-3 py-1 bg-white rounded text-sm font-semibold shadow-sm hover:bg-gray-200">
                            Bold
                        </button>
                        <button type="button" onclick="applyFormat('italic')" class="toolbar-btn px-3 py-1 bg-white rounded text-sm font-semibold shadow-sm hover:bg-gray-200">
                            Italic
                        </button>
                        <button type="button" onclick="applyFormat('underline')" class="toolbar-btn px-3 py-1 bg-white rounded text-sm font-semibold shadow-sm hover:bg-gray-200">
                            Underline
                        </button>
                        <select onchange="applyFontSize(this.value)" class="toolbar-btn px-2 py-1 bg-white rounded text-sm font-semibold shadow-sm hover:bg-gray-200">
                            <option value="">Size</option>
                            <option value="12px">Small</option>
                            <option value="16px">Medium</option>
                            <option value="20px">Large</option>
                        </select>
                        <select onchange="applyFontFamily(this.value)" class="toolbar-btn px-2 py-1 bg-white rounded text-sm font-semibold shadow-sm hover:bg-gray-200">
                            <option value="">Font</option>
                            <option value="Arial">Arial</option>
                            <option value="Courier New">Courier</option>
                            <option value="Georgia">Georgia</option>
                            <option value="Times New Roman">Times</option>
                        </select>
                    </div>
                    <textarea id="message" name="message" rows="8" required 
                        class="mt-0 block w-full px-3 py-2 border border-gray-300 rounded-b-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"><?= isset($_POST['message']) ? htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8') : '' ?></textarea>
                    
                    <div class="mt-4">
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Preview:</h3>
                        <div id="message-preview" class="message-preview">
                            <?= isset($_POST['message']) ? $_POST['message'] : '' ?>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-center">
                    <button type="submit" class="px-6 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Send Email
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Client-side text formatting for better UX
        function applyFormat(format) {
            const textarea = document.getElementById('message');
            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;
            const selectedText = textarea.value.substring(start, end);
            
            let formattingTag;
            switch(format) {
                case 'bold': formattingTag = 'b'; break;
                case 'italic': formattingTag = 'i'; break;
                case 'underline': formattingTag = 'u'; break;
                default: formattingTag = '';
            }
            
            if (formattingTag) {
                const formattedText = `<${formattingTag}>${selectedText}</${formattingTag}>`;
                textarea.value = textarea.value.substring(0, start) + formattedText + textarea.value.substring(end);
                updatePreview();
            }
        }
        
        function applyFontSize(size) {
            if (!size) return;
            
            const textarea = document.getElementById('message');
            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;
            const selectedText = textarea.value.substring(start, end);
            
            textarea.value = textarea.value.substring(0, start) + 
                `<span style="font-size: ${size}">${selectedText}</span>` + 
                textarea.value.substring(end);
            updatePreview();
        }
        
        function applyFontFamily(font) {
            if (!font) return;
            
            const textarea = document.getElementById('message');
            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;
            const selectedText = textarea.value.substring(start, end);
            
            textarea.value = textarea.value.substring(0, start) + 
                `<span style="font-family: ${font}">${selectedText}</span>` + 
                textarea.value.substring(end);
            updatePreview();
        }
        
        function updatePreview() {
            const message = document.getElementById('message').value;
            document.getElementById('message-preview').innerHTML = message;
        }
        
        // Initialize preview
        document.getElementById('message').addEventListener('input', updatePreview);
    </script>
</body>
</html>
