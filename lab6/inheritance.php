<?php

declare(strict_types=1);

class Lesson
{
    protected string $title;
    protected string $text;
    protected string $homework;

    public function __construct(string $title, string $text, string $homework)
    {
        $this->title = $title;
        $this->text = $text;
        $this->homework = $homework;
    }
}

final class PaidLesson extends Lesson
{
    private float $price;

    public function __construct(string $title, string $text, string $homework, float $price)
    {
        parent::__construct($title, $text, $homework);
        $this->price = $price;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }
}

$lesson = new PaidLesson(
    'Урок о наследовании в PHP',
    'Лол, кек, чебурек',
    'Ложитесь спать, утро вечера мудренее',
    99.90
);

ob_start();
var_dump($lesson);
$dump = ob_get_clean();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab6 — Наследование</title>
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
        <h1>Наследование</h1>
        <pre><?= htmlspecialchars((string) $dump, ENT_QUOTES, 'UTF-8') ?></pre>
    </section>
</main>
<footer class="site-footer">Лабораторную выполнил: Клюбин Никита Андреевич</footer>
</body>
</html>
