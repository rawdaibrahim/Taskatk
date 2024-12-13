<?php
    include('user_management.php');

    function create_list($conn, $list_name) {
        $session_id = $_COOKIE["session_id"];
        $left = check_lists_left($conn, $session_id);

        if ($left == 0) {
            return false;
        } else {
            $user_id = _get_user_from_session($conn, $session_id);
            $sql = "INSERT INTO list (name, user_id) VALUES ('$list_name', '$user_id')";
            $result = mysqli_query($conn, $sql);
            
            if ($result) {
                $sql = "SELECT LAST_INSERT_ID() as id";
                $result = mysqli_query($conn, $sql);
            }
            return $result;
        }
    }

    function _get_list_user_id($conn, $list_id) {
        $result = mysqli_fetch_assoc(mysqli_query(
            $conn, "SELECT user_id FROM list WHERE id = '$list_id'"
        ));
        
        if (!$result) return false;
        else return $result['user_id'];
    }

    function delete_list($conn, $list_id) {
        $session_id = $_COOKIE["session_id"];
        $user_id = _get_user_from_session($conn, $session_id);
        $list_user_id = _get_list_user_id($conn, $list_id);

        if ($user_id != $list_user_id) {
            return false;
        } else {
            $sql = "DELETE FROM list WHERE id = '$list_id'";
            $result = mysqli_query($conn, $sql);
            return $result;
        }
    }
?>