<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/courts.php';
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();
  // Instantiate court object
  $court = new Courts($db);

  // Get ID
  $court->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Get court
  $result = $court->getCourtById();
  $num = $result->rowCount();
  // Create array
  $court_arr = array();
  $court_arr['data'] = array();
if($num > 0) {
  while($row = $result->fetch(PDO::FETCH_ASSOC)) {
  extract($row);
  $court_arr = array(
    'id' => $row['id'],
    'court_name' => $row['court_name'],
    'status' => $row['status']
  );                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
  // Make JSON
  print_r(json_encode($court_arr));
} 
}else{ 
  // No records found
  echo json_encode(
    array('message' => 'No record Found')
  );  
}
?>
