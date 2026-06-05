<?php
/** @var string $username */
?>
<div class="card">
    <h2>Привет, <?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8') ?>!</h2>
    <p>У этой страницы title задаётся через переменную шаблона.</p>
</div>
