<?php
    function signup($conn, $username, $password, $subscription_id) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO user (username, password, subscription_id) VALUES ('$username', '$hashed_password', '$subscription_id')";

        try {
            $result = mysqli_query($conn, $sql);
        } catch (mysqli_sql_exception) {
            return false;
        }

        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    function login($conn, $username, $password) {
        $sql = "SELECT * FROM user WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['password'])) {
                $cookie_name = "session_id";
                $cookie_value = $row['id'] + 35623559663;
                setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
                return $row['id'];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function _get_user_from_session($conn, $session_id) {
        return $session_id - 35623559663;
    }

    function check_subscription($conn, $session_id) {
        $user_id = _get_user_from_session($conn, $session_id);
        $sql = "SELECT name FROM subscription WHERE id = (SELECT subscription_id FROM user WHERE id = '$user_id')";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row['name'];
    }

    function check_max_lists($conn, $session_id) {
        $user_id = _get_user_from_session($conn, $session_id);
        $sql = "SELECT max_lists FROM subscription WHERE id = (SELECT subscription_id FROM user WHERE id = '$user_id')";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row['max_lists'];
    }

    function check_lists_left($conn, $session_id) {
        $user_id = _get_user_from_session($conn, $session_id);
        $max_lists = mysqli_fetch_assoc(mysqli_query(
            $conn,
            "SELECT max_lists FROM subscription WHERE id = (SELECT subscription_id FROM user WHERE id = '$user_id')"
        ))['max_lists'];
        $user_list_count = mysqli_fetch_assoc(mysqli_query(
            $conn,
            "SELECT count(*) FROM list WHERE user_id = '$user_id'"
        ))['count(*)'];
        return $max_lists - $user_list_count;
    }
?>