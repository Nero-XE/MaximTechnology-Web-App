<?php
// Страница с результатами поиска
require_once '../../config/database.php';
$pagedescription = "Страница результатов поиска";
$pagename = "Резултаты поиска"; 
include 'partials/header.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
} elseif (!isset($_SESSION['search_results'])) {
    header("Location: main.php");
    exit;
}
?>
<body>
<?php if (isset($_SESSION['notify'])) {
        echo '<div id="notify"><img src="../../public/media/images/notify.svg" alt="notify"><div class="notify-text"><b>' . $_SESSION['notify'] . '</b><p>' . $_SESSION['description'] . '</p></div></div>';
    }
    unset($_SESSION['notify']) ?>
    <header>
        <h1 class="main-header"><?= $pagename ?></h1>
    </header>
    <?php include 'partials/nav.php'; ?>
    <main>
        <div class="main-wrapper">
            <div class="common-form-alt">
                <div class="search-wrapper">
                    <form action="../controllers/SearchController.php" method="post" class="search-form-wrapper">
                        <input type="search" placeholder="Поиск анкеты по ФИО" class="inp" name="search" autocomplete="off">
                        <input type="submit" value="Поиск" class="btn-primary">
                    </form>
                </div>
                <div class="ankets-wrapper">
                <?php
                    if (isset($_SESSION['search_results'])) {
                        $sql = "SELECT * FROM `candidate_statuses`";
                        $stmt = $pdo->query($sql);
                        $statuses_with_results = [];

                        // Определение для каких статусов есть результат
                        foreach ($_SESSION['search_results'] as $candidate_profiles) {
                            $statuses_with_results[$candidate_profiles['candidate_status']][] = $candidate_profiles;
                        }

                        // Отображение тех статусов для анкет, для которых есть результат
                        while ($candidate_statuses = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            if (isset($statuses_with_results[$candidate_statuses['id']])) { ?>
                                <div class="ankets-type-wrapper">
                                    <p class="ankets-type-header"><?= $candidate_statuses['status_name'] ?></p>
                                    <?php
                                    foreach ($statuses_with_results[$candidate_statuses['id']] as $candidate_profiles) { ?>
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
                            <?php }
                        }
                        if (empty($statuses_with_results)) {
                            echo '<p>Ничего не найдено</p>';
                        }
                        unset($_SESSION['search_results']);
                    }
                ?>
                </div>
            </div>
        </div>
    </main>
</body>

</html>
