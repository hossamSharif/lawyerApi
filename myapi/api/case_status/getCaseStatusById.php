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

  // Get ID
  $case_status->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Get case_status
  $result = $case_status->getCaseStatusById();
  $num = $result->rowCount();
  // Create array
  $case_status_arr = array();
  $case_status_arr['data'] = array();
if($num > 0) {
  while($row = $result->fetch(PDO::FETCH_ASSOC)) {
  extract($row);
  $case_status_arr = array(
    'id' => $row['id'],
    'status_name' => $row['status_name'],
    'status' => $row['status'],
    'status_color' => $row['status_color']
  );                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
  // Make JSON
  print_r(json_encode($case_status_arr));
} 
}else{ 
  // No records found
  echo json_encode(
    array('message' => 'No record Found')
  );  
}
?>
