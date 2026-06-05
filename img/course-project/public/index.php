<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Autoloader.php';

spl_autoload_register([new Autoloader(), 'loadClass']);

use MyProject\Controllers\ArticleController;
use MyProject\Controllers\CalculatorController;
use MyProject\Controllers\MainController;
use MyProject\Services\View;

$uri = $_SERVER['REQUEST_URI'] ?? '/';
$requestPath = parse_url($uri, PHP_URL_PATH) ?? '/';
$projectDirName = basename(dirname(__DIR__));
$baseUrl = '';

if ($projectDirName !== '') {
    if ($requestPath === '/' . $projectDirName || str_starts_with($requestPath, '/' . $projectDirName . '/')) {
        $baseUrl = '/' . $projectDirName;
    }
}

define('APP_BASE_URL', $baseUrl);

$path = trim((string) substr($requestPath, strlen($baseUrl)), '/');

$routes = [
    '~^$~' => [MainController::class, 'index'],
    '~^about$~' => [MainController::class, 'about'],
    '~^hello/([\w\-]+)$~u' => [MainController::class, 'hello'],
    '~^articles$~' => [ArticleController::class, 'index'],
    '~^article/create$~' => [ArticleController::class, 'create'],
    '~^article/(\d+)$~' => [ArticleController::class, 'show'],
    '~^article/(\d+)/edit$~' => [ArticleController::class, 'edit'],
    '~^article/(\d+)/delete$~' => [ArticleController::class, 'delete'],
    '~^calculator$~' => [CalculatorController::class, 'index'],
];

foreach ($routes as $pattern => [$controllerClass, $method]) {
    if (preg_match($pattern, $path, $matches) === 1) {
        array_shift($matches);
        $matches = array_map(
            static fn(string $value): int|string => ctype_digit($value) ? (int) $value : $value,
            $matches
        );
        $controller = new $controllerClass(new View(__DIR__ . '/../templates'));
        $controller->$method(...$matches);
        exit;
    }
}

http_response_code(404);
(new View(__DIR__ . '/../templates'))->renderHtml('errors/404.php', [
    'title' => 'Страница не найдена',
]);
