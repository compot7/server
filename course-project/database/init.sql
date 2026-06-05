DROP DATABASE IF EXISTS poly_study_hub;
CREATE DATABASE IF NOT EXISTS poly_study_hub CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE poly_study_hub;
SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nickname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    summary TEXT NOT NULL,
    text TEXT NOT NULL,
    author_id INT NOT NULL,
    reading_time INT NOT NULL DEFAULT 1,
    status ENUM('draft', 'published') NOT NULL DEFAULT 'draft',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_articles_users FOREIGN KEY (author_id) REFERENCES users(id)
);

INSERT INTO users (nickname, email)
VALUES
    ('nikita', 'klyubin@example.com'),
    ('mentor', 'mentor@example.com');

INSERT INTO articles (name, summary, text, author_id, reading_time, status, created_at)
VALUES
    (
        'Как спланировать учебную неделю без перегруза',
        'Практический материал о том, как распределить занятия, лабораторные и отдых так, чтобы не перегореть к середине семестра.',
        'В материале рассматривается недельное планирование по блокам: пары, самостоятельная работа, буфер под срочные задачи и обязательное время на восстановление. Такой подход помогает студенту не только выполнять задания вовремя, но и понимать, сколько реальных часов уходит на подготовку.',
        1,
        3,
        'published',
        '2026-06-02 10:00:00'
    ),
    (
        'Что включить в портфолио студента backend-направления',
        'Разбор структуры учебного портфолио: лабораторные, курсовой проект, документация и краткие описания реализованных функций.',
        'Для сильного backend-портфолио важно показывать не только исходный код, но и архитектуру проекта, работу с базой данных, маршрутизацию, обработку форм и осмысленный пользовательский интерфейс. Отдельным плюсом становится наличие пояснительной записки и скриншотов работающего приложения.',
        2,
        3,
        'published',
        '2026-06-03 14:30:00'
    ),
    (
        'Черновик раздела про защиту курсового проекта',
        'Подготовка ответов на типовые вопросы по архитектуре, БД и серверной части сайта.',
        'Этот материал пока не опубликован и доступен только из административной панели. В нём собраны тезисы для устной защиты: почему выбрана текущая структура MVC, как работает роутер и каким образом проект использует данные из MySQL.',
        1,
        2,
        'draft',
        '2026-06-04 09:15:00'
    );
