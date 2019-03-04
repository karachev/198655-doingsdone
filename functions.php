<?php
function includeTemplate($name, $data){
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
function getProjectCount($tasks, $project){
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
function checkTaskDate($stringTaskDate){
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
function getProjects($link, $authorId){
    $sql = 'SELECT name, id FROM project WHERE author_id = ?';
    $stmt = dbGetPrepareStmt($link, $sql, [$authorId]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

/**
 * Get project ID of current user and current project
 * @param $link - Connect to mysql
 * @param $authorId - Current user id
 * @param $projectName - Current project name
 * @return object All project of current user and project name
 */
function get_project_id($link, $authorId, $projectName){
    $sql = 'SELECT id FROM project WHERE author_id = ? AND name = ?';
    $stmt = dbGetPrepareStmt($link, $sql, [$authorId, $projectName]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $resultFetch = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $resultFetch['0']['id'];
}

/**
 * Get all tasks for current project and user
 * @param $link - Connect to mysql
 * @param $authorId - Current user id
 * @param $projectId - Current project id
 * @return object All project of current user and project
 */
function getTasksForCurrentProject($link, $authorId, $projectId) {
    $sql = 'SELECT task.id, date_create, date_done, status, task.name, file, deadline, project_id, author_id FROM task INNER JOIN project ON project.id = task.project_id WHERE author_id = ? AND project_id = ?;';
    $stmt = dbGetPrepareStmt($link, $sql, [$authorId, $projectId]);
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
function getTasks($link, $authorId) {
    $sql = 'SELECT task.id, date_create, date_done, status, task.name, file, deadline, project_id, author_id FROM task INNER JOIN project ON project.id = task.project_id WHERE author_id = ?;';
    $stmt = dbGetPrepareStmt($link, $sql, [$authorId]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

/**
 * Checks if the project id is in the project list.
 * @param $projectId - Current project id
 * @param $projects - List of projects
 * @return bool Is on the list or not
 */
function hasProjectID($projectId, $projects) {
    foreach ($projects as $key => $project) {
        if ((int) $project['id'] === (int) $projectId) {
            return true;
        }
    }

    return false;
}

/**
 * Get the user's data by his email
 * @param $link - Connect to mysql
 * @param $email - Current email
 * @return object Returns user data
 */
function getUserByMail($link, $email) {
    $sql = 'SELECT * FROM user WHERE email = ?;';
    $stmt = dbGetPrepareStmt($link, $sql, [$email]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

/**
 * Get finished tasks for current user
 * @param $link - Connect to mysql
 * @param $authorId - Current user id
 * @return object Returns finished tasks
 */
function getDoneTasks($link, $authorId) {
    $sql = 'SELECT task.* FROM task LEFT JOIN project ON task.project_id = project.id WHERE status = "1" AND author_id = ?;';
    $stmt = dbGetPrepareStmt($link, $sql, [$authorId]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

/**
 * Get filter tasks with date
 * @param $link - Connect to mysql
 * @param $authorId - Current user id
 * @param $filterDate - Current date for filter
 * @return object Returns tasks filter with date
 */
function getFilterTaskWithDate($link, $authorId, $filterDate) {
    $sql = 'SELECT task.* FROM task LEFT JOIN project ON task.project_id = project.id WHERE author_id = ? AND " '. $filterDate .' " = deadline;';
    $stmt = dbGetPrepareStmt($link, $sql, [$authorId]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

/**
 * Get overdue tasks
 * @param $link - Connect to mysql
 * @param $authorId - Current user id
 * @param $filterDate - Current date for filter
 * @return object Returns overdue tasks
 */
function getOverdueTasks($link, $authorId, $filterDate) {
    $sql = 'SELECT task.* FROM task LEFT JOIN project ON task.project_id = project.id WHERE author_id = ? AND " '. $filterDate .' " > deadline;';
    $stmt = dbGetPrepareStmt($link, $sql, [$authorId]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}