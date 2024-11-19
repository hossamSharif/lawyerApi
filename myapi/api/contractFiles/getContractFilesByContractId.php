<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/contract_files.php';
  
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();
  // Instantiate contract files object
  $contract_files = new ContractFiles($db);

  // Get ID
  $contract_files->contract_id = isset($_GET['contract_id']) ? $_GET['contract_id'] : die();

  // Get post
  $result = $contract_files->getContractFilesByContractId();
  $num = $result->rowCount();
  // Create array
  $contract_files_arr = array();
  $contract_files_arr['data'] = array();
if($num > 0) {
  while($row = $result->fetch(PDO::FETCH_ASSOC)) {
  extract($row);
  $contract_files_arr = array(
    'contract_id' => $row['contract_id'],
    'user_id' => $row['user_id'],
    'file_name' => $row['file_name'],
    'file_size' => $row['file_size'],
    'file_url' => $row['file_url'],
    'file_notes' => $row['file_notes'],
    'uploaded_at' => $row['uploaded_at']
  );                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
  // Make JSON
  print_r(json_encode($contract_files_arr));
} 
}else{ 
  // No records found
  echo json_encode(
    array('message' => 'No record Found')
  );  
}
?>
