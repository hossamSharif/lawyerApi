<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: DELETE');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/payments.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate payments object
  $payments = new Payments($db);

  // Get raw posted data
  // $data = json_decode(file_get_contents("php://input"));

  // Set ID to update
  $payments->contract_id = isset($_GET['contract_id']) ? $_GET['contract_id'] : die();
  
  // Delete post
  if($payments->deleteMulti()) {
    echo json_encode(
      array('message' => 'Payments Deleted')
    );
  } else {
    echo json_encode(
      array('message' => 'Payments Not Deleted')
    );
  }
?>
