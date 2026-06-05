<?php

declare(strict_types=1);

$page = $_GET['page'] ?? 'form';
$title = $page === 'headers' ? 'Лабораторная работа 2 — Заголовки' : 'Лабораторная работа 2 — Форма';
$studentName = 'Клюбин Никита Андреевич';

function renderHeader(string $title): void
{
    global $studentName;
    ?>
    <header class="site-header">
        <div class="site-header__brand">
            <img class="site-header__logo" src="/lab2/public/logo.png" alt="Логотип МосПолитеха">
            <div>
                <p class="site-header__eyebrow">Московский Политех</p>
                <h1 class="site-header__title"><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></h1>
            </div>
        </div>
        <div class="site-header__student">
            <span>Студент</span>
            <strong><?= htmlspecialchars($studentName, ENT_QUOTES, 'UTF-8') ?></strong>
        </div>
    </header>
    <?php
}

function renderFooter(): void
{
    global $studentName;
    echo '<footer class="site-footer"><span>задание для самостоятельно работы</span><strong>' . htmlspecialchars($studentName, ENT_QUOTES, 'UTF-8') . '</strong></footer>';
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="/lab2/public/style.css">
</head>
<body>
<?php renderHeader($title); ?>
<main class="container">
    <?php if ($page === 'headers'): ?>
        <?php
        $headers = @get_headers('https://httpbin.org/post');
        $headersText = $headers === false ? "Не удалось получить заголовки.\nПроверьте сетевое подключение." : implode(PHP_EOL, $headers);
        ?>
        <section class="card">
            <p class="eyebrow">Страница 2</p>
            <h2>Результат работы функции <code>get_headers</code></h2>
            <textarea class="headers-output" readonly><?= htmlspecialchars($headersText, ENT_QUOTES, 'UTF-8') ?></textarea>
            <a class="action-link" href="/lab2/">Вернуться к форме</a>
        </section>
    <?php else: ?>
        <section class="card">
            <p class="eyebrow">Страница 1</p>
            <h2>Форма обратной связи</h2>
            <form class="feedback-form" method="post" action="https://httpbin.org/post">
                <label>
                    Имя пользователя
                    <input type="text" name="username" required>
                </label>
                <label>
                    E-mail пользователя
                    <input type="email" name="email" required>
                </label>
                <label>
                    Тип обращения
                    <select name="request_type" required>
                        <option value="Жалоба">Жалоба</option>
                        <option value="Предложение">Предложение</option>
                        <option value="Благодарность">Благодарность</option>
                    </select>
                </label>
                <label>
                    Текст обращения
                    <textarea name="message" rows="6" required></textarea>
                </label>
                <fieldset>
                    <legend>Вариант ответа</legend>
                    <label class="inline-option"><input type="checkbox" name="reply_sms" value="sms"> sms</label>
                    <label class="inline-option"><input type="checkbox" name="reply_email" value="email"> e-mail</label>
                </fieldset>
                <div class="form-actions">
                    <button type="submit">Отправить</button>
                    <a class="action-link" href="/lab2/?page=headers">Перейти на 2 страницу</a>
                </div>
            </form>
        </section>
    <?php endif; ?>
</main>
<?php renderFooter(); ?>
</body>
</html>
