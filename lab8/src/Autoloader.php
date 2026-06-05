<?php

declare(strict_types=1);

final class Autoloader
{
    public function loadClass(string $className): void
    {
        $path = __DIR__ . '/' . str_replace('\\', '/', $className) . '.php';
        if (file_exists($path)) {
            require_once $path;
        }
    }
}
