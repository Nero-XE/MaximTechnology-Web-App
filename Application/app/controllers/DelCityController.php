<?php
//Контроллер удаления города
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();
    require_once '../../config/database.php';
    
    $city_id = $_POST["city"];
    
    $sql = "DELETE FROM `cities` WHERE `cities`.`id` = :city_id";
    $stmt = $pdo->prepare($sql);
    
    try {
        $log = date('Y-m-d H:i:s') . " Пользователь {$_SESSION['user']['login']} удалил город с ИД \"$city_id\"";
        file_put_contents(__DIR__ . '/../../logs/app.log', $log . PHP_EOL, FILE_APPEND);
        $stmt->execute([
            'city_id' => $city_id
        ]);
        $_SESSION['notify'] = "Успешно удолен город";
        $_SESSION['description'] = "Вы успешно удалили город";
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