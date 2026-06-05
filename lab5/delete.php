<?php

declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

function renderDeleteModule(): string
{
    $pdo = contactsDb();
    $message = '';

    if (isset($_GET['delete_id'])) {
        $deleteId = (int) $_GET['delete_id'];
        $stmt = $pdo->prepare('SELECT surname FROM contacts WHERE id = :id');
        $stmt->execute(['id' => $deleteId]);
        $surname = $stmt->fetchColumn();

        if ($surname !== false) {
            $pdo->prepare('DELETE FROM contacts WHERE id = :id')->execute(['id' => $deleteId]);
            $message = '<p class="success">Запись с фамилией ' . h((string) $surname) . ' удалена</p>';
        }
    }

    $contacts = $pdo->query('SELECT id, surname, first_name, patronymic FROM contacts ORDER BY surname ASC, first_name ASC')->fetchAll(PDO::FETCH_ASSOC);

    $html = '<div class="panel"><h2>Удаление записи</h2>' . $message;
    foreach ($contacts as $contact) {
        $initials = mb_substr($contact['first_name'], 0, 1) . '.' . mb_substr($contact['patronymic'], 0, 1) . '.';
        $html .= sprintf(
            '<p><a href="/lab5/index.php?action=delete&delete_id=%d">%s %s</a></p>',
            $contact['id'],
            h($contact['surname']),
            h($initials)
        );
    }
    $html .= '</div>';

    return $html;
}
