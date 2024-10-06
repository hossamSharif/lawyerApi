<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
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
  
  $invoice->pay_ref = $data->pay_ref;
  $invoice->tot_pr = $data->tot_pr;
  $invoice->pay_date = $data->pay_date;
  $invoice->pay_time = $data->pay_time;
  $invoice->cust_id = $data->cust_id;
  $invoice->discount = $data->discount;
  $invoice->changee = $data->changee;
  $invoice->user_id = $data->user_id;
  $invoice->pay = $data->pay;
  $invoice->store_id = $data->store_id;
  $invoice->pay_method = $data->pay_method; 
  $invoice->payComment = $data->payComment; 
  $invoice->nextPay= $data->nextPay; 
  $invoice->yearId= $data->yearId; 
  $invoice->companyId= $data->companyId; 
  $invoice->taxTot= $data->taxTot; 
  $invoice->recived= $data->recived; 
  $invoice->backed= $data->backed; 
  
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

