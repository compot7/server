<?php

declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

function renderViewer(string $sort, int $page): string
{
    $allowedSort = [
        'created' => 'id ASC',
        'surname' => 'surname ASC, first_name ASC',
        'birth_date' => 'birth_date ASC',
    ];

    $sortSql = $allowedSort[$sort] ?? $allowedSort['created'];
    $perPage = 10;
    $offset = ($page - 1) * $perPage;
    $pdo = contactsDb();

    $total = (int) $pdo->query('SELECT COUNT(*) FROM contacts')->fetchColumn();
    $stmt = $pdo->query("SELECT * FROM contacts ORDER BY {$sortSql} LIMIT {$perPage} OFFSET {$offset}");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $html = '<div class="panel"><h2>Содержимое записной книжки</h2><table><thead><tr>';
    foreach (['Фамилия', 'Имя', 'Отчество', 'Пол', 'Дата рождения', 'Телефон', 'Адрес', 'E-mail', 'Комментарий'] as $heading) {
        $html .= '<th>' . h($heading) . '</th>';
    }
    $html .= '</tr></thead><tbody>';

    foreach ($rows as $row) {
        $html .= '<tr>';
        $html .= '<td>' . h($row['surname']) . '</td>';
        $html .= '<td>' . h($row['first_name']) . '</td>';
        $html .= '<td>' . h($row['patronymic']) . '</td>';
        $html .= '<td>' . h($row['gender']) . '</td>';
        $html .= '<td>' . h($row['birth_date']) . '</td>';
        $html .= '<td>' . h($row['phone']) . '</td>';
        $html .= '<td>' . h($row['address']) . '</td>';
        $html .= '<td>' . h($row['email']) . '</td>';
        $html .= '<td>' . h($row['comment']) . '</td>';
        $html .= '</tr>';
    }

    if ($rows === []) {
        $html .= '<tr><td colspan="9">Записей пока нет.</td></tr>';
    }

    $html .= '</tbody></table>';

    $pageCount = (int) ceil($total / $perPage);
    if ($pageCount > 1) {
        $html .= '<div class="pagination">';
        for ($i = 1; $i <= $pageCount; $i++) {
            $class = $i === $page ? 'pagination__link pagination__link--active' : 'pagination__link';
            $html .= sprintf('<a class="%s" href="/lab5/index.php?action=view&sort=%s&page=%d">%d</a>', $class, h($sort), $i, $i);
        }
        $html .= '</div>';
    }

    $html .= '</div>';
    return $html;
}
