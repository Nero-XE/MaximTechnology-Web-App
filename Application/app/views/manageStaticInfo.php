<?php
//Страница добавления и удаления статических данных
$pagedescription = "Страница добавления и удаления статических данных";
$pagename = "Управление статическими данными"; 
include 'partials/header.php';

if (!isset($_SESSION['user'])) {
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
        <h1 class="main-header">Управление статическими данными</h1>
    </header>
    <main>
        <div class="main-wrapper">
            <div class="top-nav-wrapper">
                <nav class="top-nav">
                    <a href="main.php" class="btn-second">Назад</a>
                </nav>
            </div>
            <div class="common-form-alt" style="border-radius: 0 12px 12px 12px;">
                <div class="static-wrapper">
                    <p class="mails-header" style="margin-top: 16px;">Образовательные учреждения</p>
                    <div class="static-inner-wrapper">
                        <form action="../controllers/EduOrgController.php" method="post" id="add-edu-org" class="universal-form">
                            <p class="ankets-type-header">Добавить образовательное учреждение</p>
                            <input type="text" name="edu_org_name" class="inp" placeholder="Название образовательного учреждения">
                            <div class="form-control">
                                <input class="btn-primary" type="submit" value="Добавить образовательное учреждение" name="addEduOrg">
                            </div>
                        </form>
                        <form action="../controllers/EduOrgController.php" method="post" id="edit-edu-org" class="universal-form">
                            <p class="ankets-type-header">Удалить образовательного учреждения</p>
                            <select name="edu_org" class="inp">
                                <?php 
                                $sql = "SELECT * FROM `education_organization`";
                                $stmt = $pdo->query($sql);
                                while ($edu_org = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                <option value="<?= $edu_org['id'] ?>"><?= $edu_org['edu_org_name'] ?></option>
                                <?php } ?>
                            </select>
                            <div class="form-control">
                                <input class="btn-primary" type="submit" value="Удалить" name="delEduOrg">
                            </div>
                        </form>
                    </div>
                    <p class="mails-header" style="margin-top: 16px;">Города</p>
                    <div class="static-inner-wrapper">
                        <form action="../controllers/CityController.php" method="post" id="add-city" class="universal-form">
                            <p class="ankets-type-header">Добавить город</p>
                            <input type="text" name="city_name" class="inp" placeholder="Название города">
                            <div class="form-control">
                                <input class="btn-primary" type="submit" value="Добавить город" name="addCity">
                            </div>
                        </form>
                        <form action="../controllers/CityController.php" method="post" id="edit-city" class="universal-form">
                            <p class="ankets-type-header">Удалить город</p>
                            <select name="city" class="inp">
                                <?php 
                                $sql1 = "SELECT * FROM `cities`";
                                $stmt1 = $pdo->query($sql1);
                                while ($city = $stmt1->fetch(PDO::FETCH_ASSOC)) { ?>
                                <option value="<?= $city['id'] ?>"><?= $city['city_name'] ?></option>
                                <?php } ?>
                            </select>
                            <div class="form-control">
                                <input class="btn-primary" type="submit" value="Удалить" name="delCity">
                            </div>
                        </form>                  
                    </div>
                    <p class="mails-header" style="margin-top: 16px;">Статусы анкет</p>
                    <div class="static-inner-wrapper">
                        <form action="../controllers/CandidateStatusController.php" method="post" id="add-candidate-statuses" class="universal-form">
                            <p class="ankets-type-header">Добавить статус анкеты</p>
                            <input type="text" name="candidate_status_name" class="inp" placeholder="Название статуса">
                            <div class="form-control">
                                <input class="btn-primary" type="submit" value="Добавить статус" name="addCandStat">
                            </div>
                        </form>
                        <form action="../controllers/CandidateStatusController.php" method="post" id="edit-candidate-statuses" class="universal-form">
                            <p class="ankets-type-header">Удалить статус</p>
                            <select name="candidate_status" class="inp">
                                <?php 
                                $sql2 = "SELECT * FROM `candidate_statuses`";
                                $stmt2 = $pdo->query($sql2);
                                while ($candidate_status = $stmt2->fetch(PDO::FETCH_ASSOC)) { ?>
                                <option value="<?= $candidate_status['id'] ?>"><?= $candidate_status['status_name'] ?></option>
                                <?php } ?>
                            </select>
                            <div class="form-control">
                                <input class="btn-primary" type="submit" value="Удалить" name="delCandStat">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>