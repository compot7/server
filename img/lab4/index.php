<?php

declare(strict_types=1);

function tokenizeExpression(string $expression): array
{
    $normalized = preg_replace('/\s+/', '', $expression) ?? '';
    if ($normalized === '') {
        throw new InvalidArgumentException('Выражение не должно быть пустым.');
    }

    if (!preg_match('/^[0-9+\-*\/().]+$/', $normalized)) {
        throw new InvalidArgumentException('Выражение содержит недопустимые символы.');
    }

    preg_match_all('/\d+(?:\.\d+)?|[()+\-*\/]/', $normalized, $matches);
    return normalizeUnaryMinus($matches[0]);
}

function normalizeUnaryMinus(array $tokens): array
{
    $normalized = [];

    foreach ($tokens as $index => $token) {
        $previous = $tokens[$index - 1] ?? null;

        if (
            $token === '-'
            && ($index === 0 || in_array($previous, ['+', '-', '*', '/', '('], true))
        ) {
            $next = $tokens[$index + 1] ?? null;

            if ($next === '(') {
                $normalized[] = '0';
                $normalized[] = '-';
                continue;
            }

            if ($next !== null && is_numeric($next)) {
                $normalized[] = (string) (0 - (float) $next);
                continue;
            }

            throw new InvalidArgumentException('После унарного минуса должно идти число или скобка.');
        }

        if ($index > 0 && $previous === '-' && ($index === 1 || in_array($tokens[$index - 2] ?? null, ['+', '-', '*', '/', '('], true)) && is_numeric($token)) {
            continue;
        }

        $normalized[] = $token;
    }

    return $normalized;
}

function validateTokens(array $tokens): void
{
    $balance = 0;

    foreach ($tokens as $index => $token) {
        if ($token === '(') {
            $balance++;
        }

        if ($token === ')') {
            $balance--;
        }

        if ($balance < 0) {
            throw new InvalidArgumentException('Скобки расставлены неверно.');
        }

        $next = $tokens[$index + 1] ?? null;

        if (in_array($token, ['+', '-', '*', '/'], true) && $next !== null && in_array($next, ['+', '*', '/', ')'], true)) {
            throw new InvalidArgumentException('Обнаружены некорректные операторы подряд.');
        }
    }

    if ($balance !== 0) {
        throw new InvalidArgumentException('Количество открывающих и закрывающих скобок не совпадает.');
    }
}

function parseExpressionRecursive(array $tokens, int &$position): float
{
    $value = parseTermRecursive($tokens, $position);

    while ($position < count($tokens)) {
        $operator = $tokens[$position];
        if ($operator !== '+' && $operator !== '-') {
            break;
        }

        $position++;
        $nextValue = parseTermRecursive($tokens, $position);
        $value = $operator === '+' ? addRecursive($value, $nextValue) : subtractRecursive($value, $nextValue);
    }

    return $value;
}

function parseTermRecursive(array $tokens, int &$position): float
{
    $value = parseFactorRecursive($tokens, $position);

    while ($position < count($tokens)) {
        $operator = $tokens[$position];
        if ($operator !== '*' && $operator !== '/') {
            break;
        }

        $position++;
        $nextValue = parseFactorRecursive($tokens, $position);
        $value = $operator === '*' ? multiplyRecursive($value, $nextValue) : divideRecursive($value, $nextValue);
    }

    return $value;
}

function parseFactorRecursive(array $tokens, int &$position): float
{
    if (!isset($tokens[$position])) {
        throw new InvalidArgumentException('Выражение обрывается раньше времени.');
    }

    $token = $tokens[$position];

    if ($token === '(') {
        $position++;
        $value = parseExpressionRecursive($tokens, $position);
        if (($tokens[$position] ?? null) !== ')') {
            throw new InvalidArgumentException('Не найдена закрывающая скобка.');
        }
        $position++;
        return $value;
    }

    if (!is_numeric($token)) {
        throw new InvalidArgumentException('Ожидалось число или подвыражение в скобках.');
    }

    $position++;
    return (float) $token;
}

function addRecursive(float $left, float $right): float
{
    return $left + $right;
}

function subtractRecursive(float $left, float $right): float
{
    return $left - $right;
}

function multiplyRecursive(float $left, float $right): float
{
    return $left * $right;
}

function divideRecursive(float $left, float $right): float
{
    if ($right == 0.0) {
        throw new InvalidArgumentException('Деление на ноль запрещено.');
    }

    return $left / $right;
}

function evaluateExpression(string $expression): float
{
    $tokens = tokenizeExpression($expression);
    validateTokens($tokens);
    $position = 0;
    $result = parseExpressionRecursive($tokens, $position);

    if ($position !== count($tokens)) {
        throw new InvalidArgumentException('В конце выражения остались лишние символы.');
    }

    return $result;
}

$displayValue = $_GET['result'] ?? '';
$expressionValue = $_GET['expression'] ?? '';
$error = $_GET['error'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $expression = trim($_POST['expression'] ?? '');

    try {
        $result = evaluateExpression($expression);
        header('Location: /lab4/?result=' . urlencode((string) $result) . '&expression=' . urlencode($expression), true, 303);
        exit;
    } catch (Throwable $exception) {
        header('Location: /lab4/?error=' . urlencode($exception->getMessage()) . '&expression=' . urlencode($expression), true, 303);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Лабораторная работа 4</title>
    <link rel="stylesheet" href="/lab4/public/style.css">
</head>
<body>
<header class="site-header">
    <div class="site-header__brand">
        <img class="site-header__logo" src="/lab4/public/logo.png" alt="Логотип МосПолитеха">
        <div>
            <p class="eyebrow">Московский Политех</p>
            <h2 class="site-header__student">Клюбин Никита Андреевич</h2>
        </div>
    </div>
</header>
<main class="calculator-page">
    <section class="calculator-card">
        <p class="eyebrow">Лабораторная работа 4</p>
        <h1>Калькулятор</h1>
        <form method="post" class="calculator-form">
            <label class="display-label">
                Ввод выражения
                <input id="expressionInput" class="display" name="expression" type="text" value="<?= htmlspecialchars($expressionValue, ENT_QUOTES, 'UTF-8') ?>" readonly>
            </label>

            <label class="display-label">
                Результат
                <input class="display display--result" type="text" value="<?= htmlspecialchars($displayValue, ENT_QUOTES, 'UTF-8') ?>" readonly>
            </label>

            <?php if ($error !== ''): ?>
                <p class="message message--error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
            <?php endif; ?>

            <div class="buttons">
                <?php foreach (['(', ')', 'C', '/', '7', '8', '9', '*', '4', '5', '6', '-', '1', '2', '3', '+', '0', '.', '='] as $button): ?>
                    <button
                        type="<?= $button === '=' ? 'submit' : 'button' ?>"
                        class="calc-btn<?= in_array($button, ['=', '+', '-', '*', '/'], true) ? ' calc-btn--accent' : '' ?>"
                        data-value="<?= htmlspecialchars($button, ENT_QUOTES, 'UTF-8') ?>"
                    >
                        <?= htmlspecialchars($button, ENT_QUOTES, 'UTF-8') ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </form>
    </section>
</main>
<footer class="site-footer">Лабораторную выполнил: Клюбин Никита Андреевич</footer>
<script src="/lab4/public/app.js"></script>
</body>
</html>
