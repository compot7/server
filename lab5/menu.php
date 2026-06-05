<?php

declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

function renderMenu(string $activeAction, string $activeSort): string
{
    $items = [
        'view' => 'Просмотр',
        'add' => 'Добавление записи',
        'edit' => 'Редактирование записи',
        'delete' => 'Удаление записи',
    ];

    $sortItems = [
        'created' => 'По добавлению',
        'surname' => 'По фамилии',
        'birth_date' => 'По дате рождения',
    ];

    $html = '<nav class="menu">';
    foreach ($items as $action => $label) {
        $class = $activeAction === $action ? 'menu__link menu__link--active' : 'menu__link';
        $html .= sprintf('<a class="%s" href="/lab5/index.php?action=%s">%s</a>', $class, $action, h($label));
    }
    $html .= '</nav>';

    if ($activeAction === 'view') {
        $html .= '<div class="submenu">';
        foreach ($sortItems as $sort => $label) {
            $class = $activeSort === $sort ? 'submenu__link submenu__link--active' : 'submenu__link';
            $html .= sprintf('<a class="%s" href="/lab5/index.php?action=view&sort=%s">%s</a>', $class, $sort, h($label));
        }
        $html .= '</div>';
    }

    return $html;
}
