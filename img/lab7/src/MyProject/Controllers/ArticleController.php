<?php

declare(strict_types=1);

namespace MyProject\Controllers;

use MyProject\Models\Article;

final class ArticleController extends AbstractController
{
    public function index(): void
    {
        $this->view->renderHtml('articles/index.php', [
            'articles' => Article::findAll(),
        ]);
    }

    public function show(int $articleId): void
    {
        $article = Article::findById($articleId);
        if ($article === null) {
            http_response_code(404);
            $this->view->renderHtml('errors/404.php');
            return;
        }

        $this->view->renderHtml('articles/show.php', [
            'article' => $article,
        ]);
    }
}
