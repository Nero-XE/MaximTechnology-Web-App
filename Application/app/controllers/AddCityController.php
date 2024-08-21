<?php
//Контроллер добавления города
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();
    require_once '../../config/database.php';
    
    $city_name = trim($_POST["city_name"]);
    
    $sql = "INSERT INTO `cities` (`id`, `city_name`) VALUES (NULL, :city_name)";
    $stmt = $pdo->prepare($sql);
    
    try {
        $stmt->execute([
            'city_name' => $city_name
        ]);
        $log = date('Y-m-d H:i:s') . " Пользователь {$_SESSION['user']['login']} добавил город \"$city_name\"";
        file_put_contents(__DIR__ . '/../../logs/app.log', $log . PHP_EOL, FILE_APPEND);
        $_SESSION['notify'] = "Успешно добавленно ОУ";
        $_SESSION['description'] = "Вы успешно добавили город";
        header("Location: ../views/manageStaticInfo.php");
        exit;
    } catch (PDOException $e) {
        $log = date('Y-m-d H:i:s') . " Ошибка соединения приложения с БД. Подробное описание ошибки: {$e->getMessage()}";
        file_put_contents(__DIR__ . '/../../logs/app.log', $log . PHP_EOL, FILE_APPEND);
        header("Location: ../views/manageStaticInfo.php");
        exit;
    }
} else {
    header("Location: ../views/manageStaticInfo.php");
}