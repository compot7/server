<?php

declare(strict_types=1);

function solveEquation(string $equation): array
{
    $normalized = preg_replace('/\s+/', '', $equation) ?? '';
    $parts = explode('=', $normalized);
    if (count($parts) !== 2) {
        throw new InvalidArgumentException('Уравнение должно содержать один знак "=".');
    }

    [$left, $right] = $parts;
    $operator = null;
    foreach (['+', '-', '*', '/'] as $candidate) {
        if (strpos($left, $candidate) !== false) {
            $operator = $candidate;
            break;
        }
    }

    if ($operator === null) {
        throw new InvalidArgumentException('Не удалось определить оператор.');
    }

    [$firstOperand, $secondOperand] = explode($operator, $left, 2);
    $unknownPosition = $firstOperand === 'x' ? 'left' : ($secondOperand === 'x' ? 'right' : 'none');

    if ($unknownPosition === 'none') {
        throw new InvalidArgumentException('Неизвестная переменная x должна быть в левой части уравнения.');
    }

    $knownOperand = (float) ($unknownPosition === 'left' ? $secondOperand : $firstOperand);
    $resultValue = (float) $right;

    $x = match ($operator) {
        '+' => $resultValue - $knownOperand,
        '-' => $unknownPosition === 'left' ? $resultValue + $knownOperand : $knownOperand - $resultValue,
        '*' => $resultValue / $knownOperand,
        '/' => $unknownPosition === 'left' ? $resultValue * $knownOperand : $knownOperand / $resultValue,
        default => throw new InvalidArgumentException('Оператор не поддерживается.'),
    };

    return [
        'operator' => $operator,
        'unknownPosition' => $unknownPosition === 'left' ? 'слева от оператора' : 'справа от оператора',
        'value' => $x,
    ];
}

$equation = $_POST['equation'] ?? '27 - x = 17';
$solution = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $solution = solveEquation($equation);
    } catch (Throwable $exception) {
        $error = $exception->getMessage();
    }
} else {
    $solution = solveEquation($equation);
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Лабораторная работа 3</title>
    <link rel="stylesheet" href="/lab3/public/style.css">
</head>
<body>
<header class="site-header">
    <div class="site-header__brand">
        <img class="site-header__logo" src="/lab3/public/logo.png" alt="Логотип МосПолитеха">
        <div>
            <p class="eyebrow">Московский Политех</p>
            <h2 class="site-header__student">Клюбин Никита Андреевич</h2>
        </div>
    </div>
</header>
<main class="container">
    <section class="card">
        <p class="eyebrow">Лабораторная работа 3</p>
        <h1>Решение уравнения</h1>
        <p>Вариант по условию: <code>27 - x = 17</code>.</p>
        <form method="post" class="equation-form">
            <label>
                Введите уравнение
                <input type="text" name="equation" value="<?= htmlspecialchars($equation, ENT_QUOTES, 'UTF-8') ?>">
            </label>
            <button type="submit">Решить</button>
        </form>

        <?php if ($error !== null): ?>
            <p class="message message--error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
        <?php elseif ($solution !== null): ?>
            <div class="solution">
                <p><strong>Оператор:</strong> <?= htmlspecialchars($solution['operator'], ENT_QUOTES, 'UTF-8') ?></p>
                <p><strong>Положение x:</strong> <?= htmlspecialchars($solution['unknownPosition'], ENT_QUOTES, 'UTF-8') ?></p>
                <p><strong>Значение x:</strong> <?= htmlspecialchars((string) $solution['value'], ENT_QUOTES, 'UTF-8') ?></p>
            </div>
        <?php endif; ?>
    </section>

    <section class="card">
        <h2>Блок-схема алгоритма</h2>
        <img src="/lab3/public/flowchart.png" alt="Блок-схема алгоритма решения уравнения" class="flowchart">
    </section>
</main>
<footer class="site-footer">Лабораторную выполнил: Клюбин Никита Андреевич</footer>
</body>
</html>
