<?php
/** @var MyProject\Models\Article $article */
/** @var MyProject\Models\User|null $author */
?>
<div class="card">
    <p><a href="<?= APP_BASE_URL ?>/articles">К списку статей</a></p>
    <h2><?= htmlspecialchars($article->getName(), ENT_QUOTES, 'UTF-8') ?></h2>
    <p>Автор: <strong><?= htmlspecialchars($author?->getNickname() ?? 'Неизвестный автор', ENT_QUOTES, 'UTF-8') ?></strong></p>
    <p><?= nl2br(htmlspecialchars($article->getText(), ENT_QUOTES, 'UTF-8')) ?></p>
</div>
