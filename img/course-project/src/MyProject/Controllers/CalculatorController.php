<?php

declare(strict_types=1);

namespace MyProject\Controllers;

final class CalculatorController extends AbstractController
{
    public function index(): void
    {
        $subjects = max(1, min(12, (int) ($_GET['subjects'] ?? 5)));
        $hoursPerDay = max(1, min(8, (int) ($_GET['hours_per_day'] ?? 2)));
        $difficulty = (string) ($_GET['difficulty'] ?? 'middle');
        $target = (string) ($_GET['target'] ?? 'good');

        $difficultyFactor = match ($difficulty) {
            'easy' => 0.8,
            'hard' => 1.4,
            default => 1.0,
        };

        $targetFactor = match ($target) {
            'pass' => 0.8,
            'excellent' => 1.4,
            default => 1.0,
        };

        $weeklyLoad = (int) round($subjects * $hoursPerDay * $difficultyFactor * $targetFactor);
        $weeklyLoad = max(1, $weeklyLoad);
        $restHours = max(4, 42 - $weeklyLoad);

        $warning = $weeklyLoad > 20
            ? 'Нагрузка высокая: стоит заранее распределить дедлайны и оставить слоты на отдых.'
            : 'Нагрузка выглядит сбалансированной, если придерживаться расписания и не откладывать задания.';

        $this->view->renderHtml('calculator/index.php', [
            'title' => 'Калькулятор учебной нагрузки',
            'input' => [
                'subjects' => $subjects,
                'hours_per_day' => $hoursPerDay,
                'difficulty' => $difficulty,
                'target' => $target,
            ],
            'weeklyLoad' => $weeklyLoad,
            'restHours' => $restHours,
            'warning' => $warning,
        ]);
    }
}
