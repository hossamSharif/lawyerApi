<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/journal.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $invoice = new Journal($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input")); 
   
  $invoice->j_ref = $data->j_ref;
  $invoice->j_date = $data->j_date;
  $invoice->j_details = $data->j_details; 
  $invoice->j_type = $data->j_type;
  $invoice->invo_ref = $data->invo_ref;
  $invoice->store_id = $data->store_id; 
  $invoice->j_desc = $data->j_desc;
  $invoice->user_id = $data->user_id;
  $invoice->j_pay = $data->j_pay;
  $invoice->standard_details = $data->standard_details;
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

