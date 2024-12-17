<?php
    include('../utils/db_conn.php');
    include('../utils/user_management.php');

    // Get request method and endpoint
    $method = $_SERVER['REQUEST_METHOD'];

    if (isset($_SERVER['PATH_INFO'])) {
        $endpoint = $_SERVER['PATH_INFO'];
    } else exit;
    
    // Define API endpoints
    $endpoints = array(
        '/' => array('GET'),
        '/max_lists' => array('GET'),
        '/lists_left' => array('GET'),
    );

    // Connect to database
    $conn = connect();

    // Handle requests
    if (in_array($method, $endpoints[$endpoint])) {
        switch ($method) {
            case 'GET':
                if ($endpoint == '/') {
                    // Retrieve all lists for user
                    $user = get_user_data($conn);
                    http_response_code(200); // OK
                    header('Content-Type: application/json');
                    echo $user;
                } elseif ($endpoint == '/max_lists') {
                    // Retrieve max lists for user
                    $max_lists = check_max_lists($conn);
                    http_response_code(200); // OK
                    header('Content-Type: application/json');
                    echo json_encode(array('max_lists' => $max_lists));
                } elseif ($endpoint == '/lists_left') {
                    // Retrieve max lists for user
                    $lists_left = check_lists_left($conn);
                    http_response_code(200); // OK
                    header('Content-Type: application/json');
                    echo json_encode(array('lists_left' => $lists_left));
                }
                break;
            default:
                http_response_code(405); // Method Not Allowed
                echo 'Method Not Allowed';
                disconnect($conn);
                exit;
        }
        disconnect($conn);
    } else {
        http_response_code(404); // Not Found
        echo 'Not Found';
        disconnect($conn);
        exit;
    }
?>