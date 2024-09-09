<?php 
session_start();
require_once '../../config/database.php';

if (!isset($pdo)) {
    $log = date('Y-m-d H:i:s') . " Ошибка соединения приложения с БД. Подробное описание ошибки: {$e->getMessage()}";
    file_put_contents(__DIR__ . '/../../logs/app.log', $log . PHP_EOL, FILE_APPEND);
    header("Location: ../../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $pagedescription ?>">
    <meta name="author" content="Кошкаров Дмитрий">
    <link rel="stylesheet" href="../../public/css/style.css">
    <script src="../../public/js/script.js"></script>
    <link rel="shortcut icon" href="../../public/favicon.ico" type="image/x-icon">
    <title><?= $pagename ?></title>
    <style>
        :root {
            --text-b: #000;
            --text-w: #fff;
            --text-half-trans: #00000040;
            --background-half-trans: #0000000d;
            --background-dark-half-trans: #00000026;
            --background-light: #fff;
            --background-dark-light: #d5f0ed;
            --background-turquoise: #13b2a4;
            --background-dark-turquoise: #005859;
        }

        ::-webkit-scrollbar-track {
            background: var(--background-light)
        }

        ::-webkit-scrollbar-thumb {
            background-color: var(--background-turquoise);
            border: 4px solid var(--background-light);
        }

        body {
            background-color: var(--background-dark-light);
        }

        .login-header, .main-header {
            color: var(--text);
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

        .top-nav {
            background-color: var(--background-light);
        }

        .bottom-nav {
            background-color: var(--background-light);
        }

        .common-form {
            background-color: var(--background-light);
        }

        .common-form-alt {
            background-color: var(--background-light);
        }

        .ankets-type-header {
            color: var(--text-half-trans);
        }

        .anketa-item {
            background-color: var(--background-half-trans);
        }

        .anketa-info {
            background-color: var(--background-half-trans);
        }

        .anketa-info tr td, th {
            border: 1px solid var(--background-dark-half-trans);
        }

        .inp {
            background-color: var(--background-half-trans);
        }

        .inp::-webkit-input-placeholder {
            color: var(--text-half-trans);
        }

        .btn-primary {
            color: var(--text-w);
            background-color: var(--background-turquoise);
        }

        .btn-primary:hover {
            background-color: var(--background-dark-turquoise);
        }

        .btn-second {
            color: var(--text-b);
            background-color: var(--background-half-trans);
        }

        .btn-second:hover {
            background-color: var(--background-dark-half-trans);
        }

        progress::-webkit-progress-bar {
            background-color: var(--background-light);
        }

        progress::-webkit-progress-value {
            background-color: var(--background-turquoise)
        }

        .nav-bar {
            background-color: var(--background-light);
            box-shadow: inset -1px 0 0 var(--background-dark-half-trans);
        }

        .nav-separator {
            background-color: var(--background-dark-half-trans);
        }
    </style>
</head>