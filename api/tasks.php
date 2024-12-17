<?php
    include('../utils/utils.php');
    include('../utils/db_conn.php');
    include('../utils/task_management.php');

    // Get request method and endpoint
    $method = $_SERVER['REQUEST_METHOD'];
    
    if (isset($_SERVER['PATH_INFO'])) {
        $endpoint = $_SERVER['PATH_INFO'];
    } else exit;
    
    // Define API endpoints
    $endpoints = array(
        '/' => array('GET', 'DELETE'),
        '/monthly_tasks' => array('GET'),
        '/create' => array('POST'),
        '/edit' => array('POST'),
    );

    // Connect to database
    $conn = connect();

    // Handle requests
    if (in_array($method, $endpoints[$endpoint])) {
        switch ($method) {
            case 'GET':
                if ($endpoint == '/' && !isset($_GET['id'])) {
                    // Retrieve all tasks for user
                    $tasks = query_result_to_json(get_user_tasks($conn));
                    http_response_code(200); // OK
                    header('Content-Type: application/json');
                    echo $tasks;
                } elseif ($endpoint == '/' && isset($_GET['id'])) {
                    // Retrieve task by ID
                    $task_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
                    $task = get_task($conn, $task_id);

                    if (!$task) {
                        http_response_code(404); // Not Found
                        header('Content-Type: application/json');
                        echo json_encode(array('message' => "You do not have permission to view this task."));
                    } else {
                        http_response_code(200); // OK
                        header('Content-Type: application/json');
                        echo query_result_to_json($task);
                    }
                } elseif ($endpoint == '/monthly_tasks') {
                    if (!isset($_GET['month']) && !isset($_GET['year'])) {
                        http_response_code(400); // Bad Request
                        echo 'Bad Request';
                        disconnect($conn);
                        exit;
                    }

                    $month = filter_var($_GET['month'], FILTER_SANITIZE_NUMBER_INT);
                    $year = filter_var($_GET['year'], FILTER_SANITIZE_NUMBER_INT);
                    
                    // Retrieve monthly tasks for user
                    $tasks = query_result_to_json(get_user_monthly_tasks($conn, $year, $month));
                    http_response_code(200); // OK
                    header('Content-Type: application/json');
                    echo $tasks;
                }
                break;
            case 'POST':
                if ($endpoint == '/create') {
                    // Filter task data
                    $list_id = filter_input(INPUT_POST, "list_id", FILTER_SANITIZE_SPECIAL_CHARS);
                    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
                    $description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_SPECIAL_CHARS);
                    $due_date = filter_input(INPUT_POST, "due_date", FILTER_SANITIZE_SPECIAL_CHARS);

                    // Create task in database
                    $task_id = create_task($conn, $list_id, $name, $description, $due_date);

                    http_response_code(201); // Created
                    header('Content-Type: application/json');
                    if ($task_id) {
                        echo json_encode(array(
                            'message' => 'Task created successfully', 'task_id' => $task_id['id']
                        ));
                    } else {
                        echo json_encode(array('message' => "Task creation failed."));
                    }
                } elseif ($endpoint == '/edit') {
                    // Filter task data
                    $task_id = filter_input(INPUT_POST, "task_id", FILTER_SANITIZE_NUMBER_INT);
                    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
                    $description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_SPECIAL_CHARS);
                    $due_date = filter_input(INPUT_POST, "due_date", FILTER_SANITIZE_SPECIAL_CHARS);
                    $flg_completed = filter_input(INPUT_POST, "flg_completed", FILTER_SANITIZE_NUMBER_INT);

                    // Edit task in database
                    $result = edit_task($conn, $task_id, $name, $description, $due_date, $flg_completed);

                    if ($result) {
                        http_response_code(200); // OK
                        header('Content-Type: application/json');
                        echo json_encode(array('message' => 'Task updated successfully'));
                    } else {
                        http_response_code(404); // Not Found
                        header('Content-Type: application/json');
                        echo json_encode(
                            array('message' => "Failed to edit this task.")
                        );
                    }
                }
                break;
            case 'DELETE':
                if ($endpoint == '/') {
                    if (!isset($_GET['id'])) {
                        http_response_code(400); // Bad Request
                        echo 'Bad Request';
                        disconnect($conn);
                        exit;
                    }
                    // Delete task
                    $task_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
                    $result = delete_task($conn, $task_id);

                    if ($result) {
                        http_response_code(200); // OK
                        header('Content-Type: application/json');
                        echo json_encode(array('message' => 'Task deleted successfully'));
                    } else {
                        http_response_code(404); // Not Found
                        header('Content-Type: application/json');
                        echo json_encode(
                            array('message' => "Failed to delete this task.")
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