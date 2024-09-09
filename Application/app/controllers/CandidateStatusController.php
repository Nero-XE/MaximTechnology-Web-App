<?php
//CRUD-контроллер статусов кандидата
function config() {
    global $pdo;
    session_start();
    require_once '../../config/database.php';
}

function report($name, $type, $execute) {
    switch ($type) {
        case "msg":
            $log = date('Y-m-d H:i:s') . " Пользователь {$_SESSION['user']['login']} добавил статус кандидата - \"$name\"";
            file_put_contents(__DIR__ . '/../../logs/app.log', $log . PHP_EOL, FILE_APPEND);
            break;
        case "del":
            $log = date('Y-m-d H:i:s') . " Пользователь {$_SESSION['user']['login']} удалил статус кандидата - \"$name\"";
            file_put_contents(__DIR__ . '/../../logs/app.log', $log . PHP_EOL, FILE_APPEND);
            break;
        case "err":
            $log = date('Y-m-d H:i:s') . " Ошибка соединения приложения с БД. Подробное описание ошибки: {$execute}";
            file_put_contents(__DIR__ . '/../../logs/app.log', $log . PHP_EOL, FILE_APPEND);
            break;
    }
}

function notify($header, $description) {
    $_SESSION['notify'] = $header;
    $_SESSION['description'] = $description;
}

function redirect() {
    header("Location: ../views/manageStaticInfo.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addCandStat'])) {
    config();
    $candidate_status_name = trim($_POST["candidate_status_name"]);

    // Подготовка запроса для добавления нового статуса кандидата
    $sql = "INSERT INTO `candidate_statuses` (`status_name`) VALUES (:candidate_status_name)";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([
            'candidate_status_name' => $candidate_status_name
        ]);
        report($candidate_status_name, "msg", '');
        notify("Успешное добавление", "Статус кандидата \"$candidate_status_name\" успешно добавлен");
        redirect();
    } catch (PDOException $e) {
        $e_trans = $e->getMessage();
        report('', "err", $e_trans);
        notify("Ошибка", "Извините, произошла ошибка при добавлении статуса кандидата");
        redirect();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delCandStat'])) {
    config();
    $candidate_status_id = $_POST['candidate_status'];

    // Подготовка запроса для получения названия статуса кандидата по его идентификатору
    $sql = "SELECT status_name FROM candidate_statuses WHERE id = :candidate_status_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'candidate_status_id' => $candidate_status_id
    ]);

    // Получение названия статуса кандидата
    $candidate_status = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($candidate_status) {
        $candidate_status_name = $candidate_status['status_name'];

        // Подготовка запроса для удаления статуса кандидата
        $sql = "DELETE FROM candidate_statuses WHERE id = :candidate_status_id";
        $stmt = $pdo->prepare($sql);

        try {
            $stmt->execute([
                'candidate_status_id' => $candidate_status_id
            ]);
            report($candidate_status_name, "del", '');
            notify("Успешное удаление", "Статус кандидата \"$candidate_status_name\" успешно удалено");
            redirect();
        } catch (PDOException $e) {
            $e_trans = $e->getMessage();
            report('', "err", $e_trans);
            notify("Ошибка", "Извините, произошла ошибка при удалении образовательного учреждения");
            redirect();
        }
    }
} else {
    redirect();
}