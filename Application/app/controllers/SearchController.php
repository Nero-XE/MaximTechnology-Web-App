<?php
//Контроллер поиска
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();
    require_once '../../config/database.php';
    
    $search = trim($_POST["search"]);
    
    if (empty($search)) {
        $_SESSION['notify'] = 'Ошибка';
        $_SESSION['description'] = 'Поисковой запрос не может быть пустым.';
        header("Location: ../views/main.php");
        exit;
    }
    
    $sql = "SELECT candidate_profiles.*, 
                    cities_edu.city_name AS edu_city, 
                    cities_res.city_name AS res_city,
                    edu_org.edu_org_name AS edu_org,
                    study_course.course_name AS study_course
                    FROM `candidate_profiles` 
                    LEFT JOIN `cities` AS cities_edu ON candidate_profiles.edu_city = cities_edu.id 
                    LEFT JOIN `cities` AS cities_res ON candidate_profiles.res_city = cities_res.id 
                    LEFT JOIN `education_organization` AS edu_org ON candidate_profiles.edu_org = edu_org.id
                    LEFT JOIN `study_courses` AS study_course ON candidate_profiles.study_course = study_course.id 
                    WHERE `candidate_profiles`.`full_name` LIKE :search";
    $stmt = $pdo->prepare($sql);
    
    try {
        $log = date('Y-m-d H:i:s') . " Пользователь {$_SESSION['user']['login']} выполнил поиск по запросу: \"$search\"";
        file_put_contents(__DIR__ . '/../../logs/app.log', $log . PHP_EOL, FILE_APPEND);
        $stmt->execute([
            'search' => "%$search%"
        ]);
        $_SESSION['search_results'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        header("Location: ../views/search.php");
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
