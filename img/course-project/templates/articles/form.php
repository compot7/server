<?php
/** @var MyProject\Models\Article $article */
/** @var MyProject\Models\User[] $authors */
?>
<section class="content-card">
    <div class="section-head">
        <div>
            <p class="section-label">Администрирование</p>
            <h2><?= htmlspecialchars($title ?? 'Форма статьи', ENT_QUOTES, 'UTF-8') ?></h2>
        </div>
    </div>

    <?php if ($message !== null): ?>
        <p class="form-message"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>

    <form class="project-form" method="post" action="<?= htmlspecialchars($formAction, ENT_QUOTES, 'UTF-8') ?>">
        <label>
            Заголовок
            <input type="text" name="name" required value="<?= htmlspecialchars($article->getName(), ENT_QUOTES, 'UTF-8') ?>">
        </label>
        <label>
            Краткое описание
            <textarea name="summary" rows="3" required><?= htmlspecialchars($article->getSummary(), ENT_QUOTES, 'UTF-8') ?></textarea>
        </label>
        <label>
            Основной текст
            <textarea name="text" rows="10" required><?= htmlspecialchars($article->getText(), ENT_QUOTES, 'UTF-8') ?></textarea>
        </label>
        <div class="project-form__row">
            <label>
                Автор
                <select name="author_id">
                    <?php foreach ($authors as $authorOption): ?>
                        <option value="<?= $authorOption->getId() ?>" <?= $article->getAuthorId() === $authorOption->getId() ? 'selected' : '' ?>>
                            <?= htmlspecialchars($authorOption->getNickname(), ENT_QUOTES, 'UTF-8') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label>
                Статус
                <select name="status">
                    <option value="draft" <?= $article->getStatus() === 'draft' ? 'selected' : '' ?>>Черновик</option>
                    <option value="published" <?= $article->getStatus() === 'published' ? 'selected' : '' ?>>Опубликовано</option>
                </select>
            </label>
        </div>
        <button class="button-primary" type="submit"><?= htmlspecialchars($buttonLabel, ENT_QUOTES, 'UTF-8') ?></button>
    </form>
</section>
