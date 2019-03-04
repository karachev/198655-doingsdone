<h2 class="content__main-heading">Список задач</h2>

<form class="search-form" action="index.php" method="post">
    <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">

    <input class="search-form__submit" type="submit" name="" value="Искать">
</form>

<div class="tasks-controls">
    <nav class="tasks-switch">
        <a href="/?task_switch=all" class="tasks-switch__item <?= ($tasksFilter === 'all') ? 'tasks-switch__item--active' : ''; ?>">Все задачи</a>
        <a href="/?task_switch=today" class="tasks-switch__item <?= ($tasksFilter === 'today') ? 'tasks-switch__item--active' : ''; ?>">Повестка дня</a>
        <a href="/?task_switch=tomorrow" class="tasks-switch__item <?= ($tasksFilter === 'tomorrow') ? 'tasks-switch__item--active' : ''; ?>">Завтра</a>
        <a href="/?task_switch=overdue" class="tasks-switch__item <?= ($tasksFilter === 'overdue') ? 'tasks-switch__item--active' : ''; ?>">Просроченные</a>
    </nav>

    <label class="checkbox">
        <input class="checkbox__input visually-hidden show_completed" type="checkbox"
               <? if ((integer)$showCompleteTasks === 1): ?>checked<? endif ?>>
        <span class="checkbox__text">Показывать выполненные</span>
    </label>
</div>

<table class="tasks">
    <?php foreach ($tasks as $key => $task): ?>
        <? if (!$task['isDone'] || $showCompleteTasks): ?>
            <tr class="tasks__item task <?= $task['isDone'] ? 'task--completed' : ''; ?> <?= $task['date'] && checkTaskDate($task['date']) ? 'task--important' : ''; ?> ">
                <td class="task__select">
                    <label class="checkbox task__checkbox">
                        <input class="checkbox__input visually-hidden task__checkbox" type="checkbox"
                               value="<?= $task['id']; ?>" <? if ((integer)$task['status'] === 1): ?>checked<? endif ?>>
                        <span class="checkbox__text"><?= htmlspecialchars($task['name']); ?></span>
                    </label>
                </td>

                <td class="task__file">
                    <a class="download-link" href="<?= 'uploads/' . $task['file']; ?>"><?= htmlspecialchars($task['file']); ?></a>
                </td>

                <td class="task__date"><?= $task['deadline'] ? date("d.m.Y", strtotime($task['deadline'])) : 'Нет'; ?></td>
            </tr>
        <? endif; ?>
    <?php endforeach; ?>
</table>
