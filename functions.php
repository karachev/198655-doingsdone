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

function get_project_count($tasks, $project)
{
    $tasksCount = 0;
    foreach ($tasks as $key => $task) {
        if ((string)$task['category'] === (string)$project) {
            $tasksCount++;
        }
    }

    return $tasksCount;
}
