<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/tasksTeam.php';
  
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();
  // Instantiate task team object
  $task_team = new TaskTeam($db);

  // Get task ID
  $task_team->task_id = isset($_GET['task_id']) ? $_GET['task_id'] : die();

  // Get task team
  $result = $task_team->getTaskTeam();
  $num = $result->rowCount();
  // Create array
  $task_team_arr = array();
  $task_team_arr['data'] = array();
if($num > 0) {
  while($row = $result->fetch(PDO::FETCH_ASSOC)) {
  extract($row);
  $task_team_arr = array(
    'task_id' => $row['task_id'],
    'full_name' => $row['full_name'],
    'user_id' => $row['user_id']
  );                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
  // Make JSON
  print_r(json_encode($task_team_arr));
} 
}else{ 
  // No Posts
  echo json_encode(
    array('message' => 'No record Found')
  );  
?>
