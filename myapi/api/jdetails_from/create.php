<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/jdetails_from.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $invoice = new Jdetails_from($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input")); 
   
  $invoice->j_ref = $data->j_ref;
  $invoice->j_id = $data->j_id;
  $invoice->ac_id = $data->ac_id; 
  $invoice->j_type = $data->j_type;
  $invoice->credit = $data->credit;
  $invoice->debit = $data->debit; 
  $invoice->store_id = $data->store_id; 
  $invoice->yearId = $data->yearId; 
  
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

