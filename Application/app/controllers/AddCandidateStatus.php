<?php
//Контроллер добавления сатуса анкеты
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();
    require_once '../../config/database.php';
    
    $candidate_status_name = trim($_POST["candidate-status-name"]);
    
    $sql = "INSERT INTO `candidate_statuses` (`id`, `status_name`) VALUES (NULL, :candidate_status_name)";
    $stmt = $pdo->prepare($sql);
    
    try {
        $stmt->execute([
            'candidate_status_name' => $candidate_status_name
        ]);
        $log = date('Y-m-d H:i:s') . " Пользователь {$_SESSION['user']['login']} добавил город \"$candidate_status_name\"";
        file_put_contents(__DIR__ . '/../../logs/app.log', $log . PHP_EOL, FILE_APPEND);
        $_SESSION['notify'] = "Успешно добавлен статус";
        $_SESSION['description'] = "Вы успешно добавили статус кандидата";
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