<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: DELETE');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/contract_files.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate contract files object
  $contract_files = new ContractFiles($db);

  // Get raw posted data
  // $data = json_decode(file_get_contents("php://input"));

  // Set ID to update
  $contract_files->contract_id = isset($_GET['contract_id']) ? $_GET['contract_id'] : die();
  
  // Delete post
  if($contract_files->deleteMulti()) {
    echo json_encode(
      array('message' => 'Contract Files Deleted')
    );
  } else {
    echo json_encode(
      array('message' => 'Contract Files Not Deleted')
    );
  }
?>
