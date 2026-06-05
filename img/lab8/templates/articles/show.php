<?php
/** @var MyProject\Models\Article $article */
?>
<div class="card">
    <p><a href="<?= APP_BASE_URL ?>/articles">К списку статей</a></p>
    <h2><?= htmlspecialchars($article->getName(), ENT_QUOTES, 'UTF-8') ?></h2>
    <p><?= nl2br(htmlspecialchars($article->getText(), ENT_QUOTES, 'UTF-8')) ?></p>
</div>
