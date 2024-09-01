<?php 
session_start();
require_once 'config/database.php';
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Страница подключения">
    <meta name="author" content="Кошкаров Дмитрий">
    <link rel="stylesheet" href="public/css/style.css">
    <script src="public/js/script.js"></script>
    <link rel="shortcut icon" href="public/favicon.ico" type="image/x-icon">
    <title>Загрузка...</title>
    <style>
        html {
            --text-w: #fff;
            --background-light: #fff;
            --background-dark-light: #d5f0ed;
            --background-turquoise: #13b2a4;
        }

        body {
            background-color: var(--background-dark-light);
        }

        #notify {
            max-width: 350px;
            position: absolute;
            top: 32px;
            right: -256px;
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            padding: 24px;
            gap: 16px;
            border-radius: 12px;
            font-size: 14px;
            background-color: var(--background-turquoise);
            color: var(--text-w);
            opacity: 0;
            transition: all .5s ease-in-out;
            z-index: 1000;
        }

        #notify.visible {
            opacity: 1;
            right: 32px;
        }

        #logo-index {
            opacity: 0;
            transition: all .5s ease-in-out;
        }

        #logo-index.visible {
            opacity: 1;
        }

        progress::-webkit-progress-bar {
            background-color: var(--background-light);
        }

        progress::-webkit-progress-value {
            background-color: var(--background-turquoise)
        }
    </style>
</head>
<body>
    <?php if (isset($_SESSION['notify'])) {
        $log = date('Y-m-d H:i:s') . " Ошибка подключения к БД. Подробное описание ошибки: {$e->getMessage()}";
        file_put_contents(__DIR__ . '/logs/app.log', $log . PHP_EOL, FILE_APPEND);
        echo '<div id="notify"><img src="public/media/images/notify.svg" alt="notify"><div class="notify-text"><b>' . $_SESSION['notify'] . '</b><p>' . $_SESSION['description'] . '</p></div></div>';
    } else {
        $log = date('Y-m-d H:i:s') . " Успешное подключение к БД";
        file_put_contents(__DIR__ . '/logs/app.log', $log . PHP_EOL, FILE_APPEND);
        echo '<script>setTimeout(function(){ window.location.href = "app/views/login.php"; }, 1500);</script>';
    }
    unset($_SESSION['notify']) ?>
    </div>
    <main>
        <div class="loading-wrapper" style="aspect-ratio: 1 / 1;">
            <img src="public/media/images/logo.svg" alt="logo" id="logo-index">
        </div>
    </main>
</body>
</html>