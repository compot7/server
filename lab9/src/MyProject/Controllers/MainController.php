<?php

declare(strict_types=1);

namespace MyProject\Controllers;

use MyProject\Models\Article;

final class MainController extends AbstractController
{
    public function index(): void
    {
        $this->view->renderHtml('main/index.php', [
            'articles' => Article::findAll(),
        ]);
    }

    public function hello(string $username): void
    {
        $this->view->renderHtml('main/hello.php', [
            'username' => $username,
            'title' => 'Страница приветствия',
        ]);
    }

    public function sayBye(string $name): void
    {
        $this->view->renderHtml('main/bye.php', [
            'name' => $name,
        ]);
    }
}
