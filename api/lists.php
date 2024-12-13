<?php
    include('../utils/utils.php');
    include('../utils/db_conn.php');
    include('../utils/list_management.php');

    // Define API endpoints
    $endpoints = array(
        '/' => array('GET', 'DELETE'),
        '/create' => array('POST'),
    );

    // Get request method and endpoint
    $method = $_SERVER['REQUEST_METHOD'];
    $endpoint = $_SERVER['PATH_INFO'];

    // Connect to database
    $conn = connect();

    // Handle requests
    if (in_array($method, $endpoints[$endpoint])) {
        switch ($method) {
            case 'GET':
                if ($endpoint == '/' && !isset($_GET['id'])) {
                    // Retrieve all lists for user
                    $lists = query_result_to_json(get_user_lists($conn));
                    http_response_code(200); // OK
                    header('Content-Type: application/json');
                    echo $lists;
                } elseif ($endpoint == '/' && isset($_GET['id'])) {
                    // Retrieve list by ID
                    $list_id = $_GET['id'];
                    $list = get_list($conn, $list_id);
                    if (!$list) {
                        http_response_code(404); // Not Found
                        header('Content-Type: application/json');
                        echo json_encode(array('message' => "You do not have permission to view this list."));
                    } else {
                        http_response_code(200); // OK
                        header('Content-Type: application/json');
                        echo query_result_to_json($list);
                    }
                }
                break;
            case 'POST':
                if ($endpoint == '/create') {
                    // Create new list
                    $list_name = filter_input(INPUT_POST, "list_name", FILTER_SANITIZE_SPECIAL_CHARS);
                    $list_id = create_list($conn, $list_name);
                    // Save list data to database
                    http_response_code(201); // Created
                    header('Content-Type: application/json');
                    if ($list_id) {
                        echo json_encode(array('message' => 'List created successfully', 'list_id' => $list_id['id']));
                    } else {
                        echo json_encode(array('message' => 'List creation failed'));
                    }
                }
                break;
            case 'DELETE':
                if ($endpoint == '/') {
                    // Delete list
                    $list_id = $_GET['id'];
                    $result = delete_list($conn, $list_id);
                    if ($result) {
                        http_response_code(200); // OK
                        header('Content-Type: application/json');
                        echo json_encode(array('message' => 'List deleted successfully'));
                    } else {
                        http_response_code(404); // Not Found
                        header('Content-Type: application/json');
                        echo json_encode(
                            array('message' => "You do not have permission to delete this list.")
                        );
                    }
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