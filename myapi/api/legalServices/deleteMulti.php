<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: DELETE');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/legal_services.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate legal services object
  $legal_services = new LegalServices($db);

  // Get raw posted data
  // $data = json_decode(file_get_contents("php://input"));

  // Set ID to update
  $legal_services->contract_id = isset($_GET['contract_id']) ? $_GET['contract_id'] : die();
  
  // Delete post
  if($legal_services->deleteMulti()) {
    echo json_encode(
      array('message' => 'Legal Services Deleted')
    );
  } else {
    echo json_encode(
      array('message' => 'Legal Services Not Deleted')
    );
  }
?>
