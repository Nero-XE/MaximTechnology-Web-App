<?php
//Контроллер добавления пиьсма
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();
    require_once '../../config/database.php';
    
    $profile_id = $_POST["profile_id"];
    $mail_type = $_POST["mail_type"];
    $send_date = $_POST["send_date"];
    
    $sql = "INSERT INTO `mails` (`id`, `profile_id`, `mail_type`, `send_date`) VALUES (NULL, :profile_id, :mail_type, :send_date)";
    $stmt = $pdo->prepare($sql);
    
    try {
        $stmt->execute([
            'profile_id' => $profile_id,
            'mail_type' => $mail_type,
            'send_date' => $send_date
        ]);
        $log = date('Y-m-d H:i:s') . " Пользователь {$_SESSION['user']['login']} добавил письмо для пользвателя с ИД \"$profile_id\"";
        file_put_contents(__DIR__ . '/../../logs/app.log', $log . PHP_EOL, FILE_APPEND);
        $_SESSION['notify'] = "Успешно добавленно письмо";
        $_SESSION['description'] = "Вы успешно добавили письмо";
        header("Location: ../views/profile.php?id=$profile_id");
        exit;
    } catch (PDOException $e) {
        $log = date('Y-m-d H:i:s') . " Ошибка соединения приложения с БД. Подробное описание ошибки: {$e->getMessage()}";
        file_put_contents(__DIR__ . '/../../logs/app.log', $log . PHP_EOL, FILE_APPEND);
        header("Location: ../views/profile.php?id=$profile_id");
        exit;
    }
} else {
    header("Location: ../views/main.php");
}