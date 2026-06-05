<?php

declare(strict_types=1);

final class Cat
{
    private string $name;
    private string $color;

    public function __construct(string $name, string $color)
    {
        $this->name = $name;
        $this->color = $color;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function sayHello(): string
    {
        return "Меня зовут {$this->name}. Мой цвет: {$this->getColor()}.";
    }
}

$cats = [
    new Cat('Барсик', 'рыжий'),
    new Cat('Муся', 'серый'),
];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab6 — Инкапсуляция</title>
    <link rel="stylesheet" href="/lab6/public/style.css">
</head>
<body>
<header class="site-header">
    <div class="site-header__brand">
        <img class="site-header__logo" src="/lab6/public/logo.png" alt="Логотип МосПолитеха">
        <div>
            <p class="eyebrow">Московский Политех</p>
            <h2 class="site-header__student">Клюбин Никита Андреевич</h2>
        </div>
    </div>
</header>
<main class="container">
    <section class="card">
        <h1>Инкапсуляция</h1>
        <?php foreach ($cats as $cat): ?>
            <p><?= htmlspecialchars($cat->sayHello(), ENT_QUOTES, 'UTF-8') ?></p>
        <?php endforeach; ?>
    </section>
</main>
<footer class="site-footer">Лабораторную выполнил: Клюбин Никита Андреевич</footer>
</body>
</html>
