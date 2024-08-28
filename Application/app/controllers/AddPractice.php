<?php
//Контроллер добавления практики
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    require_once '../../config/database.php';
    
    $profile_id = $_POST["profile_id"];
    $date_start = $_POST["date_start"];
    $date_end = $_POST["date_end"];
    
    $sql = "INSERT INTO `practice_dates` (`user_id`, `date_start`, `date_end`) VALUES (:profile_id, :date_start, :date_end)";
    $stmt = $pdo->prepare($sql);
    
    try {
        $stmt->execute([
            'profile_id' => $profile_id,
            'date_start' => $date_start,
            'date_end' => $date_end
        ]);
        $log = date('Y-m-d H:i:s') . " Пользователь {$_SESSION['user']['login']} добавил даты практики для пользвателя с ИД \"$profile_id\"";
        file_put_contents(__DIR__ . '/../../logs/app.log', $log . PHP_EOL, FILE_APPEND);
        $_SESSION['notify'] = "Успешно добавленна практики";
        $_SESSION['description'] = "Вы успешно добавили даты практики";
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