<?php

declare(strict_types=1);

interface CalculateSquare
{
    public function calculateSquare(): float;
}

final class Rectangle implements CalculateSquare
{
    public function __construct(private float $width, private float $height)
    {
    }

    public function calculateSquare(): float
    {
        return $this->width * $this->height;
    }
}

final class Circle implements CalculateSquare
{
    public function __construct(private float $radius)
    {
    }

    public function calculateSquare(): float
    {
        return pi() * $this->radius ** 2;
    }
}

final class Printer
{
}

function describeSquare(object $object): string
{
    $className = get_class($object);

    if (!$object instanceof CalculateSquare) {
        return "Объект класса {$className} не реализует интерфейс CalculateSquare.";
    }

    return "Площадь для объекта класса {$className}: " . round($object->calculateSquare(), 2);
}

$objects = [
    new Rectangle(4, 7),
    new Circle(5),
    new Printer(),
];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab6 — Интерфейсы</title>
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
        <h1>Интерфейсы в PHP</h1>
        <?php foreach ($objects as $object): ?>
            <p><?= htmlspecialchars(describeSquare($object), ENT_QUOTES, 'UTF-8') ?></p>
        <?php endforeach; ?>
    </section>
</main>
<footer class="site-footer">Лабораторную выполнил: Клюбин Никита Андреевич</footer>
</body>
</html>
