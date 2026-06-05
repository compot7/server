<?php

declare(strict_types=1);

if (!defined('APP_INCLUDED')) {
    http_response_code(403);
    exit('Direct access is forbidden.');
}

function contactsDb(): PDO
{
    static $pdo = null;

    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $databasePath = __DIR__ . '/contacts.sqlite';
    $pdo = new PDO('sqlite:' . $databasePath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec(
        'CREATE TABLE IF NOT EXISTS contacts (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            surname TEXT NOT NULL,
            first_name TEXT NOT NULL,
            patronymic TEXT NOT NULL,
            gender TEXT NOT NULL,
            birth_date TEXT NOT NULL,
            phone TEXT NOT NULL,
            address TEXT NOT NULL,
            email TEXT NOT NULL,
            comment TEXT NOT NULL,
            created_at TEXT NOT NULL
        )'
    );

    $count = (int) $pdo->query('SELECT COUNT(*) FROM contacts')->fetchColumn();
    if ($count === 0) {
        $statement = $pdo->prepare(
            'INSERT INTO contacts
            (surname, first_name, patronymic, gender, birth_date, phone, address, email, comment, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );

        $seedData = [
            ['Иванов', 'Иван', 'Иванович', 'мужской', '2001-05-12', '+7 999 111-11-11', 'Москва, ул. Примерная, 1', 'ivanov@example.com', 'Староста группы', date('c')],
            ['Петрова', 'Анна', 'Сергеевна', 'женский', '2002-08-30', '+7 999 222-22-22', 'Москва, ул. Учебная, 2', 'petrova@example.com', 'Нужен созвон вечером', date('c')],
            ['Сидоров', 'Максим', 'Олегович', 'мужской', '2000-02-18', '+7 999 333-33-33', 'Москва, ул. Лабораторная, 3', 'sidorov@example.com', 'Одногруппник', date('c')],
        ];

        foreach ($seedData as $row) {
            $statement->execute($row);
        }
    }

    return $pdo;
}

function h(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
