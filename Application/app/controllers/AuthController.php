<?php
//Контроллер авторизации
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    require_once '../../config/database.php';
    
    $login = trim($_POST["login"]);
    $password = trim($_POST["password"]);
    
    $sql = "SELECT * FROM `users` WHERE `login` = :login";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'login' => $login
    ]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'login' => $user['login'],
            'password' => $user['password']
        ];
        $log = date('Y-m-d H:i:s') . " Пользователь {$_SESSION['user']['login']} успешно авторизовался";
        file_put_contents(__DIR__ . '/../../logs/app.log', $log . PHP_EOL, FILE_APPEND);
        $_SESSION['notify'] = "Успешная авторизация";
        $_SESSION['description'] = "Вы успешно авторизовались в системе";
        header("Location: ../views/main.php");
        exit;
    } else {
        $log = date('Y-m-d H:i:s') . "Попытка авторизации";
        file_put_contents(__DIR__ . '/../../logs/app.log', $log . PHP_EOL, FILE_APPEND);
        $_SESSION['notify'] = "Ошибка авторизации";
        $_SESSION['description'] = "Пользователь с предоставленными учетными данными не найден";
        header("Location: ../views/login.php"); 
        exit;
    }
} else {
    header("Location: ../views/login.php"); 
}