<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/case_status.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate case_status object
  $case_status = new caseStatus($db);

  // case_status read query
  $result = $case_status->read();
  
  // Get row count
  $num = $result->rowCount();

  // Check if any case_status
  if($num > 0) {
        // case_status array
        $case_status_arr = array();
        $case_status_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
          extract($row);
        
          $case_status_item = array(
            'id' => $row['id'],
            'status_name' => $row['status_name'],
            'status' => $row['status'],
            'status_color' => $row['status_color']
          );

          // Push to "data"
          array_push($case_status_arr['data'], $case_status_item);
        }

        // Turn to JSON & output
        echo json_encode($case_status_arr);

  } else {
        // No case_status
        echo json_encode(
          array('message' => 'No case status Found')
        );
  }
?>
