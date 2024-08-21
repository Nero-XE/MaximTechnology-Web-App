<?php
//Контроллер добавления дат полученяи анкет
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();
    require_once '../../config/database.php';
    
    $profile_id = $_POST["profile_id"];
    $received_date = $_POST["received_date"];
    $rejection_date = $_POST["rejection_date"];
    if(empty($rejection_date)) {
        $rejection_date = NULL;
    }
    
    $sql = "INSERT INTO `profiles_status_dates` (`user_id`, `received_date`, `rejection_date`) VALUES (:profile_id, :received_date, :rejection_date)";
    $stmt = $pdo->prepare($sql);
    
    try {
        $stmt->execute([
            'profile_id' => $profile_id,
            'received_date' => $received_date,
            'rejection_date' => $rejection_date
        ]);
        $log = date('Y-m-d H:i:s') . " Пользователь {$_SESSION['user']['login']} добавил даты получения и отказа по анкете для пользвателя с ИД \"$profile_id\"";
        file_put_contents(__DIR__ . '/../../logs/app.log', $log . PHP_EOL, FILE_APPEND);
        $_SESSION['notify'] = "Успешно добавленны даты";
        $_SESSION['description'] = "Вы успешно добавили даты получения и/или отказа анкеты";
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