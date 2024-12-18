<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/sessions.php';
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();
  // Instantiate blog case object
  $case = new Sessions($db);

  // Get ID
  $case->case_id = isset($_GET['case_id']) ? $_GET['case_id'] : die(); 

  // Get post
  $result = $case->getSessionsByCaseId();
  $num = $result->rowCount();
  // Create array
  $case_arr = array();
  $case_arr['data'] = array();
if($num > 0) {
  while($row = $result->fetch(PDO::FETCH_ASSOC)) {
  extract($row);
  $case_item = array(
            'id' => $row['id'],
            'lawyer_id' => $row['lawyer_id'],
            'case_id' => $row['case_id'],
            'cust_id' => $row['cust_id'],
            'court_id' => $row['court_id'],
            'session_date' => $row['session_date'],
            'session_time' => $row['session_time'],
            'session_type' => $row['session_type'],
            'session_title' => $row['session_title'],
            'opponent_name' => $row['opponent_name'],
            'opponent_representative' => $row['opponent_representative'],
            'session_status' => $row['session_status'],
            'session_result' => $row['session_result'],
            'lawyer_name' => $row['lawyer_name'],
            'customer' => $row['customer'] ,
            'court_name' => $row['court_name']
       );  
       
        // Push to "data"
        array_push($case_arr['data'], $case_item);
  
     } 
     echo json_encode($case_arr);
}else{ 
  // No Posts
  echo json_encode(
    array('message' => 'No Sessions Found')
  );  
}