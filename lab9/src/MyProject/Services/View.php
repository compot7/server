<?php

declare(strict_types=1);

namespace MyProject\Services;

final class View
{
    public function __construct(private string $templatesPath)
    {
    }

    public function renderHtml(string $templateName, array $variables = []): void
    {
        extract($variables, EXTR_OVERWRITE);
        ob_start();
        require $this->templatesPath . '/' . $templateName;
        $content = ob_get_clean();

        require $this->templatesPath . '/main.php';
    }
}
