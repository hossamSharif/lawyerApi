<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/cases.php';
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();
  // Instantiate blog case object
  $case = new Cases($db);

  // Get ID
  $case->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Get post
  $result = $case->getCaseById();
  $num = $result->rowCount();
  // Create array
  $case_arr = array();
  $case_arr['data'] = array();
if($num > 0) {
  while($row = $result->fetch(PDO::FETCH_ASSOC)) {
  extract($row);
  $case_arr = array(
    'id' => $row['id'],
    'case_title' => $row['case_title'],
    'client_id' => $row['client_id'],
    'client_name' => $row['client_name'],
    'case_type' => $row['case_type'],
    'client_role' => $row['client_role'],
    'service_classification' => $row['service_classification'],
    'branch' => $row['branch'],
    'court_name' => $row['court_name'],
    'opponent_name' => $row['opponent_name'],
    'opponent_id' => $row['opponent_id'],
    'opponent_representative' => $row['opponent_representative'],
    'case_open_date' => $row['case_open_date'],
    'deadline' => $row['deadline'],
    'billing_type' => $row['billing_type'],
    'claim_type' => $row['claim_type'],
    'work_hour_value' => $row['work_hour_value'],
    'estimated_work_hours' => $row['estimated_work_hours'],
    'case_status' => $row['case_status'],
    'status_name' => $row['status_name'],
    'status_color' => $row['status_color'],
    'constraintId_najz' => $row['constraintId_najz'],
    'archive_id_najz' => $row['archive_id_najz'],
    'caseId_najz' => $row['caseId_najz'],
    'case_classification_najz' => $row['case_classification_najz'],
    'case_open_date_najz' => $row['case_open_date_najz'],
    'Plaintiff_Requests' => $row['Plaintiff_Requests'],
    'case_status_najz' => $row['case_status_najz'],
    'case_subject' => $row['case_subject'],
    'team' => json_decode( '['. $row['team'] .']')
  );                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
  // Make JSON
  print_r(json_encode($case_arr));
} 
}else{ 
  // No Posts
  echo json_encode(
    array('message' => 'No record Found')
  );  
}