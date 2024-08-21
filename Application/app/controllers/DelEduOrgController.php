<?php
//Контроллер удаления ОУ
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();
    require_once '../../config/database.php';
    
    $edu_id = $_POST["edu_org"];
    
    $sql = "DELETE FROM `education_organization` WHERE `education_organization`.`id` = :edu_id";
    $stmt = $pdo->prepare($sql);
    
    try {
        $log = date('Y-m-d H:i:s') . " Пользователь {$_SESSION['user']['login']} удалил ОУ с ИД \"$edu_id\"";
        file_put_contents(__DIR__ . '/../../logs/app.log', $log . PHP_EOL, FILE_APPEND);
        $stmt->execute([
            'edu_id' => $edu_id
        ]);
        $_SESSION['notify'] = "Успешно удолено ОУ";
        $_SESSION['description'] = "Вы успешно удалили образовательную организацию";
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