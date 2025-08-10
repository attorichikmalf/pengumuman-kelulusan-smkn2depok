<?php
if (!function_exists('footer_error_screen')) {
    function footer_error_screen($message, $title = 'Peringatan Footer') {
        header("HTTP/1.1 403 Forbidden");
        echo <<<HTML
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>$title</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(to bottom, #7f1d1d, #b91c1c);
            color: white;
            font-family: sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            text-align: center;
            animation: shake 0.6s infinite;
        }
        @keyframes shake {
            0% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            50% { transform: translateX(10px); }
            75% { transform: translateX(-10px); }
            100% { transform: translateX(0); }
        }
        .warning-box {
            padding: 2rem;
            background: rgba(0,0,0,0.3);
            border-radius: 10px;
            box-shadow: 0 0 20px black;
        }
    </style>
</head>
<body>
    <div class="warning-box">
        <h1>⚠️ $title</h1>
        <p>$message</p>
    </div>
</body>
</html>
HTML;
        exit;
    }
}
