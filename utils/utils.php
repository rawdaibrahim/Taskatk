<?php
    function query_result_to_json($result) {
        $json = array();
        while ($row = $result->fetch_assoc()) {
            $json[] = $row;
        }
        return json_encode($json);
    }

    function group_tasks_query($result) {
        $groupedTasks = array();
        while ($row = $result->fetch_assoc()) {
            $listId = $row['id'];
            $listName = $row['name'];
            $taskId = $row['task_id'];
            
            if (!isset($groupedTasks[$listId])) {
                $groupedTasks[$listId] = array(
                    'id' => $listId,
                    'name' => $listName,
                    'tasks' => array()
                );
            }
            
            if ($taskId !== null) {
                $groupedTasks[$listId]['tasks'][] = array(
                    'id' => $taskId,
                    'name' => $row['task_name'],
                    'flg_completed' => $row['flg_completed'],
                );
            }
        }
        return $groupedTasks;
    }
?>