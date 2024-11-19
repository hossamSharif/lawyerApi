<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/tasks.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate task object
  $task = new Tasks($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  // Set ID to UPDATE
  $task->id = $data->id;

  // Set task properties
  $task->title = $data->title;
  $task->description = $data->description;
  $task->status = $data->status;
  $task->due_date = $data->due_date;
  $task->created_at = $data->created_at;
  $task->category = $data->category;

  // Update task
  if($task->update()) {
    echo json_encode(
      array('message' => 'Task Updated')
    );
  } else {
    echo json_encode(
      array('message' => 'Task Not Updated')
    );
  }
?>
