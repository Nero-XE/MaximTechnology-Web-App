<?php
//Контроллер удаления сатуса анкеты
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();
    require_once '../../config/database.php';
    
    $candidate_status_id = $_POST["candidate_statuses"];
    
    $sql = "DELETE FROM `candidate_statuses` WHERE `candidate_statuses`.`id` = :candidate_status_id";
    $stmt = $pdo->prepare($sql);
    
    try {
        $log = date('Y-m-d H:i:s') . " Пользователь {$_SESSION['user']['login']} удалил статус с ИД \"$candidate_status_id\"";
        file_put_contents(__DIR__ . '/../../logs/app.log', $log . PHP_EOL, FILE_APPEND);
        $stmt->execute([
            'candidate_status_id' => $candidate_status_id
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