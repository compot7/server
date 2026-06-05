# PolyStudy Hub

`PolyStudy Hub` — курсовой проект по дисциплине «Серверная веб-разработка».  
Проект представляет собой учебный сайт для студентов с материалами по учебному планированию, калькулятором учебной нагрузки и разделом статей.

## Что реализовано

- backend-приложение на PHP с собственной MVC-структурой;
- маршрутизация запросов через единый входной файл;
- шаблонизация страниц и единый пользовательский интерфейс;
- работа с базой данных `MySQL/MariaDB`;
- вывод динамического контента на главной странице;
- расчёт учебной нагрузки на основе входных параметров;
- раздел статей с карточками материалов, просмотром и редактированием;
- формы создания, изменения и удаления материалов.

## Структура проекта

- `public/index.php` — фронт-контроллер и роутер;
- `src/MyProject/Controllers` — контроллеры;
- `src/MyProject/Models` — модели данных;
- `src/MyProject/Services` — сервисы представления и подключения к БД;
- `templates` — HTML-шаблоны;
- `database/init.sql` — создание базы `poly_study_hub` и тестовые данные;
- `report/explanatory-note.md` — текст пояснительной записки по шаблону.

## Запуск в XAMPP

1. Скопировать папку `course-project` в `C:\xampp\htdocs\course-project`.
2. Запустить `Apache` и `MySQL` в `XAMPP Control Panel`.
3. Импортировать `database/init.sql` в локальный `MariaDB`.
4. Открыть в браузере [http://localhost/course-project/](http://localhost/course-project/).

## Основные страницы

- [http://localhost/course-project/](http://localhost/course-project/)
- [http://localhost/course-project/about](http://localhost/course-project/about)
- [http://localhost/course-project/articles](http://localhost/course-project/articles)
- [http://localhost/course-project/calculator](http://localhost/course-project/calculator)

## Данные по проекту

- Студент: `Клюбин Никита Андреевич`
- Дисциплина: `Серверная веб-разработка`
- Тема: `Backend-фреймворк на PHP. Учебный сайт PolyStudy Hub`
