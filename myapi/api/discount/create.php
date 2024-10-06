<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/discount.php'; 
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect(); 
  // Instantiate blog post object
  $invoice = new Discount($db); 

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input")); 
  
  $invoice->id = $data->id; 
  $invoice->perc = $data->perc;
  $invoice->store_id = $data->store_id;  
  $invoice->from_date = $data->from_date;
  $invoice->to_date = $data->to_date;
   
  $invoice->user_id = $data->user_id; 
  $invoice->yearId = $data->yearId; 
  $invoice->descr = $data->descr; 
  $invoice->status = $data->status; 

  
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

