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
        if ((int)$task['project_id'] === (int)$project['id']) {
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

/**
 * Get all projects of current user
 * @param $link - Connect to mysql
 * @param $authorId - Current user id
 * @return object All project of current user
 */
function get_projects($link, $authorId){
    $sql = 'SELECT name, id FROM project WHERE author_id = ?';
    $stmt = db_get_prepare_stmt($link, $sql, [$authorId]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function get_tasks_for_current_project($link, $authorId, $project_id) {
    $sql = 'SELECT task.id, date_create, date_done, status, task.name, file, deadline, project_id, author_id FROM task INNER JOIN project ON project.id = task.project_id WHERE author_id = ? AND project_id = ?;';
    $stmt = db_get_prepare_stmt($link, $sql, [$authorId, $project_id]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

/**
 * Get all tasks of current user
 * @param $link - Connect to mysql
 * @param $authorId - Current user id
 * @return object All tasks of current user
 */
function get_tasks($link, $authorId) {
    $sql = 'SELECT task.id, date_create, date_done, status, task.name, file, deadline, project_id, author_id FROM task INNER JOIN project ON project.id = task.project_id WHERE author_id = ?;';
    $stmt = db_get_prepare_stmt($link, $sql, [$authorId]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function has_project_id($project_id, $projects) {
    foreach ($projects as $key => $project) {
        if ((int) $project['id'] === (int) $project_id) {
            return true;
        }
    }

    return false;
}
