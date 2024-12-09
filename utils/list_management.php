<?php

    include('db_conn.php');
    include('user_management.php');

    function create_list($conn, $session_id, $list_name) {
        $left = check_lists_left($conn, $session_id);
        if ($left == 0) {
            return "You have reached the maximum number of lists.";
        } else {
            $user_id = _get_user_from_session($conn, $session_id);
            $sql = "INSERT INTO list (name, user_id) VALUES ('$list_name', '$user_id')";
            $result = mysqli_query($conn, $sql);
            return $result;
        }
    }

    function _get_list_user_id($conn, $list_id) {
        return mysqli_fetch_assoc(mysqli_query(
            $conn, "SELECT user_id FROM list WHERE id = '$list_id'"
        ))['user_id'];
    }

    function delete_list($conn, $list_id, $session_id) {
        $user_id = _get_user_from_session($conn, $session_id);
        $list_user_id = _get_list_user_id($conn, $list_id);

        if ($user_id != $list_user_id) {
            return "You do not have permission to delete this list.";
        } else {
            $sql = "DELETE FROM list WHERE id = '$list_id'";
            $result = mysqli_query($conn, $sql);
            return $result;
        }
    }

    function get_user_lists($conn, $session_id) {
        $user_id = _get_user_from_session($conn, $session_id);
        $sql = "SELECT id, name FROM list WHERE user_id = '$user_id'";
        $result = mysqli_query($conn, $sql);
        return $result;
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $list_name = filter_input (INPUT_POST, "list_name", FILTER_SANITIZE_SPECIAL_CHARS);
        if (empty($list_name)) {
            echo "Please enter a list name";
        }
        else{
            $list = create_list($conn, $_COOKIE["session_id"], $list_name);
        }
    }
?>