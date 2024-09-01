<?php
//CRUD-контроллер образовательных учреждений
function config() {
    global $pdo;
    session_start();
    require_once '../../config/database.php';
}

function report($name, $type, $execute) {
    switch ($type) {
        case "msg":
            $log = date('Y-m-d H:i:s') . " Пользователь {$_SESSION['user']['login']} добавил образовательное учреждение \"$name\"";
            file_put_contents(__DIR__ . '/../../logs/app.log', $log . PHP_EOL, FILE_APPEND);
            break;
        case "del":
            $log = date('Y-m-d H:i:s') . " Пользователь {$_SESSION['user']['login']} удалил образовательное учреждение \"$name\"";
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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addEduOrg'])) {
    config();
    $edu_org_name = trim($_POST["edu_org_name"]);

    // Подготовка запроса для добавления нового города
    $sql = "INSERT INTO `education_organization` (`edu_org_name`) VALUES (:edu_org_name)";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([
            'edu_org_name' => $edu_org_name
        ]);
        report($edu_org_name, "msg", '');
        notify("Успешное добавление", "Образовательное учреждение \"$edu_org_name\" успешно добавлен");
        redirect();
    } catch (PDOException $e) {
        $e_trans = $e->getMessage();
        report('', "err", $e_trans);
        notify("Ошибка", "Извините, произошла ошибка при добавлении образовательного учреждения");
        redirect();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delEduOrg'])) {
    config();
    $edu_id = $_POST['edu_org'];

    // Подготовка запроса для получения названия образовательного учреждения по его идентификатору
    $sql = "SELECT edu_org_name FROM education_organization WHERE id = :edu_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'edu_id' => $edu_id
    ]);

    // Получение названия образовательного учреждения
    $edu = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($edu) {
        $edu_org_name = $edu['edu_org_name'];

        // Подготовка запроса для удаления образовательного учреждения
        $sql = "DELETE FROM `education_organization` WHERE `education_organization`.`id` = :edu_id";
        $stmt = $pdo->prepare($sql);

        try {
            $stmt->execute([
                'edu_id' => $edu_id
            ]);
            report($edu_org_name, "del", '');
            notify("Успешное удаление", "Образовательное учреждение \"$edu_org_name\" успешно удалено");
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