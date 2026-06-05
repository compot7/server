<?php
/** @var string $username */
?>
<div class="card">
    <h2>Привет, <?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8') ?>!</h2>
    <p>Страница приветствия продолжает использовать свой собственный title.</p>
</div>
