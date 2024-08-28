<?php
//CRUD-контроллер городов
function config() {
    global $pdo;
    session_start();
    require_once '../../config/database.php';
}

function report($name, $type, $execute) {
    switch ($type) {
        case "msg":
            $log = date('Y-m-d H:i:s') . " Пользователь {$_SESSION['user']['login']} добавил город \"$name\"";
            file_put_contents(__DIR__ . '/../../logs/app.log', $log . PHP_EOL, FILE_APPEND);
            break;
        case "del":
            $log = date('Y-m-d H:i:s') . " Пользователь {$_SESSION['user']['login']} удалил город \"$name\"";
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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addCity'])) {
    config();
    $city_name = trim($_POST["city_name"]);

    // Подготовка запроса для добавления нового города
    $sql = "INSERT INTO `cities` (`city_name`) VALUES (:city_name)";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([
            'city_name' => $city_name
        ]);
        report($city_name, "msg", '');
        notify("Успешное добавление", "Город \"$city_name\" успешно добавлен");
        redirect();
    } catch (PDOException $e) {
        $e_trans = $e->getMessage();
        report('', "err", $e_trans);
        notify("Ошибка", "Извините, произошла ошибка при добавлении города");
        redirect();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delCity'])) {
    config();
    $city_id = $_POST['city'];

    // Подготовка запроса для получения названия города по его идентификатору
    $sql = "SELECT city_name FROM cities WHERE id = :city_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'city_id' => $city_id
    ]);

    // Получение названия города
    $city = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($city) {
        $city_name = $city['city_name'];

        // Подготовка запроса для удаления города
        $sql = "DELETE FROM cities WHERE id = :city_id";
        $stmt = $pdo->prepare($sql);

        try {
            $stmt->execute([
                'city_id' => $city_id
            ]);
            report($city_name, "del", '');
            notify("Успешное удаление", "Город \"$city_name\" успешно удален");
            redirect();
        } catch (PDOException $e) {
            $e_trans = $e->getMessage();
            report('', "err", $e_trans);
            notify("Ошибка", "Извините, произошла ошибка при удалении города");
            redirect();
        }
    }
} else {
    redirect();
}