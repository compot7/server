<?php /** @var MyProject\Models\Article[] $articles */ ?>
<section class="content-card">
    <div class="section-head">
        <div>
            <p class="section-label">База знаний</p>
            <h2>Статьи и материалы</h2>
        </div>
        <a class="button-primary" href="<?= APP_BASE_URL ?>/article/create">Добавить материал</a>
    </div>
    <div class="articles-grid">
        <?php foreach ($articles as $article): ?>
            <article class="article-card">
                <p class="article-card__meta"><?= htmlspecialchars($article->getCreatedAt(), ENT_QUOTES, 'UTF-8') ?> · <?= $article->getReadingTime() ?> мин</p>
                <h3><?= htmlspecialchars($article->getName(), ENT_QUOTES, 'UTF-8') ?></h3>
                <p><?= htmlspecialchars($article->getSummary(), ENT_QUOTES, 'UTF-8') ?></p>
                <div class="hero-card__actions">
                    <a class="text-link" href="<?= APP_BASE_URL ?>/article/<?= $article->getId() ?>">Открыть материал</a>
                    <a class="text-link" href="<?= APP_BASE_URL ?>/article/<?= $article->getId() ?>/edit">Редактировать</a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>
