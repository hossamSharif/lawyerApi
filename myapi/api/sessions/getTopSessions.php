<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/sessions.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate session object
  $session = new Sessions($db);

  // Session read query
  $result = $session->getTopSessions();
  
  // Get row count
  $num = $result->rowCount();

  // Check if any sessions
  if($num > 0) {
        // Session array
        $session_arr = array();
        $session_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
          extract($row);
        
          $session_item = array(
            'id' => $row['id'],
            'lawyer_id' => $row['lawyer_id'],
            'case_id' => $row['case_id'],
            'cust_id' => $row['cust_id'],
            'court_name' => $row['court_name'],
            'session_date' => $row['session_date'],
            'session_time' => $row['session_time'],
            'session_type' => $row['session_type'],
            'session_title' => $row['session_title'],
            'opponent_name' => $row['opponent_name'],
            'opponent_representative' => $row['opponent_representative'],
            'session_status' => $row['session_status'],
            'session_result' => $row['session_result'],
            'lawyer_name' => $row['lawyer_name'],
            'customer' => $row['customer'] 
             
          );

          // Push to "data"
          array_push($session_arr['data'], $session_item);
        }

        // Turn to JSON & output
        echo json_encode($session_arr);

  } else {
        // No Sessions
        echo json_encode(
          array('message' => 'No Sessions Found')
        );
  }
?>
