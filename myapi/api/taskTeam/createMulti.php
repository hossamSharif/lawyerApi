<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/tasksTeam.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate task team object
  $task_team = new TaskTeam($db);

  // Get raw posted data
  $data2 = json_decode(file_get_contents("php://input"), true);

  if (!is_array($data2)) { echo json_encode( array('message' => 'Invalid input data') ); die(); }

  $res = array();

  foreach($data2 as $col) {
    $task_team->user_id = $col['user_id'];
    $task_team->task_id = $col['task_id'];

    // Create task team entry
    array_push($res, array(
      "id" => 'NULL',
      "task_id" => $col['task_id'],
      "user_id" => $col['user_id']
    ));
  }

  $max = sizeof($res);
  $values = '';
  for($i = 0; $i < $max; $i++) {
    if ($i == 0) { 
      $values = '('.$res[$i]['id'].','.$res[$i]['user_id'].','.$res[$i]['task_id'].')';
    } elseif ($i == $max-1) { 
      $values = ''.$values.',('.$res[$i]['id'].','.$res[$i]['user_id'].','.$res[$i]['task_id'].')';
    } elseif ($i > 0 && $i < $max-1) { 
      $values = ''.$values.',('.$res[$i]['id'].','.$res[$i]['user_id'].','.$res[$i]['task_id'].')';
    }   
  }

  if($task_team->createMulti($values)) {
    echo json_encode(
      array('message' => 'Task Team Created')
    );
  } else {
    echo json_encode(
      array('message' => 'Task Team Not Created')
    );
  }
?>
