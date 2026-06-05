<?php

declare(strict_types=1);

define('APP_INCLUDED', true);

require_once __DIR__ . '/menu.php';
require_once __DIR__ . '/viewer.php';
require_once __DIR__ . '/add.php';
require_once __DIR__ . '/edit.php';
require_once __DIR__ . '/delete.php';

$action = $_GET['action'] ?? 'view';
$allowedActions = ['view', 'add', 'edit', 'delete'];
if (!in_array($action, $allowedActions, true)) {
    $action = 'view';
}

$sort = $_GET['sort'] ?? 'created';
$page = max(1, (int) ($_GET['page'] ?? 1));
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Лабораторная работа 5</title>
    <link rel="stylesheet" href="/lab5/public/style.css">
</head>
<body>
<header class="header">
    <div class="header__brand">
        <img src="/lab5/public/logo.png" alt="Логотип МосПолитеха">
        <div>
            <p class="header__eyebrow">Московский Политех</p>
            <h1>Лабораторная работа 5 — Записная книжка</h1>
        </div>
    </div>
    <div class="header__student">Клюбин Никита Андреевич</div>
</header>
<main>
    <?= renderMenu($action, $sort) ?>
    <section class="content">
        <?php
        echo match ($action) {
            'add' => renderAddModule(),
            'edit' => renderEditModule(),
            'delete' => renderDeleteModule(),
            default => renderViewer($sort, $page),
        };
        ?>
    </section>
</main>
<footer><span>задание для самостоятельной работы</span><strong>Клюбин Никита Андреевич</strong></footer>
</body>
</html>
