<?php

declare(strict_types=1);

namespace MyProject\Services;

use PDO;

final class Db
{
    private static ?PDO $instance = null;

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            $config = require __DIR__ . '/../../../config/db.php';
            $databasePath = $config['path'];
            $databaseDir = dirname($databasePath);

            if (!is_dir($databaseDir)) {
                mkdir($databaseDir, 0777, true);
            }

            self::$instance = new PDO('sqlite:' . $databasePath);
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            self::initializeSqlite(self::$instance);
        }

        return self::$instance;
    }

    private static function initializeSqlite(PDO $pdo): void
    {
        $pdo->exec(
            'CREATE TABLE IF NOT EXISTS users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                nickname TEXT NOT NULL,
                email TEXT NOT NULL UNIQUE
            )'
        );

        $pdo->exec(
            'CREATE TABLE IF NOT EXISTS articles (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                author_id INTEGER NOT NULL,
                name TEXT NOT NULL,
                text TEXT NOT NULL,
                FOREIGN KEY(author_id) REFERENCES users(id)
            )'
        );

        $usersCount = (int) $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
        if ($usersCount === 0) {
            $pdo->exec(
                "INSERT INTO users (nickname, email) VALUES
                ('admin', 'admin@example.com'),
                ('student', 'student@example.com')"
            );
        }

        $articlesCount = (int) $pdo->query('SELECT COUNT(*) FROM articles')->fetchColumn();
        if ($articlesCount === 0) {
            $pdo->exec(
                "INSERT INTO articles (author_id, name, text) VALUES
                (1, 'Первая статья', 'Это тестовая статья для проверки вывода заголовка и автора.'),
                (2, 'Вторая статья', 'Здесь можно открыть форму редактирования и сохранить изменения.')"
            );
        }
    }
}
