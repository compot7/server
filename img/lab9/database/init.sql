DROP DATABASE IF EXISTS my_blog;
CREATE DATABASE IF NOT EXISTS my_blog CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE my_blog;
SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nickname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    author_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    text TEXT NOT NULL,
    CONSTRAINT fk_articles_users FOREIGN KEY (author_id) REFERENCES users(id)
);

INSERT IGNORE INTO users (nickname, email)
VALUES
    ('admin', 'admin@example.com'),
    ('student', 'student@example.com');

INSERT INTO articles (author_id, name, text)
VALUES
    (1, 'Первая статья', 'Это тестовая статья для проверки вывода заголовка и автора.'),
    (2, 'Вторая статья', 'Здесь можно открыть форму редактирования и сохранить изменения.');
