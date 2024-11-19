<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/tasks.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate task object
  $task = new Tasks($db);

  // Get search term
  $task->searchTerm = isset($_GET['searchTerm']) ? $_GET['searchTerm'] : die();

  // Get task
  $result = $task->getTaskBySearchTerm();
  $num = $result->rowCount();

  // Create array
  $task_arr = array();
  $task_arr['data'] = array();

  if($num > 0) {
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      $task_arr = array(
        'id' => $row['id'],
        'title' => $row['title'],
        'description' => $row['description'],
        'status' => $row['status'],
        'due_date' => $row['due_date'],
        'created_at' => $row['created_at'],
        'category' => $row['category'],
        'team' => json_decode('[' . $row['team'] . ']')
      );
      // Make JSON
      print_r(json_encode($task_arr));
    }
  } else {
    // No Tasks
    echo json_encode(
      array('message' => 'No record Found')
    );
  }
?>
