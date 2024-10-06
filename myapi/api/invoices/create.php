<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/invoices.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $invoice = new Invoices($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input")); 
 
  $invoice->rec_ref = $data->rec_ref;
  $invoice->ac_id = $data->ac_id;
  $invoice->rec_type = $data->rec_type; 
  $invoice->rec_date = $data->rec_date; 
  $invoice->rec_detailes = $data->rec_detailes;
  $invoice->store_id = $data->store_id;
  $invoice->rec_pay = $data->rec_pay; 
  $invoice->user_id = $data->user_id;
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

