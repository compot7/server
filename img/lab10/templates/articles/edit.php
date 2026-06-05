<?php
/** @var MyProject\Models\Article $article */
?>
<div class="card">
    <p><a href="<?= APP_BASE_URL ?>/article/<?= $article->getId() ?>">Назад к статье</a></p>
    <h1>Редактирование статьи</h1>
    <form method="post" action="<?= APP_BASE_URL ?>/article/<?= $article->getId() ?>/edit">
        <div class="field">
            <label for="name">Заголовок</label>
            <input id="name" name="name" type="text" required value="<?= htmlspecialchars($article->getName(), ENT_QUOTES, 'UTF-8') ?>">
        </div>
        <div class="field">
            <label for="text">Текст</label>
            <textarea id="text" name="text" rows="10" required><?= htmlspecialchars($article->getText(), ENT_QUOTES, 'UTF-8') ?></textarea>
        </div>
        <button type="submit">Сохранить</button>
    </form>
</div>
