<?php

declare(strict_types=1);

namespace MyProject\Controllers;

use MyProject\Models\Article;
use MyProject\Models\User;

final class ArticleController extends AbstractController
{
    public function index(): void
    {
        $this->view->renderHtml('articles/index.php', [
            'title' => 'Статьи и материалы',
            'articles' => Article::findPublished(),
        ]);
    }

    public function show(int $articleId): void
    {
        $article = Article::findById($articleId);
        if ($article === null) {
            http_response_code(404);
            $this->view->renderHtml('errors/404.php', ['title' => 'Материал не найден']);
            return;
        }

        $author = User::findById($article->getAuthorId());

        $this->view->renderHtml('articles/show.php', [
            'title' => $article->getName(),
            'article' => $article,
            'author' => $author,
        ]);
    }

    public function create(): void
    {
        $article = Article::emptyDraft();
        $authors = User::findAll();
        $message = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $article = Article::fromFormData($_POST);
            if ($article->isValid()) {
                $article->create();
                header('Location: ' . APP_BASE_URL . '/admin', true, 303);
                exit;
            }
            $message = 'Заполните заголовок, краткое описание и основной текст статьи.';
        }

        $this->view->renderHtml('articles/form.php', [
            'title' => 'Новая статья',
            'article' => $article,
            'authors' => $authors,
            'formAction' => APP_BASE_URL . '/article/create',
            'buttonLabel' => 'Создать статью',
            'message' => $message,
        ]);
    }

    public function edit(int $articleId): void
    {
        $article = Article::findById($articleId);
        if ($article === null) {
            http_response_code(404);
            $this->view->renderHtml('errors/404.php', ['title' => 'Материал не найден']);
            return;
        }

        $authors = User::findAll();
        $message = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $article = Article::fromFormData($_POST, $articleId);
            if ($article->isValid()) {
                $article->save();
                header('Location: ' . APP_BASE_URL . '/article/' . $articleId, true, 303);
                exit;
            }
            $message = 'Проверьте поля формы: часть данных заполнена некорректно.';
        }

        $this->view->renderHtml('articles/form.php', [
            'title' => 'Редактирование статьи',
            'article' => $article,
            'authors' => $authors,
            'formAction' => APP_BASE_URL . '/article/' . $articleId . '/edit',
            'buttonLabel' => 'Сохранить изменения',
            'message' => $message,
        ]);
    }

    public function delete(int $articleId): void
    {
        $article = Article::findById($articleId);
        if ($article !== null) {
            $article->delete();
        }

        header('Location: ' . APP_BASE_URL . '/admin', true, 303);
        exit;
    }
}
