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
        private string $summary,
        private string $text,
        private int $authorId,
        private int $readingTime,
        private string $status,
        private string $createdAt
    ) {
    }

    public static function hydrate(array $row): self
    {
        return new self(
            isset($row['id']) ? (int) $row['id'] : null,
            $row['name'] ?? '',
            $row['summary'] ?? '',
            $row['text'] ?? '',
            isset($row['author_id']) ? (int) $row['author_id'] : 1,
            isset($row['reading_time']) ? (int) $row['reading_time'] : self::calculateReadingTime($row['text'] ?? ''),
            $row['status'] ?? 'draft',
            $row['created_at'] ?? date('Y-m-d H:i:s')
        );
    }

    public static function findAll(): array
    {
        $rows = Db::getInstance()->query('SELECT * FROM articles ORDER BY created_at DESC')->fetchAll(PDO::FETCH_ASSOC);
        return array_map([self::class, 'hydrate'], $rows);
    }

    public static function findPublished(): array
    {
        $stmt = Db::getInstance()->prepare('SELECT * FROM articles WHERE status = :status ORDER BY created_at DESC');
        $stmt->execute(['status' => 'published']);
        return array_map([self::class, 'hydrate'], $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public static function findFeatured(int $limit): array
    {
        $stmt = Db::getInstance()->prepare('SELECT * FROM articles WHERE status = :status ORDER BY created_at DESC LIMIT :limit');
        $stmt->bindValue(':status', 'published');
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return array_map([self::class, 'hydrate'], $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public static function findById(int $id): ?self
    {
        $stmt = Db::getInstance()->prepare('SELECT * FROM articles WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row === false ? null : self::hydrate($row);
    }

    public static function emptyDraft(): self
    {
        return new self(null, '', '', '', 1, 1, 'draft', date('Y-m-d H:i:s'));
    }

    public static function fromFormData(array $data, ?int $id = null): self
    {
        $text = trim((string) ($data['text'] ?? ''));
        return new self(
            $id,
            trim((string) ($data['name'] ?? '')),
            trim((string) ($data['summary'] ?? '')),
            $text,
            (int) ($data['author_id'] ?? 1),
            self::calculateReadingTime($text),
            ($data['status'] ?? 'draft') === 'published' ? 'published' : 'draft',
            date('Y-m-d H:i:s')
        );
    }

    public static function countPublished(): int
    {
        $stmt = Db::getInstance()->prepare('SELECT COUNT(*) FROM articles WHERE status = :status');
        $stmt->execute(['status' => 'published']);
        return (int) $stmt->fetchColumn();
    }

    public static function countDrafts(): int
    {
        $stmt = Db::getInstance()->prepare('SELECT COUNT(*) FROM articles WHERE status = :status');
        $stmt->execute(['status' => 'draft']);
        return (int) $stmt->fetchColumn();
    }

    public static function averageReadingTime(): int
    {
        $stmt = Db::getInstance()->query('SELECT AVG(reading_time) FROM articles WHERE status = "published"');
        return max(1, (int) round((float) $stmt->fetchColumn()));
    }

    public static function calculateReadingTime(string $text): int
    {
        $wordCount = max(1, str_word_count(strip_tags($text), 0, 'АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯабвгдеёжзийклмнопрстуфхцчшщъыьэюя'));
        return max(1, (int) ceil($wordCount / 140));
    }

    public function isValid(): bool
    {
        return $this->name !== '' && $this->summary !== '' && $this->text !== '';
    }

    public function create(): void
    {
        $stmt = Db::getInstance()->prepare(
            'INSERT INTO articles (name, summary, text, author_id, reading_time, status, created_at)
             VALUES (:name, :summary, :text, :author_id, :reading_time, :status, :created_at)'
        );
        $stmt->execute([
            'name' => $this->name,
            'summary' => $this->summary,
            'text' => $this->text,
            'author_id' => $this->authorId,
            'reading_time' => $this->readingTime,
            'status' => $this->status,
            'created_at' => $this->createdAt,
        ]);
    }

    public function save(): void
    {
        $stmt = Db::getInstance()->prepare(
            'UPDATE articles
             SET name = :name, summary = :summary, text = :text, author_id = :author_id, reading_time = :reading_time, status = :status
             WHERE id = :id'
        );
        $stmt->execute([
            'id' => $this->id,
            'name' => $this->name,
            'summary' => $this->summary,
            'text' => $this->text,
            'author_id' => $this->authorId,
            'reading_time' => $this->readingTime,
            'status' => $this->status,
        ]);
    }

    public function delete(): void
    {
        if ($this->id === null) {
            return;
        }

        $stmt = Db::getInstance()->prepare('DELETE FROM articles WHERE id = :id');
        $stmt->execute(['id' => $this->id]);
    }

    public function getId(): ?int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getSummary(): string { return $this->summary; }
    public function getText(): string { return $this->text; }
    public function getAuthorId(): int { return $this->authorId; }
    public function getReadingTime(): int { return $this->readingTime; }
    public function getStatus(): string { return $this->status; }
    public function getCreatedAt(): string { return $this->createdAt; }
}
