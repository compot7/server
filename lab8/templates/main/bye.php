<?php
/** @var string $name */
?>
<div class="card">
    <h2>Пока, <?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>!</h2>
    <p>Маршрут <code>/bye/name</code> отрабатывает корректно.</p>
</div>
