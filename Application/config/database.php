<?php
//Подключение к БД
$host = 'localhost';
$dbname = 'maxim_technology';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql: host=$host; dbname=$dbname;", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $_SESSION['notify'] = "Ошибка соединения с БД";
    $_SESSION['description'] = "Код ошибки: {$e->getMessage()}";
}