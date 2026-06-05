<section class="content-card">
    <div class="section-head">
        <div>
            <p class="section-label">Расчётный модуль</p>
            <h2>Калькулятор учебной нагрузки</h2>
        </div>
    </div>
    <form class="project-form" method="get" action="<?= APP_BASE_URL ?>/calculator">
        <div class="project-form__row">
            <label>
                Количество дисциплин
                <input type="number" name="subjects" min="1" max="12" value="<?= (int) $input['subjects'] ?>">
            </label>
            <label>
                Часов в день на подготовку
                <input type="number" name="hours_per_day" min="1" max="8" value="<?= (int) $input['hours_per_day'] ?>">
            </label>
        </div>
        <div class="project-form__row">
            <label>
                Сложность семестра
                <select name="difficulty">
                    <option value="easy" <?= $input['difficulty'] === 'easy' ? 'selected' : '' ?>>Низкая</option>
                    <option value="middle" <?= $input['difficulty'] === 'middle' ? 'selected' : '' ?>>Средняя</option>
                    <option value="hard" <?= $input['difficulty'] === 'hard' ? 'selected' : '' ?>>Высокая</option>
                </select>
            </label>
            <label>
                Цель по успеваемости
                <select name="target">
                    <option value="pass" <?= $input['target'] === 'pass' ? 'selected' : '' ?>>Просто закрыть</option>
                    <option value="good" <?= $input['target'] === 'good' ? 'selected' : '' ?>>Хорошо</option>
                    <option value="excellent" <?= $input['target'] === 'excellent' ? 'selected' : '' ?>>Отлично</option>
                </select>
            </label>
        </div>
        <button class="button-primary" type="submit">Рассчитать</button>
    </form>

    <div class="feature-grid">
        <article class="feature-item">
            <h4>Рекомендуемая учебная нагрузка</h4>
            <p><strong><?= (int) $weeklyLoad ?> часов в неделю</strong></p>
        </article>
        <article class="feature-item">
            <h4>Рекомендуемое время на отдых</h4>
            <p><strong><?= (int) $restHours ?> часов в неделю</strong></p>
        </article>
        <article class="feature-item">
            <h4>Комментарий</h4>
            <p><?= htmlspecialchars($warning, ENT_QUOTES, 'UTF-8') ?></p>
        </article>
    </div>
</section>
