<?php
// Контроллер добавления анкеты
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();
    require_once '../../config/database.php';

    $full_name = trim($_POST["full_name"]);
    $candidate_status = trim($_POST["candidate_status"]);
    $email = trim($_POST["email"]);
    $phone_num = trim($_POST["phone_num"]);
    $edu_org = trim($_POST["edu_org"]);
    $traineeship = trim($_POST["traineeship"]);
    $edu_city = trim($_POST["edu_city"]);
    $res_city = trim($_POST["res_city"]);
    $stack = trim($_POST["stack"]);
    $study_course = trim($_POST["study_course"]);
    $practice_target = trim($_POST["practice_target"]);
    $receiving_date = trim($_POST["receiving_date"]);
    $commentary = trim($_POST["commentary"]);

    try {
        // Начинаем транзакцию
        $pdo->beginTransaction();
        
        // Выполняем SQL запрос на вставку данных
        $sql = "INSERT INTO `candidate_profiles` (`full_name`, `candidate_status`, `edu_org`, `practice_target`, `email`, `phone_num`, `res_city`, `edu_city`, `study_course`, `training_direction`, `stack`, `commentary`) VALUES 
        (:full_name, :candidate_status, :edu_org, :practice_target, :email, :phone_num, :res_city, :edu_city, :study_course, :traineeship, :stack, :commentary)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'full_name' => $full_name,
            'candidate_status' => $candidate_status,
            'email' => $email,
            'phone_num' => $phone_num,
            'edu_org' => $edu_org,
            'traineeship' => $traineeship,
            'edu_city' => $edu_city,
            'res_city' => $res_city,
            'stack' => $stack,
            'study_course' => $study_course,
            'practice_target' => $practice_target,
            'commentary' => $commentary
        ]);

        // Получаем ИД последней вставленной записи
        $profile_id = $pdo->lastInsertId();

        // Выполняем несколько SQL запросов на вставку данных
        $sql = "INSERT INTO `profiles_status_dates` (`user_id`, `received_date`) VALUES (:user_id, :received_date)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'user_id' => $profile_id,
            'received_date' => $receiving_date,
        ]);

        $sql = "INSERT INTO `moodle` (`profile_id`) VALUES (:profile_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'profile_id' => $profile_id
        ]);

        $sql = "INSERT INTO `tasks` (`profile_id`) VALUES (:profile_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'profile_id' => $profile_id
        ]);

        $sql = "INSERT INTO `tests` (`profile_id`) VALUES (:profile_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'profile_id' => $profile_id
        ]);

        $sql = "INSERT INTO `tests_web` (`profile_id`) VALUES (:profile_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'profile_id' => $profile_id
        ]);

        // Коммитим транзакцию 
        $pdo->commit();

        $log = date('Y-m-d H:i:s') . " Пользователь {$_SESSION['user']['login']} добавил анкету кандидата \"$full_name\"";
        file_put_contents(__DIR__ . '/../../logs/app.log', $log . PHP_EOL, FILE_APPEND);
        $_SESSION['notify'] = "Успешно добавлен кандидат";
        $_SESSION['description'] = "Вы успешно добавили анкету кандидата";
        header("Location: ../views/main.php");
        exit;
    } catch (PDOException $e) {
        // Откат транзакции если ошибка
        $pdo->rollBack();
        $log = date('Y-m-d H:i:s') . " Ошибка соединения приложения с БД. Подробное описание ошибки: {$e->getMessage()}";
        file_put_contents(__DIR__ . '/../../logs/app.log', $log . PHP_EOL, FILE_APPEND);
        header("Location: ../views/main.php");
        exit;
    } 
} else {
    header("Location: ../views/main.php");
}
