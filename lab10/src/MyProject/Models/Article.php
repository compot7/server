<?php

declare(strict_types=1);

namespace MyProject\Models;

use MyProject\Services\Db;
use PDO;

final class Article
{
    public function __construct(
        private ?int $id,
        private string $name,
        private string $text,
        private int $authorId
    ) {
    }

    public static function findAll(): array
    {
        $db = Db::getInstance();
        $statement = $db->query('SELECT id, name, text, author_id FROM articles ORDER BY id DESC');
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        return array_map(
            static fn(array $row): self => new self(
                (int) $row['id'],
                $row['name'],
                $row['text'],
                (int) $row['author_id']
            ),
            $rows
        );
    }

    public static function findById(int $id): ?self
    {
        $db = Db::getInstance();
        $statement = $db->prepare('SELECT id, name, text, author_id FROM articles WHERE id = :id');
        $statement->execute(['id' => $id]);
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if ($row === false) {
            return null;
        }

        return new self(
            (int) $row['id'],
            $row['name'],
            $row['text'],
            (int) $row['author_id']
        );
    }

    public function save(): void
    {
        $db = Db::getInstance();
        $statement = $db->prepare('UPDATE articles SET name = :name, text = :text WHERE id = :id');
        $statement->execute([
            'id' => $this->id,
            'name' => $this->name,
            'text' => $this->text,
        ]);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getAuthorId(): int
    {
        return $this->authorId;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }
}
