<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/contracts.php';
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();
  // Instantiate contract object
  $contract = new Contracts($db);

  // Get range
  $contract->startrange = isset($_GET['startrange']) ? $_GET['startrange'] : die();
  $contract->endrange = isset($_GET['endrange']) ? $_GET['endrange'] : die();

  // Get post
  $result = $contract->getContractsInRange();
  $num = $result->rowCount();
  // Create array
  $contract_arr = array();
  $contract_arr['data'] = array();
if($num > 0) {
  while($row = $result->fetch(PDO::FETCH_ASSOC)) {
  extract($row);
  $contract_arr = array(
    'id' => $row['id'],
    'contract_title' => $row['contract_title'],
    'client_id' => $row['client_id'],
    'client_name' => $row['client_name'],
    'contract_date' => $row['contract_date'],
    'end_date' => $row['end_date'],
    'draft' => $row['draft'],
    'amount' => $row['amount'],
    'due_date' => $row['due_date'],
    'legal_services' => json_decode('[' . $row['legal_services'] . ']'),
    'payments' => json_decode('[' . $row['payments'] . ']')
  );                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
  // Make JSON
  print_r(json_encode($contract_arr));
} 
}else{ 
  // No records found
  echo json_encode(
    array('message' => 'No record Found')
  );  
}
?>
