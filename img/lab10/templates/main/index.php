<?php
/** @var MyProject\Models\Article[] $articles */
?>
<div class="card">
    <h2>Лабораторная 10</h2>
    <p>В этой версии добавлено представление редактирования статьи и маршрут <code>article/{id}/edit</code>.</p>
    <p>
        <a href="<?= APP_BASE_URL ?>/article/1">Открыть статью</a>
        |
        <a href="<?= APP_BASE_URL ?>/article/1/edit">Открыть форму редактирования</a>
    </p>
</div>

<div class="card">
    <h2>Список статей</h2>
    <?php foreach ($articles as $article): ?>
        <article>
            <h3><a href="<?= APP_BASE_URL ?>/article/<?= $article->getId() ?>"><?= htmlspecialchars($article->getName(), ENT_QUOTES, 'UTF-8') ?></a></h3>
            <p><?= nl2br(htmlspecialchars(mb_substr($article->getText(), 0, 120), ENT_QUOTES, 'UTF-8')) ?>...</p>
        </article>
    <?php endforeach; ?>
</div>
