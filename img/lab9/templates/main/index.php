<?php
/** @var MyProject\Models\Article[] $articles */
?>
<div class="card">
    <h2>Лабораторная 9</h2>
    <p>В этой версии статья подгружает автора из таблицы <code>users</code> и выводит его <code>nickname</code>.</p>
    <p>
        <a href="<?= APP_BASE_URL ?>/article/1">Открыть статью с автором</a>
        |
        <a href="<?= APP_BASE_URL ?>/bye/student">Открыть bye</a>
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
