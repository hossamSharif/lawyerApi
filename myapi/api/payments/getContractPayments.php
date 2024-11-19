<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/payments.php';
  
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();
  // Instantiate payments object
  $payments = new Payments($db);

  // Get ID
  $payments->contract_id = isset($_GET['contract_id']) ? $_GET['contract_id'] : die();

  // Get post
  $result = $payments->getPaymentsByContractId();
  $num = $result->rowCount();
  // Create array
  $payments_arr = array();
  $payments_arr['data'] = array();
if($num > 0) {
  while($row = $result->fetch(PDO::FETCH_ASSOC)) {
  extract($row);
  $payments_arr = array(
    'contract_id' => $row['contract_id'],
    'amount' => $row['amount'],
    'payment_date' => $row['payment_date'],
    'due_date' => $row['due_date']
  );                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
  // Make JSON
  print_r(json_encode($payments_arr));
} 
}else{ 
  // No records found
  echo json_encode(
    array('message' => 'No record Found')
  );  
}
?>
