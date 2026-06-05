<?php

declare(strict_types=1);

namespace MyProject\Controllers;

use MyProject\Models\Article;

final class MainController extends AbstractController
{
    public function index(): void
    {
        $hour = (int) date('G');
        $greeting = match (true) {
            $hour < 6 => 'Доброй ночи',
            $hour < 12 => 'Доброе утро',
            $hour < 18 => 'Добрый день',
            default => 'Добрый вечер',
        };

        $this->view->renderHtml('main/index.php', [
            'title' => 'PolyStudy Hub',
            'greeting' => $greeting,
            'now' => date('d.m.Y H:i'),
            'featuredArticles' => Article::findFeatured(3),
            'stats' => [
                'articles' => Article::countPublished(),
                'avgReadingTime' => Article::averageReadingTime(),
                'drafts' => Article::countDrafts(),
            ],
        ]);
    }

    public function about(): void
    {
        $this->view->renderHtml('main/about.php', [
            'title' => 'О проекте',
        ]);
    }

    public function hello(string $username): void
    {
        $this->view->renderHtml('main/hello.php', [
            'title' => 'Приветственная страница',
            'username' => $username,
        ]);
    }
}
