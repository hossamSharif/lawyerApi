<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/notifications.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate notifications object
  $notifications = new Notifications($db);

  // Get raw posted data
  $data2 = json_decode(file_get_contents("php://input"), true);

  $res = array();
  foreach($data2 as $col){
      $notifications->id = $col['id'];
      $notifications->user_id = $col['user_id'];
      $notifications->notification_type = $col['notification_type'];
      $notifications->notification_message = $col['notification_message'];
      $notifications->notification_date = $col['notification_date'];
      $notifications->is_read = $col['is_read'];
      $notifications->section_name = $col['section_name'];
      $notifications->section_parameter = $col['section_parameter'];
       
      array_push($res, array(
        "id" => $col['id'],
        "user_id" => $col['user_id'],
        "notification_type" => $col['notification_type'],
        "notification_message" => $col['notification_message'],
        "notification_date" => $col['notification_date'],
        "is_read" => $col['is_read'],
        "section_name" => $col['section_name'],
        "section_parameter" => $col['section_parameter']
      ));
  }

  $max = sizeof($res);
  $values = '';
  for($i = 0; $i < $max; $i++){
    if ($i == 0) { 
      $values = '( '.$res[$i]['id'].','.$res[$i]['user_id'].',"'.$res[$i]['notification_type'].'","'.$res[$i]['notification_message'].'","'.$res[$i]['notification_date'].'",'.$res[$i]['is_read'].',"'.$res[$i]['section_name'].'","'.$res[$i]['section_parameter'].'")';
    } elseif ($i == $max-1) { 
      $values = ''.$values.',('.$res[$i]['id'].','.$res[$i]['user_id'].',"'.$res[$i]['notification_type'].'","'.$res[$i]['notification_message'].'","'.$res[$i]['notification_date'].'",'.$res[$i]['is_read'].',"'.$res[$i]['section_name'].'","'.$res[$i]['section_parameter'].'")';
    } elseif ($i > 0 && $i < $max-1) { 
      $values = ''.$values.',('.$res[$i]['id'].','.$res[$i]['user_id'].',"'.$res[$i]['notification_type'].'","'.$res[$i]['notification_message'].'","'.$res[$i]['notification_date'].'",'.$res[$i]['is_read'].',"'.$res[$i]['section_name'].'","'.$res[$i]['section_parameter'].'")';
    }   
  }

  if($notifications->createMulti($values)) {
    echo json_encode(
      array('message' => 'Notifications Created')
    );
  } else {
    echo json_encode(
      array('message' => 'Notifications Not Created')
    );
  }
?>
