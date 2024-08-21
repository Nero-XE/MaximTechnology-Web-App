<?php
//Контроллер удаления кандидата
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();
    require_once '../../config/database.php';
    
    $candidate_id = $_POST["candidate_id"];
    
    $sql = "DELETE FROM `candidate_profiles` WHERE `candidate_profiles`.`id` = :candidate_id";
    $stmt = $pdo->prepare($sql);
    
    try {
        $log = date('Y-m-d H:i:s') . " Пользователь {$_SESSION['user']['login']} удалил анкету с ИД \"$candidate_id\"";
        file_put_contents(__DIR__ . '/../../logs/app.log', $log . PHP_EOL, FILE_APPEND);
        $stmt->execute([
            'candidate_id' => $candidate_id
        ]);
        $_SESSION['notify'] = "Успешно удолена анкета";
        $_SESSION['description'] = "Вы успешно удалили анкету кандидата";
        header("Location: ../views/main.php");
        exit;
    } catch (PDOException $e) {
        $log = date('Y-m-d H:i:s') . " Ошибка соединения приложения с БД. Подробное описание ошибки: {$e->getMessage()}";
        file_put_contents(__DIR__ . '/../../logs/app.log', $log . PHP_EOL, FILE_APPEND);
        header("Location: ../views/main.php");
        exit;
    }
} else {
    header("Location: ../views/main.php");
}