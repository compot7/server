<?php

declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

function renderContactForm(array $row, string $buttonText): string
{
    ob_start();
    $button = $buttonText;
    require __DIR__ . '/form.php';
    return (string) ob_get_clean();
}

function renderAddModule(): string
{
    $status = '';
    $row = [
        'surname' => '',
        'first_name' => '',
        'patronymic' => '',
        'gender' => 'мужской',
        'birth_date' => '',
        'phone' => '',
        'address' => '',
        'email' => '',
        'comment' => '',
    ];

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['button'] ?? '') === 'Добавить запись') {
        $row = [
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
            contactsDb()->prepare(
                'INSERT INTO contacts
                (surname, first_name, patronymic, gender, birth_date, phone, address, email, comment, created_at)
                VALUES (:surname, :first_name, :patronymic, :gender, :birth_date, :phone, :address, :email, :comment, :created_at)'
            )->execute($row + ['created_at' => date('c')]);

            $status = '<p class="success">Запись добавлена</p>';
            foreach ($row as $key => $_) {
                $row[$key] = $key === 'gender' ? 'мужской' : '';
            }
        } catch (Throwable) {
            $status = '<p class="error">Ошибка: запись не добавлена</p>';
        }
    }

    return '<div class="panel"><h2>Добавление записи</h2>' . $status . renderContactForm($row, 'Добавить запись') . '</div>';
}
