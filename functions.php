<?php
function include_template($name, $data){
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}

/**
 * Get the count of tasks for current project
 * @param $tasks - All tasks
 * @param $project - Current project
 * @return int The count of tasks relevant to current project
 */
function get_project_count($tasks, $project){
    $tasksCount = 0;
    foreach ($tasks as $key => $task) {
        if ((string)$task['category'] === (string)$project) {
            $tasksCount++;
        }
    }

    return $tasksCount;
}

/**
 * Checks if the task deadline is nearing the end
 * @param $stringTaskDate - Deadline of the task
 * @return bool Task overdue or near deadline
 */
function check_task_date($stringTaskDate){
    $taskDate = strtotime($stringTaskDate);
    $currentDate = time();
    $diff = $taskDate - $currentDate;

    $secondsInHour = 3600;
    $hoursInDay = 24;

    return $diff / $secondsInHour < $hoursInDay;
}
