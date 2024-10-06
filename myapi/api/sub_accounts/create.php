<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/sub_accounts.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $invoice = new Sub_accounts($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input")); 
   

  $invoice->sub_name = $data->sub_name;
  $invoice->ac_id = $data->ac_id;
  $invoice->sub_type = $data->sub_type;
  $invoice->sub_balance = $data->sub_balance;
  $invoice->sub_code = $data->sub_code;
  $invoice->store_id = $data->store_id;
   $invoice->cat_id = $data->cat_id;
  $invoice->cat_name = $data->cat_name;
   $invoice->phone = $data->phone;
    $invoice->address = $data->address;
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

