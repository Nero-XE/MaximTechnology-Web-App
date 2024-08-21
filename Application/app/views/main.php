<?php
//Страница со списком всех анкет
require_once '../../config/database.php';
$pagedescription = "Главное меню приложения";
$pagename = "Главная"; 
include 'partials/header.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
?>
<body>
<?php if (isset($_SESSION['notify'])) {
        echo '<div id="notify"><img src="../../public/media/images/notify.svg" alt="notify"><div class="notify-text"><b>' . $_SESSION['notify'] . '</b><p>' . $_SESSION['description'] . '</p></div></div>';
    }
    unset($_SESSION['notify']) ?>
    <header>
        <h1 class="main-header">Главная</h1>
    </header>
    <main>
        <div class="main-wrapper">
            <div class="top-nav-wrapper">
                <nav class="top-nav">
                    <a href="statistic.php" class="btn-second">Статистика</a>
                    <a href="addAnketa.php" class="btn-primary">Добавить анкету</a>
                </nav>
            </div>
            <div class="common-form-alt">
                <div class="search-wrapper">
                    <input type="button" value="Фильтр" class="btn-second">
                    <form action="../controllers/SearchController.php" method="post" class="search-form-wrapper">
                        <input type="search" placeholder="Поиск анкеты по ФИО" class="inp" name="search" autocomplete="off">
                        <input type="submit" value="Поиск" class="btn-primary">
                    </form>
                </div>
                <div class="ankets-wrapper">
                <?php 
                    $sql = "SELECT * FROM `candidate_statuses`";
                    $stmt = $pdo->query($sql);
                    while ($candidate_statuses = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                    <div class="ankets-type-wrapper">
                        <p class="ankets-type-header"><?= $candidate_statuses['status_name'] ?></p>
                        <?php
                        $candidate_statuses_id = $candidate_statuses['id'];
                        $sql1 = "SELECT candidate_profiles.*, 
                                        cities_edu.city_name AS edu_city, 
                                        cities_res.city_name AS res_city,
                                        edu_org.edu_org_name AS edu_org,
                                        study_course.course_name AS study_course
                                        FROM `candidate_profiles` 
                                        LEFT JOIN `cities` AS cities_edu ON candidate_profiles.edu_city = cities_edu.id 
                                        LEFT JOIN `cities` AS cities_res ON candidate_profiles.res_city = cities_res.id 
                                        LEFT JOIN `education_organization` AS edu_org ON candidate_profiles.edu_org = edu_org.id
                                        LEFT JOIN `study_courses` AS study_course ON candidate_profiles.study_course = study_course.id 
                                        WHERE `candidate_status` = '$candidate_statuses_id'";
                        $stmt1 = $pdo->query($sql1);
                        while ($candidate_profiles = $stmt1->fetch(PDO::FETCH_ASSOC)) { ?>
                        <details class="anketa-item">
                            <summary>
                                <?= $candidate_profiles['full_name'] ?>
                                <img src="../../public/media/images/arrow-details.svg" alt="">
                            </summary>
                            <table class="anketa-info" style="width: 50%">
                                <tr>
                                    <td>Телефон</td>
                                    <td><?= $candidate_profiles['phone_num'] ?></td>
                                </tr>
                                <tr>
                                    <td>Электронная почта</td>
                                    <td><?= $candidate_profiles['email'] ?></td>
                                </tr>
                                <tr>
                                    <td>Образовательное учреждение</td>
                                    <td><?= $candidate_profiles['edu_org'] ?></td>
                                </tr>
                                <tr>
                                    <td>Направление</td>
                                    <td><?= $candidate_profiles['training_direction'] ?></td>
                                </tr>
                                <tr>
                                    <td>Город проживания</td>
                                    <td><?= $candidate_profiles['res_city'] ?></td>
                                </tr>
                                <tr>
                                    <td>Город обучения</td>
                                    <td><?= $candidate_profiles['edu_city'] ?></td>
                                </tr>
                                <tr>
                                    <td>Стек</td>
                                    <td><?= $candidate_profiles['stack'] ?></td>
                                </tr>
                                <tr>
                                    <td>Курс</td>
                                    <td><?= $candidate_profiles['study_course'] ?></td>
                                </tr>
                            </table>
                            <div class="ankets-control">
                                <a class="btn-primary" href="profile.php?id=<?= $candidate_profiles['id'] ?>">Подробнee</a>
                                <a class="btn-second" href="">Перейти к Moodle</a>
                            </div>
                        </details>
                        <?php } ?>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="bottom-nav-wrapper">
                <nav class="bottom-nav">
                    <a href="manageStaticInfo.php" class="btn-second">Управление статическими данными</a>
                    <a href="../controllers/LogoutController.php" class="btn-primary">Выход</a>
                </nav>
            </div>
        </div>
    </main>
</body>

</html>