<?php
    include('list_management.php');

    function create_task(
        $conn, $session_id, $list_id, $name,
        $description="", $due_date=null, $flg_complete=false
    ) {
        $user_id = _get_user_from_session($conn, $session_id);
        $list_user_id = _get_list_user_id($conn, $list_id);

        if ($user_id != $list_user_id) {
            return "You do not have permission to add tasks to this list.";
        } else {
            $sql = <<<EOD
                INSERT INTO task (name, description, due_date, flg_complete, list_id)
                VALUES ('$name', '$description', '$due_date', '$flg_complete', '$list_id')
            EOD;
            $result = mysqli_query($conn, $sql);
            return $result;
        }
    }

    function delete_task($conn, $task_id, $session_id) {
        $user_id = _get_user_from_session($conn, $session_id);
        $list_user_id = mysqli_fetch_assoc(mysqli_query(
            $conn, "SELECT user_id FROM list WHERE id = (SELECT list_id FROM task WHERE id = '$task_id')"
        ))['user_id'];

        if ($user_id != $list_user_id) {
            return "You do not have permission to delete this task.";
        } else {
            $sql = "DELETE FROM task WHERE id = '$task_id'";
            $result = mysqli_query($conn, $sql);
            return $result;
        }
    }

    function get_user_lists($conn) {
        $session_id = $_COOKIE["session_id"];
        $user_id = _get_user_from_session($conn, $session_id);
        $sql = <<<EOD
            SELECT list.id, list.name, task.id as task_id, task.name as task_name FROM list
            LEFT JOIN task ON list.id = task.list_id
            WHERE list.user_id = '$user_id';
        EOD;
        $result = group_tasks_query(mysqli_query($conn, $sql));
        return $result;
    }

    function get_list($conn, $list_id) {
        $session_id = $_COOKIE["session_id"];
        $user_id = _get_user_from_session($conn, $session_id);
        $list_user_id = _get_list_user_id($conn, $list_id);

        if ($user_id != $list_user_id) {
            return false;
        } else {
            $sql = <<<EOD
                SELECT list.id, list.name, task.id as task_id, task.name as task_name FROM list
                LEFT JOIN task ON list.id = task.list_id
                WHERE list.user_id = '$user_id' AND list.id = '$list_id';
            EOD;
            $result = group_tasks_query(mysqli_query($conn, $sql));
            return $result;
        }
    }

?>