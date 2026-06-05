<?php
/** @var string $content */
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'PolyStudy Hub', ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="<?= APP_BASE_URL ?>/public/style.css">
</head>
<body>
<div class="page-shell">
    <header class="site-header">
        <div class="site-header__inner">
            <div class="site-header__brand">
                <img class="site-header__logo" src="<?= APP_BASE_URL ?>/public/logo.png" alt="Логотип Московского Политеха">
                <div>
                    <p class="site-header__eyebrow">Курсовой проект по серверной веб-разработке</p>
                    <h1 class="site-header__title">PolyStudy Hub</h1>
                </div>
            </div>
            <div class="site-header__student">
                <span>Выполнил студент</span>
                <strong>Клюбин Никита Андреевич</strong>
            </div>
        </div>
        <nav class="site-nav">
            <a href="<?= APP_BASE_URL ?>/">Главная</a>
            <a href="<?= APP_BASE_URL ?>/about">О проекте</a>
            <a href="<?= APP_BASE_URL ?>/articles">Статьи</a>
            <a href="<?= APP_BASE_URL ?>/calculator">Калькулятор нагрузки</a>
        </nav>
    </header>
    <main class="container">
        <?= $content ?>
    </main>
    <footer class="site-footer">
        <div>
            <strong>PolyStudy Hub</strong>
            <p>Учебный курсовой проект на PHP MVC с MySQL, статьями и расчётами на основе параметров пользователя.</p>
        </div>
        <div>
            <span>Студент:</span>
            <strong>Клюбин Никита Андреевич</strong>
        </div>
    </footer>
</div>
</body>
</html>
