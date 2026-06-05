<?php
/** @var MyProject\Models\Article $article */
/** @var MyProject\Models\User|null $author */
?>
<article class="content-card article-view">
    <p class="section-label">Материал</p>
    <h2><?= htmlspecialchars($article->getName(), ENT_QUOTES, 'UTF-8') ?></h2>
    <div class="article-view__meta">
        <span>Автор: <strong><?= htmlspecialchars($author?->getNickname() ?? 'Неизвестно', ENT_QUOTES, 'UTF-8') ?></strong></span>
        <span>Время чтения: <strong><?= $article->getReadingTime() ?> мин</strong></span>
        <span>Статус: <strong><?= $article->getStatus() === 'published' ? 'Опубликовано' : 'Черновик' ?></strong></span>
    </div>
    <p class="article-view__summary"><?= htmlspecialchars($article->getSummary(), ENT_QUOTES, 'UTF-8') ?></p>
    <div class="article-view__text">
        <?= nl2br(htmlspecialchars($article->getText(), ENT_QUOTES, 'UTF-8')) ?>
    </div>
    <div class="hero-card__actions">
        <a class="button-primary" href="<?= APP_BASE_URL ?>/article/<?= $article->getId() ?>/edit">Редактировать</a>
        <a class="button-secondary" href="<?= APP_BASE_URL ?>/articles">Вернуться к списку</a>
    </div>
</article>
