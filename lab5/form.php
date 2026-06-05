<?php
/** @var array $row */
/** @var string $button */
?>
<form name="form_add" method="post">
    <div class="column">
        <div class="add">
            <label>Фамилия</label>
            <input type="text" name="surname" placeholder="Фамилия" value="<?= h((string) ($row['surname'] ?? '')) ?>">
        </div>
        <div class="add">
            <label>Имя</label>
            <input type="text" name="first_name" placeholder="Имя" value="<?= h((string) ($row['first_name'] ?? '')) ?>">
        </div>
        <div class="add">
            <label>Отчество</label>
            <input type="text" name="patronymic" placeholder="Отчество" value="<?= h((string) ($row['patronymic'] ?? '')) ?>">
        </div>
        <div class="add">
            <label>Пол</label>
            <select name="gender">
                <?php foreach (['мужской', 'женский'] as $gender): ?>
                    <option value="<?= h($gender) ?>" <?= ($row['gender'] ?? '') === $gender ? 'selected' : '' ?>><?= h($gender) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="add">
            <label>Дата рождения</label>
            <input type="date" name="birth_date" value="<?= h((string) ($row['birth_date'] ?? '')) ?>">
        </div>
        <div class="add">
            <label>Телефон</label>
            <input type="text" name="phone" placeholder="Телефон" value="<?= h((string) ($row['phone'] ?? '')) ?>">
        </div>
        <div class="add">
            <label>Адрес</label>
            <input type="text" name="address" placeholder="Адрес" value="<?= h((string) ($row['address'] ?? '')) ?>">
        </div>
        <div class="add">
            <label>Email</label>
            <input type="email" name="email" placeholder="Email" value="<?= h((string) ($row['email'] ?? '')) ?>">
        </div>
        <div class="add">
            <label>Комментарий</label>
            <textarea name="comment" placeholder="Краткий комментарий"><?= h((string) ($row['comment'] ?? '')) ?></textarea>
        </div>
        <button type="submit" value="<?= h($button) ?>" name="button" class="form-btn"><?= h($button) ?></button>
    </div>
</form>
