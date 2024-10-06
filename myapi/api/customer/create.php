<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/customer.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $invoice = new Customer($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input")); 
  

  $invoice->cust_name = $data->cust_name;
  $invoice->cust_type = $data->cust_type;
  $invoice->cust_ident = $data->cust_ident;
  $invoice->cust_ref = $data->cust_ref;
  $invoice->email = $data->email;
  $invoice->phone = $data->phone;
  $invoice->company_email = $data->company_email;
  $invoice->company_name = $data->company_name;
   $invoice->company_phone = $data->company_phone;
  $invoice->company_regno = $data->company_regno;
   $invoice->company_ident = $data->company_ident;
   $invoice->status = $data->status;
   $invoice->company_represent = $data->company_represent;
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

