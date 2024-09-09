<?php
//Страница со статистикой
require_once '../../config/database.php';
$pagedescription = "Страница со статистикой";
$pagename = "Статистика"; 
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
            <?php
                //Получение всех ОУ
                $sql = "SELECT * FROM education_organization";
                $stmt = $pdo->query($sql);
                $edu_orgs = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $edu_org_counts = [];
                $edu_org_rejected_counts = [];
                $edu_org_practice_counts = [];
                $edu_org_payment_counts = [];
                $total_count = 0;
                $total_rejected = 0;
                $total_practice = 0;
                $total_payment = 0;
                foreach ($edu_orgs as $edu_org) {
                    //Подсчет общего кол-ва анкет
                    $sql = 'SELECT COUNT(*) FROM candidate_profiles';
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $total_count = $stmt->fetchColumn();    

                    //Подсчет общего кол-ва анкет
                    $sql = "SELECT COUNT(*) FROM candidate_profiles WHERE edu_org = :edu_org_id";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(['edu_org_id' => $edu_org['id']]);
                    $edu_org_counts[$edu_org['edu_org_name']] = $stmt->fetchColumn();

                    //Подсчет общего кол-ва отказов 
                    $sql = "SELECT COUNT(*) FROM candidate_profiles WHERE edu_org = :edu_org_id AND profile_rejected = 1";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(['edu_org_id' => $edu_org['id']]);
                    $edu_org_rejected_counts[$edu_org['edu_org_name']] = $stmt->fetchColumn();
                    $total_rejected += $edu_org_rejected_counts[$edu_org['edu_org_name']];
            
                    //Подсчет общего кол-ва практик
                    $sql = "SELECT COUNT(*) FROM candidate_profiles WHERE edu_org = :edu_org_id AND candidate_status = 4";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(['edu_org_id' => $edu_org['id']]);
                    $edu_org_practice_counts[$edu_org['edu_org_name']] = $stmt->fetchColumn();
                    $total_practice += $edu_org_practice_counts[$edu_org['edu_org_name']];
            
                    //Подсчет общего кол-ва привлечений на оплату
                    $sql = "SELECT COUNT(*) FROM candidate_profiles WHERE edu_org = :edu_org_id AND is_payment = 1";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(['edu_org_id' => $edu_org['id']]);
                    $edu_org_payment_counts[$edu_org['edu_org_name']] = $stmt->fetchColumn();
                    $total_payment += $edu_org_payment_counts[$edu_org['edu_org_name']];
                }
            ?>
            <div class="common-form-alt">
                <h1>Статистика по ОУ</h1>
                <div class="anketa-info-wrapper">
                    <table class="anketa-info statistic-table" style="width: 100%; height: min-content;">
                        <th></th>
                        <th>
                            СВОД
                        </th>
                        <?php foreach ($edu_orgs as $edu_org): ?>
                            <th><?= htmlspecialchars($edu_org['edu_org_name']) ?></th>
                        <?php endforeach; ?>
                        <tr>
                            <td>Всего анкет</td>
                            <td><?= $total_count ?></td>
                            <?php foreach ($edu_orgs as $edu_org): ?>
                                <td><?= $edu_org_counts[$edu_org['edu_org_name']] ?></td>
                            <?php endforeach; ?>
                        </tr>
                        <tr>
                            <td>Отказ</td>
                            <td><?= $total_rejected ?></td>
                            <?php foreach ($edu_orgs as $edu_org): ?>
                                <td><?= $edu_org_rejected_counts[$edu_org['edu_org_name']] ?></td>
                            <?php endforeach; ?>
                        </tr>
                        <tr>
                            <td>Практика</td>
                            <td><?= $total_practice ?></td>
                            <?php foreach ($edu_orgs as $edu_org): ?>
                                <td><?= $edu_org_practice_counts[$edu_org['edu_org_name']] ?></td>
                            <?php endforeach; ?>
                        </tr>
                        <tr>
                            <td>Привлечение на оплату</td>
                            <td><?= $total_payment ?></td>
                            <?php foreach ($edu_orgs as $edu_org): ?>
                                <td><?= $edu_org_payment_counts[$edu_org['edu_org_name']] ?></td>
                            <?php endforeach; ?>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </main>
</body>

</html>