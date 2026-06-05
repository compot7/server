<?php

declare(strict_types=1);

namespace MyProject\Models;

use MyProject\Services\Db;
use PDO;

final class User
{
    public function __construct(
        private int $id,
        private string $nickname,
        private string $email
    ) {
    }

    public static function findById(int $id): ?self
    {
        $db = Db::getInstance();
        $statement = $db->prepare('SELECT id, nickname, email FROM users WHERE id = :id');
        $statement->execute(['id' => $id]);
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if ($row === false) {
            return null;
        }

        return new self(
            (int) $row['id'],
            $row['nickname'],
            $row['email']
        );
    }

    public static function findAll(): array
    {
        $rows = Db::getInstance()
            ->query('SELECT id, nickname, email FROM users ORDER BY nickname ASC')
            ->fetchAll(PDO::FETCH_ASSOC);

        return array_map(
            static fn(array $row): self => new self(
                (int) $row['id'],
                $row['nickname'],
                $row['email']
            ),
            $rows
        );
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNickname(): string
    {
        return $this->nickname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
