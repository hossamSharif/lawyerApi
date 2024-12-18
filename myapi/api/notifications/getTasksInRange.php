<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/notifications.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate notification object
  $notification = new Notifications($db);

  // Get range
  $notification->startrange = isset($_GET['startrange']) ? $_GET['startrange'] : die();
  $notification->endrange = isset($_GET['endrange']) ? $_GET['endrange'] : die();

  // Get notifications
  $result = $notification->getNotificationsInRange();
  $num = $result->rowCount();

  // Create array
  $notification_arr = array();
  $notification_arr['data'] = array();

  if($num > 0) {
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      $notification_arr = array(
        'id' => $row['id'],
        'user_id' => $row['user_id'],
        'notification_type' => $row['notification_type'],
        'notification_message' => $row['notification_message'],
        'notification_date' => $row['notification_date'],
        'is_read' => $row['is_read'],
        'section_name' => $row['section_name'],
        'section_parameter' => $row['section_parameter'],
        'user_name' =>  $row['user_name'] 
      );
      // Make JSON
      print_r(json_encode($notification_arr));
    }
  } else {
    // No Notifications
    echo json_encode(
      array('message' => 'No record Found')
    );
  }
?>
