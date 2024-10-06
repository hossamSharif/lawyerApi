<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/loghistory.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $invoice = new Loghistory($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input")); 
  
  $invoice->logRef = $data->logRef; 
  $invoice->datee = $data->datee;
  $invoice->userId = $data->userId; 
  $invoice->typee = $data->typee;
  $invoice->store_id = $data->store_id;
  $invoice->logStatus = $data->logStatus; 
  $invoice->logToken = $data->logToken;  
  $invoice->yearId= $data->yearId; 
  
  // Create post
  if($invoice->create()) {
    $last_id = $db->lastInsertId();
    echo json_encode( 
      array('message' =>  $last_id )
    );
  } else {
    echo json_encode(
      array('message' => 'Post Not Created')
    );
  }

