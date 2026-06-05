<?php

declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/add.php';

function renderEditModule(): string
{
    $pdo = contactsDb();
    $contacts = $pdo->query('SELECT id, surname, first_name FROM contacts ORDER BY surname ASC, first_name ASC')->fetchAll(PDO::FETCH_ASSOC);

    if ($contacts === []) {
        return '<div class="panel"><h2>Редактирование записи</h2><p>Нет данных для редактирования.</p></div>';
    }

    $selectedId = (int) ($_GET['id'] ?? $contacts[0]['id']);
    $selected = null;
    foreach ($contacts as $contact) {
        if ((int) $contact['id'] === $selectedId) {
            $selected = $contact;
            break;
        }
    }
    if ($selected === null) {
        $selectedId = (int) $contacts[0]['id'];
    }

    $rowStmt = $pdo->prepare('SELECT * FROM contacts WHERE id = :id');
    $rowStmt->execute(['id' => $selectedId]);
    $row = $rowStmt->fetch(PDO::FETCH_ASSOC) ?: [];

    $status = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['button'] ?? '') === 'Сохранить изменения') {
        $row = [
            'id' => $selectedId,
            'surname' => trim($_POST['surname'] ?? ''),
            'first_name' => trim($_POST['first_name'] ?? ''),
            'patronymic' => trim($_POST['patronymic'] ?? ''),
            'gender' => trim($_POST['gender'] ?? ''),
            'birth_date' => trim($_POST['birth_date'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'address' => trim($_POST['address'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'comment' => trim($_POST['comment'] ?? ''),
        ];

        try {
            $pdo->prepare(
                'UPDATE contacts SET
                surname = :surname,
                first_name = :first_name,
                patronymic = :patronymic,
                gender = :gender,
                birth_date = :birth_date,
                phone = :phone,
                address = :address,
                email = :email,
                comment = :comment
                WHERE id = :id'
            )->execute($row);

            $status = '<p class="success">Запись обновлена</p>';
        } catch (Throwable) {
            $status = '<p class="error">Ошибка: запись не обновлена</p>';
        }
    }

    $links = '<div class="div-edit">';
    foreach ($contacts as $contact) {
        $class = (int) $contact['id'] === $selectedId ? 'currentRow' : '';
        $links .= sprintf(
            '<p><a class="%s" href="/lab5/index.php?action=edit&id=%d">%s %s</a></p>',
            $class,
            $contact['id'],
            h($contact['surname']),
            h($contact['first_name'])
        );
    }
    $links .= '</div>';

    return '<div class="panel"><h2>Редактирование записи</h2>' . $links . $status . renderContactForm($row, 'Сохранить изменения') . '</div>';
}
