<?php

declare(strict_types=1);

$workTitle = 'Лабораторная работа 1';
$studentName = 'Клюбин Никита Андреевич';
$greeting = sprintf('Привет! Сегодня %s, а текущее время: %s.', date('d.m.Y'), date('H:i:s'));
$facts = [
    'PHP на этой странице выполняется на сервере.',
    'Контент внутри блока ниже меняется при каждом обновлении страницы.',
];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($workTitle, ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="/lab1/public/style.css">
</head>
<body>
<header class="site-header">
    <div class="site-header__brand">
        <img class="site-header__logo" src="/lab1/public/logo.png" alt="Логотип МосПолитеха">
        <div>
            <p class="site-header__eyebrow">Московский Политех</p>
            <h1 class="site-header__title"><?= htmlspecialchars($workTitle, ENT_QUOTES, 'UTF-8') ?></h1>
        </div>
    </div>
    <div class="site-header__student">
        <span>Студент</span>
        <strong><?= htmlspecialchars($studentName, ENT_QUOTES, 'UTF-8') ?></strong>
    </div>
</header>

<main class="container">
    <section class="card hero-card">
        <p class="eyebrow">Динамический контент</p>
        <h2><?= htmlspecialchars($greeting, ENT_QUOTES, 'UTF-8') ?></h2>
    </section>
</main>

<footer class="site-footer">
    <span>задание для самостоятельной работы</span>
    <strong><?= htmlspecialchars($studentName, ENT_QUOTES, 'UTF-8') ?></strong>
</footer>
</body>
</html>
