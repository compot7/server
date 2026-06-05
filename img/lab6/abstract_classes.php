<?php

declare(strict_types=1);

abstract class HumanAbstract
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    abstract public function getGreetings(): string;
    abstract public function getMyNameIs(): string;

    public function introduceYourself(): string
    {
        return $this->getGreetings() . '! ' . $this->getMyNameIs() . ' ' . $this->getName() . '.';
    }
}

final class RussianHuman extends HumanAbstract
{
    public function getGreetings(): string
    {
        return 'Привет';
    }

    public function getMyNameIs(): string
    {
        return 'Меня зовут';
    }
}

final class EnglishHuman extends HumanAbstract
{
    public function getGreetings(): string
    {
        return 'Hello';
    }

    public function getMyNameIs(): string
    {
        return 'My name is';
    }
}

$people = [
    new RussianHuman('Иван'),
    new EnglishHuman('John'),
];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab6 — Абстрактные классы</title>
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
        <h1>Абстрактные классы</h1>
        <?php foreach ($people as $person): ?>
            <p><?= htmlspecialchars($person->introduceYourself(), ENT_QUOTES, 'UTF-8') ?></p>
        <?php endforeach; ?>
    </section>
</main>
<footer class="site-footer">Лабораторную выполнил: Клюбин Никита Андреевич</footer>
</body>
</html>
