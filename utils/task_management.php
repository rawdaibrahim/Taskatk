<?php
    include('list_management.php');

    function create_task(
        $conn, $list_id, $name, $description="", $due_date=null, $flg_completed=false
    ) {
        $user_id = _get_user_from_session();
        $list_user_id = _get_list_user_id($conn, $list_id);

        if ($user_id != $list_user_id) {
            return false;
        } else {
            $sql = <<<EOD
                INSERT INTO task (name, description, due_date, flg_completed, list_id)
                VALUES ('$name', '$description', '$due_date', '$flg_completed', '$list_id')
            EOD;
            $result = mysqli_query($conn, $sql);

            if ($result) {
                $sql = "SELECT LAST_INSERT_ID() as id";
                $result = mysqli_fetch_assoc(mysqli_query($conn, $sql));
            }
            return $result;
        }
    }

    function edit_task(
        $conn, $task_id, $name=null, $description=null, $due_date=null, $flg_completed=false
    ) {
        $user_id = _get_user_from_session();
        $list_user_id = mysqli_fetch_assoc(mysqli_query(
            $conn, "SELECT user_id FROM list WHERE id = (SELECT list_id FROM task WHERE id = '$task_id')"
        ))['user_id'];

        if ($user_id != $list_user_id) {
            return false;
        } else {
            $columns = [
                'name' => $name, 'description' => $description,
                'flg_completed' => $flg_completed, 'due_date' => $due_date
            ];

            $sql = "UPDATE task SET ";
            $i = 0;
            foreach ($columns as $column => $value) {
                if ($value !== null) {
                    $sql .= "$column = '$value'";
                    $sql .= ", ";
                    $i++;
                }
            }
            $sql = substr($sql, 0, -2) . " WHERE id = '$task_id'";

            if ($i == 0) {
                return false;
            } else {
                $result = mysqli_query($conn, $sql);
                return $result;
            }
        }
    }

    function delete_task($conn, $task_id) {
        $user_id = _get_user_from_session();
        $list_user_id = mysqli_fetch_assoc(mysqli_query(
            $conn, "SELECT user_id FROM list WHERE id = (SELECT list_id FROM task WHERE id = '$task_id')"
        ))['user_id'];

        if ($user_id != $list_user_id) {
            return false;
        } else {
            $sql = "DELETE FROM task WHERE id = '$task_id'";
            $result = mysqli_query($conn, $sql);
            return $result;
        }
    }

    function get_user_lists($conn) {
        $user_id = _get_user_from_session();
        $sql = <<<EOD
            SELECT list.id, list.name, task.id as task_id, task.name as task_name FROM list
            LEFT JOIN task ON list.id = task.list_id
            WHERE list.user_id = '$user_id';
        EOD;
        $result = group_tasks_query(mysqli_query($conn, $sql));
        return $result;
    }

    function get_user_tasks($conn) {
        $user_id = _get_user_from_session();
        $sql = "SELECT * FROM task WHERE list_id IN (SELECT id FROM list WHERE user_id = '$user_id')";
        $result = mysqli_query($conn, $sql);
        return $result;
    }

    function get_list($conn, $list_id) {
        $user_id = _get_user_from_session();
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

    function get_task($conn, $task_id) {
        $user_id = _get_user_from_session();
        $list_id = mysqli_fetch_assoc(mysqli_query(
            $conn, "SELECT list_id FROM task WHERE id = '$task_id'"
        ));
        
        if (!$list_id) return false;
        else $list_id = $list_id['list_id'];
        $list_user_id = _get_list_user_id($conn, $list_id);

        if ($user_id != $list_user_id) {
            return false;
        } else {
            $sql = "SELECT * FROM task WHERE id = '$task_id'";
            $result = mysqli_query($conn, $sql);
            return $result;
        }
    }

    function get_user_monthly_tasks($conn, $year, $month) {
        $user_id = _get_user_from_session();
        $sql = <<<EOD
            SELECT * FROM task WHERE list_id IN (
                SELECT id FROM list WHERE user_id = '$user_id'
            ) AND YEAR(due_date) = '$year' AND MONTH(due_date) = '$month'
            ORDER BY due_date;
        EOD;
        $result = mysqli_query($conn, $sql);
        return $result;
    }
?>