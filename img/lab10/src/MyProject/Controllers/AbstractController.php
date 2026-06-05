<?php

declare(strict_types=1);

namespace MyProject\Controllers;

use MyProject\Services\View;

abstract class AbstractController
{
    public function __construct(protected View $view)
    {
    }
}
