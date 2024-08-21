<?php
//Контроллер добавления ОУ
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();
    require_once '../../config/database.php';
    
    $edu_name = trim($_POST["edu_name"]);
    
    $sql = "INSERT INTO `education_organization` (`id`, `edu_org_name`) VALUES (NULL, :edu_name)";
    $stmt = $pdo->prepare($sql);
    
    try {
        $stmt->execute([
            'edu_name' => $edu_name
        ]);
        $log = date('Y-m-d H:i:s') . " Пользователь {$_SESSION['user']['login']} добавил ОУ с названием \"$edu_name\"";
        file_put_contents(__DIR__ . '/../../logs/app.log', $log . PHP_EOL, FILE_APPEND);
        $_SESSION['notify'] = "Успешно добавленно ОУ";
        $_SESSION['description'] = "Вы успешно добавили образовательную организацию";
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