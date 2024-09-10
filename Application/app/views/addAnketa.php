<?php
//Страница с добавлением анкеты
require_once '../../config/database.php';
$pagedescription = "Добавление анкеты";
$pagename = "Добавление анкеты"; 
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
        <h1 class="main-header"><?= $pagename ?></h1>
    </header>
    <?php include 'partials/nav.php'; ?>
    <main>
        <div class="main-wrapper">
            <div class="common-form-alt">
                <form action="../controllers/CandidateController.php" method="post" id="add-anket-form">
                    <p class="ankets-type-header">Фамилия Имя Отчество</p>
                    <input type="text" name="full_name" class="inp" placeholder="Иванов Иван Иванович" required>
                    <p class="ankets-type-header">Статус кандидата</p>
                    <select name="candidate_status" class="inp">
                        <?php 
                            $sql = "SELECT * FROM `candidate_statuses`";
                            $stmt = $pdo->query($sql);
                            while ($candidate_status = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                            <option value="<?= $candidate_status['id'] ?>"><?= $candidate_status['status_name'] ?></option>
                        <?php } ?>
                    </select>
                    <p class="ankets-type-header">Электронная почта</p>
                    <input type="email" name="email" class="inp" placeholder="example@mail.com" required>
                    <p class="ankets-type-header">Номер телефона</p>
                    <input type="tel" name="phone_num" class="inp" placeholder="+79008007060" required>
                    <p class="ankets-type-header">Образовательное учреждение</p>
                    <select name="edu_org" class="inp">
                        <?php 
                            $sql1 = "SELECT * FROM `education_organization`";
                            $stmt1 = $pdo->query($sql1);
                            while ($edu_org = $stmt1->fetch(PDO::FETCH_ASSOC)) { ?>
                            <option value="<?= $edu_org['id'] ?>"><?= $edu_org['edu_org_name'] ?></option>
                        <?php } ?>
                    </select>
                    <p class="ankets-type-header">Направление подготвки</p>
                    <input type="text" name="traineeship" class="inp" placeholder="Разработка веб-приложеий" autocomplete="off" required>
                    <p class="ankets-type-header">Город обучения</p>
                    <select name="edu_city" class="inp">
                        <?php 
                            $sql2 = "SELECT * FROM `cities`";
                            $stmt2 = $pdo->query($sql2);
                            while ($city = $stmt2->fetch(PDO::FETCH_ASSOC)) { ?>
                            <option value="<?= $city['id'] ?>"><?= $city['city_name'] ?></option>
                        <?php } ?>
                    </select>
                    <p class="ankets-type-header">Город проживания</p>
                    <select name="res_city" class="inp">
                        <?php 
                            $sql3 = "SELECT * FROM `cities`";
                            $stmt3 = $pdo->query($sql3);
                            while ($city = $stmt3->fetch(PDO::FETCH_ASSOC)) { ?>
                            <option value="<?= $city['id'] ?>"><?= $city['city_name'] ?></option>
                        <?php } ?>
                    </select>
                    <p class="ankets-type-header">Направления выбранные кандидатом</p>
                    <input type="text" name="stack" class="inp" placeholder="PHP, Yii2" autocomplete="off" required>
                    <p class="ankets-type-header">№ курса</p>
                    <select name="study_course" class="inp">
                        <?php 
                            $sql4 = "SELECT * FROM `study_courses`";
                            $stmt4 = $pdo->query($sql4);
                            while ($city = $stmt4->fetch(PDO::FETCH_ASSOC)) { ?>
                            <option value="<?= $city['id'] ?>"><?= $city['course_name'] ?></option>
                        <?php } ?>
                    </select>
                    <p class="ankets-type-header">Цель</p>
                    <select name="practice_target" class="inp">
                        <?php 
                            $sql5 = "SELECT * FROM `practice_goal`";
                            $stmt5 = $pdo->query($sql5);
                            while ($city = $stmt5->fetch(PDO::FETCH_ASSOC)) { ?>
                            <option value="<?= $city['id'] ?>"><?= $city['goal_type'] ?></option>
                        <?php } ?>
                    </select>
                    <div class="form-wrapper-column">
                        <p class="ankets-type-header">Дата получения анкеты</p>
                        <input type="date" name="receiving_date" class="inp">
                    </div>
                    <p class="ankets-type-header">Коментарии</p>
                    <input type="text" name="commentary" class="inp" placeholder="Харакетристика или отзыв" autocomplete="off">
                    <input type="submit" class="btn-primary" value="Создать анкету" name="addCandidate" style="text-align: center;">
                </form>
            </div>
        </div>
    </main>
</body>

</html>