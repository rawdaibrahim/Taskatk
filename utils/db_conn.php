<?php

    function connect(){
        try {
            $env = parse_ini_file('.env');
        } catch (Exception $e) {
            $env = parse_ini_file('../.env');
        }
        $db_user = $env["DB_USER"];
        $db_pass = $env["DB_PASSWORD"];
        $db_name = $env["DB_NAME"];
        $db_server = $env["DB_SERVER"];
        $db_port = $env["DB_PORT"];

        $conn = mysqli_connect(
            $db_server,
            $db_user,
            $db_pass,
            $db_name,
            $db_port
        );
        return $conn;
    }

    function disconnect($conn){
        mysqli_close($conn);
    }

    $conn = connect();
?>