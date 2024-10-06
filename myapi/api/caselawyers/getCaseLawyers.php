<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/caselawyers.php';
  
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();
  // Instantiate blog case object
  $case = new Caselawyers($db);

  // Get ID
  $case->case_id = isset($_GET['case_id']) ? $_GET['case_id'] : die();

  // Get post
  $result = $case->getCaseLaywers();
  $num = $result->rowCount();
  // Create array
  $case_arr = array();
  $case_arr['data'] = array();
if($num > 0) {
  while($row = $result->fetch(PDO::FETCH_ASSOC)) {
  extract($row);
  $case_arr = array(
    'case_id' => $row['case_id'],
    'full_name' => $row['full_name'],
    'user_id' => $row['user_id']
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