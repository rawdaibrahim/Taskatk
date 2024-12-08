<?php
    include('db_conn.php');
    $conn = connect();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDo Lists- Taskatk</title>
</head>
<body>
    <h1>Hello,
    <?php
        include('user_management.php');

        // $m_success = signup($conn, 'mohamed@gmail.com', 'M0h@m3d', 2);
        // echo $m_success;

        $m_success = login($conn, 'mohamed@gmail.com', 'M0h@m3d');
        echo $m_success;
    ?>
    </h1>

    <?php
        echo "Subscription: " . check_subscription($conn, $_COOKIE["session_id"]);
        echo "<br>";
        echo "Max Lists: " . check_max_lists($conn, $_COOKIE["session_id"]);
        echo "<br>";
        echo "You currently have " . check_lists_left($conn, $_COOKIE["session_id"]) . " lists left to create.";
    ?>

</body>
</html>
<?php
    disconnect($conn);
?>
