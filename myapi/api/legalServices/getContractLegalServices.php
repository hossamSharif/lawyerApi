<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/legal_services.php';
  
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();
  // Instantiate legal services object
  $legal_services = new LegalServices($db);

  // Get ID
  $legal_services->contract_id = isset($_GET['contract_id']) ? $_GET['contract_id'] : die();

  // Get post
  $result = $legal_services->getLegalServicesByContractId();
  $num = $result->rowCount();
  // Create array
  $legal_services_arr = array();
  $legal_services_arr['data'] = array();
if($num > 0) {
  while($row = $result->fetch(PDO::FETCH_ASSOC)) {
  extract($row);
  $legal_services_arr = array(
    'contract_id' => $row['contract_id'],
    'service_type' => $row['service_type'],
    'service_title' => $row['service_title'],
    'service_id' => $row['service_id']
  );                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
  // Make JSON
  print_r(json_encode($legal_services_arr));
} 
}else{ 
  // No records found
  echo json_encode(
    array('message' => 'No record Found')
  );  
}
?>
