<?php /** @var array $stats */ ?>
<section class="hero-card">
    <div>
        <p class="section-label"><?= htmlspecialchars($greeting, ENT_QUOTES, 'UTF-8') ?>!</p>
        <h2 class="hero-card__title">Сайт для студентов, которые хотят учиться системно и собирать сильное backend-портфолио.</h2>
        <p class="hero-card__lead">На сайте объединены материалы, полезные статьи и калькулятор учебной нагрузки. Это позволяет показать в одном проекте динамический контент, расчёты на основе параметров и полноценную работу с материалами.</p>
        <div class="hero-card__actions">
            <a class="button-primary" href="<?= APP_BASE_URL ?>/articles">Смотреть материалы</a>
            <a class="button-secondary" href="<?= APP_BASE_URL ?>/calculator">Открыть калькулятор</a>
        </div>
    </div>
    <div class="hero-card__aside">
        <div class="metric-card">
            <span>Дата и время</span>
            <strong><?= htmlspecialchars($now, ENT_QUOTES, 'UTF-8') ?></strong>
        </div>
        <div class="metric-card">
            <span>Опубликовано материалов</span>
            <strong><?= (int) $stats['articles'] ?></strong>
        </div>
        <div class="metric-card">
            <span>Среднее время чтения</span>
            <strong><?= (int) $stats['avgReadingTime'] ?> мин</strong>
        </div>
        <div class="metric-card">
            <span>Подготовлено черновиков</span>
            <strong><?= (int) $stats['drafts'] ?></strong>
        </div>
    </div>
</section>

<section class="content-card">
    <div class="section-head">
        <div>
            <p class="section-label">Ключевые функции</p>
            <h3>Что реализовано в курсовом проекте</h3>
        </div>
    </div>
    <div class="feature-grid">
        <article class="feature-item">
            <h4>Динамический элемент</h4>
            <p>На главной странице выводятся приветствие и текущее время на сервере.</p>
        </article>
        <article class="feature-item">
            <h4>Расчёт на основе параметров</h4>
            <p>Калькулятор нагрузки оценивает рекомендуемое число часов подготовки по набору входных параметров.</p>
        </article>
        <article class="feature-item">
            <h4>Работа со статьями</h4>
            <p>Материалы хранятся в базе, отображаются в публичной части и могут дополняться или редактироваться через раздел статей.</p>
        </article>
    </div>
</section>

<section class="content-card">
    <div class="section-head">
        <div>
            <p class="section-label">Свежие публикации</p>
            <h3>Подборка материалов</h3>
        </div>
        <a class="text-link" href="<?= APP_BASE_URL ?>/articles">Все статьи</a>
    </div>
    <div class="articles-grid">
        <?php foreach ($featuredArticles as $article): ?>
            <article class="article-card">
                <p class="article-card__meta"><?= htmlspecialchars($article->getCreatedAt(), ENT_QUOTES, 'UTF-8') ?> · <?= $article->getReadingTime() ?> мин</p>
                <h4><?= htmlspecialchars($article->getName(), ENT_QUOTES, 'UTF-8') ?></h4>
                <p><?= htmlspecialchars($article->getSummary(), ENT_QUOTES, 'UTF-8') ?></p>
                <a class="text-link" href="<?= APP_BASE_URL ?>/article/<?= $article->getId() ?>">Читать материал</a>
            </article>
        <?php endforeach; ?>
    </div>
</section>
