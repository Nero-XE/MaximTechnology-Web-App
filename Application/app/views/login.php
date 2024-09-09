<?php
//Страница авторизации
$pagedescription = "Страница авторизации";
$pagename = "Авторизация"; 
include 'partials/header.php';

if (isset($_SESSION['user'])) {
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
        <h1 class="login-header"><?= $pagename ?></h1>
    </header>
    <main>
        <div class="common-form">
            <img src="../../public/media/images/login-picture.svg" alt="login picture">
            <form action="../controllers/AuthController.php" method="post" id="login-form">
                <img src="../../public/media/images/logo.svg" alt="logo">
                <div class="login-form-wrapper-input">
                    <input type="text" placeholder="Логин" class="inp" name="login">
                    <input type="password" placeholder="Пароль" class="inp" name="password">
                </div>
                <input type="submit" value="Войти" class="btn-primary">
            </form>
        </div>
    </main>
</body>
</html>