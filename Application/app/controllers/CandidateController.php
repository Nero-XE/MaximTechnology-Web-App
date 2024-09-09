<?php
//CRUD-контроллер анкеты кандидата
function config() {
    global $pdo;
    session_start();
    require_once '../../config/database.php';
}

function report($name, $type, $execute) {
    switch ($type) {
        case "msg":
            $log = date('Y-m-d H:i:s') . " Пользователь {$_SESSION['user']['login']} добавил кандидата - \"$name\"";
            file_put_contents(__DIR__ . '/../../logs/app.log', $log . PHP_EOL, FILE_APPEND);
            break;
        case "del":
            $log = date('Y-m-d H:i:s') . " Пользователь {$_SESSION['user']['login']} удалил кандидата - \"$name\"";
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
    header("Location: ../views/main.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addCandidate'])) {
    config();
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

        // Подготовка запроса для добавления нового статуса кандидата
        $sql = "INSERT INTO `candidate_profiles` (`full_name`, `candidate_status`, `edu_org`, `practice_target`, `email`, `phone_num`, `res_city`, `edu_city`, `study_course`, `training_direction`, `stack`, `commentary`) VALUES (:full_name, :candidate_status, :edu_org, :practice_target, :email, :phone_num, :res_city, :edu_city, :study_course, :traineeship, :stack, :commentary)";
        $stmt = $pdo->prepare($sql);

        try {
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

            //Подготовка нескольких запросов на вставку данных
            $sql = "INSERT INTO `profiles_status_dates` (`user_id`, `received_date`) VALUES (:user_id, :received_date)";
            $stmt = $pdo->prepare($sql);
            try {
                $stmt->execute([
                    'user_id' => $profile_id,
                    'received_date' => $receiving_date,
                ]);
            } catch (PDOException $e) {
                $e_trans = $e->getMessage();
                report('', "err", $e_trans);
                notify("Ошибка", "Извините, произошла ошибка при записи даты получения анкеты кандидата");
                redirect();
            }

            $sql = "INSERT INTO `moodle` (`profile_id`) VALUES (:profile_id)";
            $stmt = $pdo->prepare($sql);
            try {
                $stmt->execute([
                    'profile_id' => $profile_id
                ]);
            } catch (PDOException $e) {
                $e_trans = $e->getMessage();
                report('', "err", $e_trans);
                notify("Ошибка", "Извините, произошла ошибка при создании аккаунта Moodle для кандидата");
                redirect();
            }

            $sql = "INSERT INTO `tasks` (`profile_id`) VALUES (:profile_id)";
            $stmt = $pdo->prepare($sql);
            try {
                $stmt->execute([
                    'profile_id' => $profile_id
                ]);
            } catch (PDOException $e) {
                $e_trans = $e->getMessage();
                report('', "err", $e_trans);
                notify("Ошибка", "Извините, произошла ошибка при добавлении списка задач Moodle для кандидата");
                redirect();
            }

            $sql = "INSERT INTO `tests` (`profile_id`) VALUES (:profile_id)";
            $stmt = $pdo->prepare($sql);
            try {
                $stmt->execute([
                    'profile_id' => $profile_id
                ]);
            } catch (PDOException $e) {
                $e_trans = $e->getMessage();
                report('', "err", $e_trans);
                notify("Ошибка", "Извините, произошла ошибка при добавлении списка тестов Moodle для кандидата");
                redirect();
            }

            $sql = "INSERT INTO `tests_web` (`profile_id`) VALUES (:profile_id)";
            $stmt = $pdo->prepare($sql);
            try {
                $stmt->execute([
                    'profile_id' => $profile_id
                ]);
            } catch (PDOException $e) {
                $e_trans = $e->getMessage();
                report('', "err", $e_trans);
                notify("Ошибка", "Извините, произошла ошибка при добавлении списка тестов Web-разработчика Moodle для кандидата");
                redirect();
            }

            // Коммитим транзакцию 
            $pdo->commit();

            report($full_name, "msg", '');
            notify("Успешное добавление", "Кандидат \"$full_name\" успешно добавлен");
            redirect();
        } catch (PDOException $e) {
            $e_trans = $e->getMessage();
            report('', "err", $e_trans);
            notify("Ошибка", "Извините, произошла ошибка при добавлении данных для кандидата");
            redirect();
        }
    } catch (PDOException $e) {
        // Откат транзакции если ошибка
        $pdo->rollBack();
        $e_trans = $e->getMessage();
        report('', "err", $e_trans);
        notify("Ошибка", "Извините, произошла ошибка при добавлении кандидата");
        redirect();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delCandidate'])) {
    config();
    $candidate_id = $_POST['candidate_id'];

    // Подготовка запроса для получения ФИО кандидата по его идентификатору
    $sql = "SELECT full_name FROM candidate_profiles WHERE id = :candidate_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'candidate_id' => $candidate_id
    ]);

    // Получение ФИО кандидата
    $candidate = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($candidate) {
        $candidate_name = $candidate['full_name'];

        // Подготовка запроса для удаления кандидата
        $sql = "DELETE FROM candidate_profiles WHERE id = :candidate_id";
        $stmt = $pdo->prepare($sql);

        try {
            $stmt->execute([
                'candidate_id' => $candidate_id
            ]);
            report($candidate_name, "del", '');
            notify("Успешное удаление", "Профиль кандидата \"$candidate_name\" успешно удален");
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