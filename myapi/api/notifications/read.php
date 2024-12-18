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

  // Notification read query
  $result = $notification->read();
  
  // Get row count
  $num = $result->rowCount();

  // Check if any notifications
  if($num > 0) {
        // Notification array
        $notification_arr = array();
        $notification_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
          extract($row); 
            $notification_item = array(
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
          // Push to "data"
          array_push($notification_arr['data'], $notification_item);
        }

        // Turn to JSON & output
        echo json_encode($notification_arr);

  } else {
        // No Notifications
        echo json_encode(
          array('message' => 'No notifications Found')
        );
  }
?>
