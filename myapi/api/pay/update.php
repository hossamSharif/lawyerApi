<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/pay.php'; 
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect(); 
  // Instantiate blog post object
  $invoice = new Pay($db); 
  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  // Set ID to update
  $invoice->pay_id = $data->pay_id; 
  $invoice->pay_ref = $data->pay_ref;
  $invoice->store_id = $data->store_id;
  $invoice->tot_pr = $data->tot_pr;
  $invoice->pay = $data->pay;
  $invoice->changee = $data->changee;
  $invoice->pay_date = $data->pay_date;
  $invoice->pay_method = $data->pay_method;
  $invoice->cust_id = $data->cust_id;
  $invoice->discount = $data->discount;
  $invoice->pay_time = $data->pay_time;
  $invoice->user_id = $data->user_id; 
   $invoice->payComment = $data->payComment; 
    $invoice->nextPay = $data->nextPay; 
    $invoice->yearId = $data->yearId; 
    $invoice->taxTot = $data->taxTot; 
    $invoice->recived = $data->recived; 
    $invoice->backed = $data->backed; 

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

