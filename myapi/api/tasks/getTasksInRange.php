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

  // Get range
  $task->startrange = isset($_GET['startrange']) ? $_GET['startrange'] : die();
  $task->endrange = isset($_GET['endrange']) ? $_GET['endrange'] : die();

  // Get tasks
  $result = $task->getTasksInRange();
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
