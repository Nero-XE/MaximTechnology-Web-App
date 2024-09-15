<?php
function config() {
    global $pdo;
    session_start();
    require_once '../../config/database.php';
}

function report($type, $execute) {
    switch ($type) {
        case "msg":
            $log = date('Y-m-d H:i:s') . " Пользователь {$_SESSION['user']['login']} успешно авторизовался";
            file_put_contents(__DIR__ . '/../../logs/app.log', $log . PHP_EOL, FILE_APPEND);
            break;
        case "err":
            $log = date('Y-m-d H:i:s') . " Ошибка соединения приложения с БД. Подробное описание ошибки: {$execute}";
            file_put_contents(__DIR__ . '/../../logs/app.log', $log . PHP_EOL, FILE_APPEND);
            break;
    }
}

function notify($header, $description) {
    $_SESSION['notify'] = $header;
    $_SESSION['description'] = $description;
}

//Контроллер авторизации
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['auth'])) {
    config();

    $sql = "SELECT * FROM `users` WHERE `login` = :login";
    $stmt = $pdo->prepare($sql);
    $stmt -> bindParam(":login", $_POST['login']);

    try {
        $stmt -> execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($_POST['password'], $user['password'])) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'login' => $user['login']
            ];

            report("msg", '');
            notify("Успешная авторизация", "Вы успешно авторизовались в системе");

            header("Location: ../views/main.php");
            exit;
        }
        else {
            notify("Ошибка авторизации", "Пользователь с предоставленными учетными данными не найден");

            header('Location: ../views/login.php');
            exit;
        }
    } 
    catch (PDOException $e) {
        $e_trans = $e->getMessage();
        report("err", $e_trans);
        notify("Ошибка", "Извините, произошла ошибка при авторизации");

        header('Location: ../views/login.php');
        exit;
    }
}
else {
    header('Location: ../views/login.php');
    exit;
}