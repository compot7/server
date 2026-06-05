<?php
/** @var MyProject\Models\Article[] $articles */
?>
<div class="card">
    <h2>Статьи</h2>
    <?php foreach ($articles as $article): ?>
        <article>
            <h3><a href="<?= APP_BASE_URL ?>/article/<?= $article->getId() ?>"><?= htmlspecialchars($article->getName(), ENT_QUOTES, 'UTF-8') ?></a></h3>
            <p><?= nl2br(htmlspecialchars(mb_substr($article->getText(), 0, 150), ENT_QUOTES, 'UTF-8')) ?>...</p>
        </article>
    <?php endforeach; ?>
</div>
