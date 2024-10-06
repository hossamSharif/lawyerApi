<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Invoice.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $invoice = new Invoice($db);
  

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  // Set ID to update
  $invoice->rec_id = $data->rec_id; 
  $invoice->rec_ref = $data->rec_ref;
  $invoice->ac_id = $data->ac_id;
  $invoice->rec_type = $data->rec_type; 
  $invoice->rec_detailes = $data->rec_detailes;
  $invoice->store_id = $data->store_id;
  $invoice->rec_pay = $data->rec_pay; 
  $invoice->user_id = $data->user_id;
  $invoice->rec_date = $data->rec_date; 
    $invoice->yearId = $data->yearId;
  // Update post
  if($invoice->update()) {
    echo json_encode(
      array('message' => 'Post Updated')
    );
  } else {
    echo json_encode(
      array('message' => 'Post Not Updated')
    );
  }

