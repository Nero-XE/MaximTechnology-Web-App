<?php
//Страница с подробной информацией об анкете
require_once '../../config/database.php';
$pagedescription = "Страница с развернутой информацией о кандидате";
$pagename = "Подробнее о кандидате"; 
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
                    <a href="main.php" class="btn-second">Назад</a>
                </nav>
            </div>
            <?php 
                $candidate_id = $_GET['id'];

                $sql = "SELECT candidate_profiles.*, 
                               candidate_status.status_name AS candidate_status,
                               edu_org.edu_org_name AS edu_org,
                               unit_id.unit_name AS unit_id,
                               practice_target.goal_type AS practice_target,
                               cities_edu.city_name AS edu_city, 
                               cities_res.city_name AS res_city,
                               study_course.course_name AS study_course
                        FROM `candidate_profiles`
                        LEFT JOIN `candidate_statuses` AS candidate_status ON candidate_profiles.candidate_status = candidate_status.id
                        LEFT JOIN `education_organization` AS edu_org ON candidate_profiles.edu_org = edu_org.id
                        LEFT JOIN `units` AS unit_id ON candidate_profiles.unit_id = unit_id.id
                        LEFT JOIN `practice_goal` AS practice_target ON candidate_profiles.practice_target = practice_target.id
                        LEFT JOIN `cities` AS cities_edu ON candidate_profiles.edu_city = cities_edu.id 
                        LEFT JOIN `cities` AS cities_res ON candidate_profiles.res_city = cities_res.id 
                        LEFT JOIN `study_courses` AS study_course ON candidate_profiles.study_course = study_course.id 
                        WHERE candidate_profiles.id = :id";

                $stmt = $pdo->prepare($sql);
                $stmt->execute(['id' => $candidate_id]);
                $candidate = $stmt->fetch(PDO::FETCH_ASSOC);

                //Вместо 0 и 1 выводит текст
                function displayValue($value) {
                    if (is_null($value)) {
                        return 'Нет';
                    } elseif ($value == 1) {
                        return 'Да';
                    } else {
                        return 'Неизвестный статус';
                    }
                }

                function displayTestStatus($value) {
                    if (is_null($value)) {
                        return 'Не назначено';
                    } elseif ($value == 0) {
                        return 'Не выполнено';
                    } elseif ($value == 1) {
                        return 'Выполнено';
                    } else {
                        return 'Неизвестный статус';
                    }
                }
                
            ?> 
            <div class="common-form-alt">
                <h1><?= $candidate['full_name'] ?></h1>
                <div class="anketa-info-wrapper">
                    <div class="anketa-info-wrapper-2">
                        <p class="mails-header" style="margin-bottom: 0;">Даты получения анкет</p>
                        <table class="anketa-info" style="width: 100%">
                            <th>
                                Дата получения анкеты
                            </th>
                            <th>
                                Дата отказа по анкете
                            </th>
                            <?php
                                $sql = "SELECT * FROM `profiles_status_dates`
                                WHERE `user_id` = $candidate_id";
                                $stmt = $pdo->query($sql);
                                while ($profile_status_date = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                    <tr>
                                        <td><?= date('d.m.Y', strtotime($profile_status_date['received_date'])) ?></td>
                                        <td><?php
                                        if (is_null($profile_status_date['rejection_date'])) {
                                            echo "—";
                                        } else {
                                        echo date('d.m.Y', strtotime($profile_status_date['rejection_date'])); }
                                        ?></td>
                                    </tr>
                                <?php } ?>
                        </table>
                        <p class="mails-header" style="margin-bottom: 32px;">Новая анкета</p>
                        <form action="../controllers/AddProfileDates.php" method="post" id="add-new-practice" class="universal-form">
                            <input type="hidden" name="profile_id" value="<?= $candidate_id ?>">
                            <div class="form-wrapper-row">
                                <div class="form-wrapper-column">
                                    <p class="ankets-type-header">Дата получения анкеты</p>
                                    <input type="date" name="received_date" class="inp" required>
                                </div>
                                <div class="form-wrapper-column">
                                    <p class="ankets-type-header">Дата отказа по анкете (может не быть)</p>
                                    <input type="date" name="rejection_date" class="inp">
                                </div>
                            </div>
                            <div class="form-control">
                                <input class="btn-primary" type="submit" value="Добавить анкету">
                            </div>
                        </form>
                        <p class="mails-header" style="margin-bottom: 0;">Даты практик</p>
                        <table class="anketa-info" style="width: 100%">
                            <th>
                                Дата начала практики
                            </th>
                            <th>
                                Дата окончания практики
                            </th>
                            <?php
                                $sql = "SELECT * FROM `practice_dates`
                                WHERE `user_id` = $candidate_id";
                                $stmt = $pdo->query($sql);
                                while ($practice_date = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                    <tr>
                                        <td><?= date('d.m.Y', strtotime($practice_date['date_start'])) ?></td>
                                        <td><?php
                                        if (is_null($practice_date['date_end'])) {
                                            echo "—";
                                        } else {
                                        echo date('d.m.Y', strtotime($practice_date['date_end'])); }
                                        ?></td>
                                    </tr>
                                <?php } ?>
                        </table>
                        <p class="mails-header" style="margin-bottom: 32px;">Новая практика</p>
                        <form action="../controllers/AddPractice.php" method="post" id="add-new-practice" class="universal-form">
                            <input type="hidden" name="profile_id" value="<?= $candidate_id ?>">
                            <div class="form-wrapper-row">
                                <div class="form-wrapper-column">
                                    <p class="ankets-type-header">Дата начала практики</p>
                                    <input type="date" name="date_start" class="inp" required>
                                </div>
                                <div class="form-wrapper-column">
                                    <p class="ankets-type-header">Дата окончания практики</p>
                                    <input type="date" name="date_end" class="inp" required>
                                </div>
                            </div>
                            <div class="form-control">
                                <input class="btn-primary" type="submit" value="Добавить практику">
                            </div>
                        </form>
                        <p class="mails-header" style="margin-bottom: 0;">Основная информация</p> 
                        <table class="anketa-info" style="width: 100%">
                            <tr>
                                <td>Статус кандидата</td>
                                <td><?= $candidate['candidate_status'] ?></td>
                            </tr>
                            <tr>
                                <td>Образовательное учреждение</td>
                                <td><?= $candidate['edu_org'] ?></td>
                            </tr>
                            <tr>
                                <td>Отказ по анкете</td>
                                <td><?= displayValue($candidate['profile_rejected']) ?></td>
                            </tr>
                            <tr>
                                <td>Очная практика</td>
                                <td><?= displayValue($candidate['full_time_practice']) ?></td>
                            </tr>
                            <tr>
                                <td>Отдел</td>
                                <td><?= $candidate['unit_id'] ?></td>
                            </tr>
                            <tr>
                                <td>Цель практики</td>
                                <td><?= $candidate['practice_target'] ?></td>
                            </tr>
                            <tr>
                                <td>Практика Moodle</td>
                                <td><?= displayValue($candidate['moodle_practice']) ?></td>
                            </tr>
                            <tr>
                                <td>Трудоустройство</td>
                                <td><?= displayValue($candidate['is_employment']) ?></td>
                            </tr>
                            <tr>
                                <td>Привлечение на оплату</td>
                                <td><?= displayValue($candidate['is_payment']) ?></td>
                            </tr>
                            <tr>
                                <td>Адрес эл. почты</td>
                                <td><?= $candidate['email'] ?></td>
                            </tr>
                            <tr>
                                <td>Номер телефона</td>
                                <td><?= $candidate['phone_num'] ?></td>
                            </tr>
                            <tr>
                                <td>Город проживания</td>
                                <td><?= $candidate['res_city'] ?></td>
                            </tr>
                            <tr>
                                <td>Город обучения</td>
                                <td><?= $candidate['edu_city'] ?></td>
                            </tr>
                            <tr>
                                <td>Курс обучения</td>
                                <td><?= $candidate['study_course'] ?></td>
                            </tr>
                            <tr>
                                <td>Направления обучения (подготовки)</td>
                                <td><?= $candidate['training_direction'] ?></td>
                            </tr>
                            <tr>
                                <td>Стек</td>
                                <td><?= $candidate['stack'] ?></td>
                            </tr>
                            <tr>
                                <td>Результаты собеседования</td>
                                <td><?= displayValue($candidate['softskills']) ?></td>
                            </tr>
                            <tr>
                                <td>Комментарии</td>
                                <td><?= displayValue($candidate['commentary']) ?></td>
                            </tr>
                        </table>
                    </div>
                    <?php 
                        $sql = "SELECT moodle.*, 
                                       moodle_goal.goal_type AS moodle_goal,
                                       moodle_testing_time.date_start AS testing_date_start,
                                       moodle_testing_time.date_end AS testing_date_end,
                                       moodle_tasks_deadline.date_start AS deadline_date_start,
                                       moodle_tasks_deadline.date_end AS deadline_date_end,
                                       moodle_statuses.status_name AS moodle_status
                                FROM `moodle`
                                LEFT JOIN `moodle_goal` ON moodle.moodle_goal = moodle_goal.id
                                LEFT JOIN `moodle_testing_time` ON moodle.testing_time = moodle_testing_time.id 
                                LEFT JOIN `moodle_tasks_deadline` ON moodle.tasks_deadline = moodle_tasks_deadline.id 
                                LEFT JOIN `moodle_statuses` ON moodle.moodle_status = moodle_statuses.id
                                WHERE moodle.profile_id = :id";

                        $stmt = $pdo->prepare($sql);
                        $stmt->execute(['id' => $candidate_id]);
                        $candidate_moodle = $stmt->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <div class="profile-moodle-wrapper">
                        <p class="mails-header" style="margin-bottom: 0;">Moodle</p>                   
                        <table class="anketa-info" style="width: 100%; height: min-content;">
                            <tr>
                                <td>Цель Moodle</td>
                                <td><?= $candidate_moodle['moodle_goal'] ?></td>
                            </tr>
                            <tr>
                                <td>Сроки тестирования</td>
                                <td><?= date('d.m.Y', strtotime($candidate_moodle['testing_date_start'])) ?> — <?= date('d.m.Y', strtotime($candidate_moodle['testing_date_end'])) ?></td>
                            </tr>
                            <tr>
                                <td>Сроки выполнения</td>
                                <td><?= date('d.m.Y', strtotime($candidate_moodle['deadline_date_start'])) ?> — <?= date('d.m.Y', strtotime($candidate_moodle['deadline_date_end'])) ?></td>
                            </tr>
                            <tr>
                                <td>Отказ по Moodle</td>
                                <td><?= displayValue($candidate_moodle['moodle_reject']) ?></td>
                            </tr>
                            <tr>
                                <td>Статус Moodle</td>
                                <td><?= $candidate_moodle['moodle_status'] ?></td>
                            </tr>
                            <tr>
                                <td>Ссылка на профиль Moodle</td>
                                <td><a href="<?= $candidate_moodle['moodle_profile_link'] ?>">Перейти в профиль</a></td>
                            </tr>
                        </table>
                        <div class="mails-wrapper">
                            <p class="mails-header">Сообщения высланные на эл. почту</p>
                            <table class="anketa-info" style="width: 100%; height: min-content; margin-top: 16px">
                                <th>
                                    Тип письма
                                </th>
                                <th>
                                    Дата отпраки письма
                                </th>
                                <?php
                                $sql = "SELECT mails.*, 
                                               mail_type.type_name AS mail_type
                                               FROM `mails` 
                                               LEFT JOIN `mail_type` AS mail_type ON mails.mail_type = mail_type.id 
                                               WHERE `profile_id` = $candidate_id";
                                $stmt = $pdo->query($sql);
                                while ($candidate_mails = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                <tr>
                                    <td><?= $candidate_mails['mail_type'] ?></td>
                                    <td><?= date('d.m.Y', strtotime($candidate_mails['send_date'])) ?></td>
                                </tr>
                                <?php } ?>
                            </table>
                            <p class="mails-header" style="margin-bottom: 0;">Новое письмо</p>
                            <form action="../controllers/AddMail.php" method="post" id="add-new-mail" class="universal-form">
                                <input type="hidden" name="profile_id" value="<?= $candidate_id ?>">
                                <div class="form-wrapper-row">
                                    <div class="form-wrapper-column">
                                        <p class="ankets-type-header">Тип письма</p>
                                        <select name="mail_type" class="inp">
                                            <?php 
                                        $sql = "SELECT * FROM `mail_type`";
                                        $stmt = $pdo->query($sql);
                                        while ($mail_type = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                        <option value="<?= $mail_type['id'] ?>"><?= $mail_type['type_name'] ?></option>
                                        <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-wrapper-column">
                                        <p class="ankets-type-header">Дата отправки письма</p>
                                        <input type="date" name="send_date" class="inp" required>
                                    </div>
                                </div>
                                <div class="form-control">
                                    <input class="btn-primary" type="submit" value="Добавить письмо">
                                </div>
                            </form>
                            <?php 
                                $sql = "SELECT * FROM `tests`
                                        WHERE profile_id = :id";
                                
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute(['id' => $candidate_id]);
                                $candidate_test = $stmt->fetch(PDO::FETCH_ASSOC);
                            ?>
                            <p class="mails-header" style="margin-bottom: 0;">Результаты тестирования</p>
                            <table class="anketa-info" style="width: 100%; height: min-content;">
                                <tr>
                                    <td>Базы данных</td>
                                    <td><?= displayTestStatus($candidate_test['db']) ?></td>
                                </tr>
                                <tr>
                                    <td>C#</td>
                                    <td><?= displayTestStatus($candidate_test['c_sharp']) ?></td>
                                </tr>
                                <tr>
                                    <td>Java</td>
                                    <td><?= displayTestStatus($candidate_test['java']) ?></td>
                                </tr>
                                <tr>
                                    <td>Swift</td>
                                    <td><?= displayTestStatus($candidate_test['swift']) ?></td>
                                </tr>
                                <tr>
                                    <td>Сетевое администрирование</td>
                                    <td><?= displayTestStatus($candidate_test['network_admin']) ?></td>
                                </tr>
                                <tr>
                                    <td>Kotlin</td>
                                    <td><?= displayTestStatus($candidate_test['kotlin']) ?></td>
                                </tr>
                                <tr>
                                    <td>Python</td>
                                    <td><?= displayTestStatus($candidate_test['python']) ?></td>
                                </tr>
                                <tr>
                                    <td>Вербальный и числовой тест</td>
                                    <td><?= displayTestStatus($candidate_test['ver_num']) ?></td>
                                </tr>
                            </table>
                            <?php 
                                $sql = "SELECT * FROM `tests_web`
                                        WHERE profile_id = :id";
                                
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute(['id' => $candidate_id]);
                                $candidate_test_web = $stmt->fetch(PDO::FETCH_ASSOC);
                            ?>
                            <p class="mails-header" style="margin-bottom: 0;">Результаты тестирования (Web-разработка)</p>
                            <table class="anketa-info" style="width: 100%; height: min-content;">
                                <tr>
                                    <td>Общее</td>
                                    <td><?= displayTestStatus($candidate_test_web['common']) ?></td>
                                </tr>
                                <tr>
                                    <td>JavaScript</td>
                                    <td><?= displayTestStatus($candidate_test_web['js']) ?></td>
                                </tr>
                                <tr>
                                    <td>PHP</td>
                                    <td><?= displayTestStatus($candidate_test_web['php']) ?></td>
                                </tr>
                                <tr>
                                    <td>Vue.js</td>
                                    <td><?= displayTestStatus($candidate_test_web['vue']) ?></td>
                                </tr>
                            </table>
                            <?php 
                                $sql = "SELECT * FROM `tasks`
                                        WHERE profile_id = :id";
                                
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute(['id' => $candidate_id]);
                                $candidate_task = $stmt->fetch(PDO::FETCH_ASSOC);
                            ?>
                            <p class="mails-header" style="margin-bottom: 0;">Задания</p>
                            <table class="anketa-info" style="width: 100%; height: min-content;">
                                <tr>
                                    <td>Задания по C#</td>
                                    <td><?= displayTestStatus($candidate_task['c_sharp']) ?></td>
                                </tr>
                                <tr>
                                    <td>Задания по Базам данных</td>
                                    <td><?= displayTestStatus($candidate_task['db']) ?></td>
                                </tr>
                                <tr>
                                    <td>Задания по сетевому администрированию</td>
                                    <td><?= displayTestStatus($candidate_task['network_admin']) ?></td>
                                </tr>
                                <tr>
                                    <td>Задания по Kotlin</td>
                                    <td><?= displayTestStatus($candidate_task['kotlin']) ?></td>
                                </tr>
                                <tr>
                                    <td>Задания по Swift</td>
                                    <td><?= displayTestStatus($candidate_task['swift']) ?></td>
                                </tr>
                                <tr>
                                    <td>Задания по Python</td>
                                    <td><?= displayTestStatus($candidate_task['python']) ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bottom-nav-wrapper">
                <nav class="bottom-nav">
                    <form action="../controllers/DelCandidate.php" method="post">
                        <input type="hidden" name="candidate_id" value="<?= $candidate_id ?>">
                        <input class="btn-primary" type="submit" value="Удалить аккаунт">
                    </form>
                </nav>
            </div>
        </div>
    </main>
</body>

</html>