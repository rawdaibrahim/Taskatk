<?php
    if (!isset($_COOKIE["session_id"])) {
        header('Location: login.php');
        die();
    }
?>

<?php
    include('utils/db_conn.php');
    include('utils/user_management.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDo Lists- Taskatk</title>
</head>
<body>
    <h1>
        Hello, User <?php echo _get_user_from_session($conn, $_COOKIE["session_id"]); ?>
    </h1>

    <?php
        echo "Max Lists: " . check_max_lists($conn, $_COOKIE["session_id"]);
        echo "<br>";
        echo "You currently have " . check_lists_left($conn, $_COOKIE["session_id"]) . " lists left to create.";
    ?>
</body>
</html>
<?php
    disconnect($conn);
?>
