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
  $payments->case_id = isset($_GET['case_id']) ? $_GET['case_id'] : die();

  // Get post
  $result = $payments->getPaymentsByCaseId();
  $num = $result->rowCount();
  // Create array
  $payments_arr = array();
  $payments_arr['data'] = array();
if($num > 0) {
  while($row = $result->fetch(PDO::FETCH_ASSOC)) {
  extract($row);
  $payments_arr = array(
    'case_id' => $row['case_id'],
    'amount' => $row['amount'],
    'payment_date' => $row['payment_date'],
    'notification_date' => $row['notification_date'],
    'notification_type' => $row['notification_type'],
    'notification_daysBefor' => $row['notification_daysBefor'],
    'notification_id' => $row['notification_id'] 

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
