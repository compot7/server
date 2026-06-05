<?php
/** @var string $content */
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мой блог</title>
    <link rel="stylesheet" href="<?= APP_BASE_URL ?>/public/style.css">
</head>
<body>
<div class="page-shell">
    <header class="hero">
        <div class="hero__inner">
            <div class="hero__topline">
                <div class="hero__brand">
                    <img class="hero__logo" src="<?= APP_BASE_URL ?>/public/logo.png" alt="Логотип МосПолитеха">
                    <div>
                        <p class="hero__eyebrow">Московский Политех</p>
                        <h1 class="hero__title">Маршруты и простые страницы</h1>
                    </div>
                </div>
                <div class="hero__student">Клюбин Никита Андреевич</div>
            </div>
            <nav class="hero__nav">
                <a href="<?= APP_BASE_URL ?>/">Главная</a>
                <a href="<?= APP_BASE_URL ?>/hello/student">Hello</a>
                <a href="<?= APP_BASE_URL ?>/bye/student">Bye</a>
                <a href="<?= APP_BASE_URL ?>/articles">Статьи</a>
            </nav>
        </div>
    </header>
    <main class="container">
        <?= $content ?>
    </main>
    <footer class="page-footer">Лабораторную выполнил: Клюбин Никита Андреевич</footer>
</div>
</body>
</html>
