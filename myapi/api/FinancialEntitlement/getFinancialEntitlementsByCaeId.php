<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/financialEntitlements.php';
  
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();
  // Instantiate financial entitlement object
  $financial_entitlement = new Financial_entitlement($db);

  // Get case_id
  $financial_entitlement->case_id = isset($_GET['case_id']) ? $_GET['case_id'] : die();

  // Get financial entitlements
  $result = $financial_entitlement->getFinancialEntitlementByCaseId();
  $num = $result->rowCount();
  // Create array
  $financial_entitlement_arr = array();
  $financial_entitlement_arr['data'] = array();
if($num > 0) {
  while($row = $result->fetch(PDO::FETCH_ASSOC)) {
  extract($row);
  $financial_entitlement_arr = array(
    'case_id' => $row['case_id'],
    'client_id' => $row['client_id'],
    'amount' => $row['amount'],
    'due_date' => $row['due_date'],
    'status' => $row['status'],
    'description' => $row['description'],
    'created_at' => $row['created_at']
  );                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
  // Make JSON
  print_r(json_encode($financial_entitlement_arr));
} 
}else{ 
  // No records found
  echo json_encode(
    array('message' => 'No record Found')
  );  
}
?>
