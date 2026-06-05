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
            'articles' => Article::findAll(),
            'title' => 'Список статей',
        ]);
    }

    public function show(int $articleId): void
    {
        $article = Article::findById($articleId);
        if ($article === null) {
            http_response_code(404);
            $this->view->renderHtml('errors/404.php', [
                'title' => 'Статья не найдена',
            ]);
            return;
        }

        $author = User::findById($article->getAuthorId());

        $this->view->renderHtml('articles/show.php', [
            'article' => $article,
            'author' => $author,
            'title' => $article->getName(),
        ]);
    }

    public function edit(int $articleId): void
    {
        $article = Article::findById($articleId);
        if ($article === null) {
            http_response_code(404);
            $this->view->renderHtml('errors/404.php', [
                'title' => 'Статья не найдена',
            ]);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $article->setName(trim($_POST['name'] ?? ''));
            $article->setText(trim($_POST['text'] ?? ''));

            if ($article->getName() !== '' && $article->getText() !== '') {
                $article->save();
                header('Location: ' . APP_BASE_URL . '/article/' . $article->getId());
                exit;
            }
        }

        $this->view->renderHtml('articles/edit.php', [
            'article' => $article,
            'title' => 'Редактирование статьи',
        ]);
    }
}
