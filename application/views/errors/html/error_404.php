<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Not Found</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #0d0d0d;
            color: white;
            font-family: Arial, sans-serif;
            overflow: hidden;
            text-align: center;
        }
        .container {
            position: relative;
        }
        h1 {
            font-size: 6rem;
            font-weight: bold;
            text-transform: uppercase;
            position: relative;
            animation: glitch 1s infinite;
        }
        p {
            font-size: 1.5rem;
            margin-top: 10px;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #ff003c;
            color: white;
            text-decoration: none;
            font-size: 1.2rem;
            border-radius: 5px;
            transition: 0.3s;
        }
        a:hover {
            background: #ff5733;
        }
        @keyframes glitch {
            0% { text-shadow: 5px 5px 0px #ff003c, -5px -5px 0px #00ffff; }
            50% { text-shadow: -5px -5px 0px #ff003c, 5px 5px 0px #00ffff; }
            100% { text-shadow: 5px 5px 0px #ff003c, -5px -5px 0px #00ffff; }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>404</h1>
        <p>Oops! Halaman yang Anda cari tidak ditemukan.</p>
		<?php
		$base_url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https" : "http") . "://".$_SERVER['HTTP_HOST'].str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
		?>
		<a href="<?= $base_url; ?>">Kembali ke Beranda</a>
    </div>
</body>
</html>
