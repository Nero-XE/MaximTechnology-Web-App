<?php
//Контроллер логаута
session_start();
$log = date('Y-m-d H:i:s') . " Пользователь {$_SESSION['user']['login']} деавторизовался";
file_put_contents(__DIR__ . '/../../logs/app.log', $log . PHP_EOL, FILE_APPEND);
unset($_SESSION['user']);
header("Location: ../views/login.php");
exit;