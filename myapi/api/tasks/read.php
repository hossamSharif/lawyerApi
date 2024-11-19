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

  // Task read query
  $result = $task->read();
  
  // Get row count
  $num = $result->rowCount();

  // Check if any tasks
  if($num > 0) {
        // Task array
        $task_arr = array();
        $task_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
          extract($row); 
            $task_item = array(
            'id' => $row['id'],
            'title' => $row['title'],
            'description' => $row['description'],
            'status' => $row['status'],
            'due_date' => $row['due_date'],
            'created_at' => $row['created_at'],
            'category' => $row['category'], 
            'team' => json_decode( '['. $row['team'] .']')
          );
          // Push to "data"
          array_push($task_arr['data'], $task_item);
        }

        // Turn to JSON & output
        echo json_encode($task_arr);

  } else {
        // No Tasks
        echo json_encode(
          array('message' => 'No tasks Found')
        );
  }
?>
