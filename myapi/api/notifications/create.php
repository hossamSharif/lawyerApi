<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/notifications.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate notification object
  $notification = new Notifications($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  // Set notification properties
  $notification->user_id = $data->user_id;
  $notification->notification_type = $data->notification_type;
  $notification->notification_message = $data->notification_message;
  $notification->notification_date = $data->notification_date;
  $notification->is_read = $data->is_read;
  $notification->section_name = $data->section_name;
  $notification->section_parameter = $data->section_parameter;

  // Create notification
  if($notification->create()) {
    $last_id = $db->lastInsertId();
    echo json_encode(
      array('message' => $last_id)
    );
  } else {
    echo json_encode(
      array('message' => 'Notification Not Created')
    );
  }
?>
