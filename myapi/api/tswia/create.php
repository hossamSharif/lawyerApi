<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/tswia.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $invoice = new Tswia($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input")); 
  
  $invoice->pay_ref = $data->pay_ref;
  $invoice->tot_pr = $data->tot_pr;
  $invoice->pay_date = $data->pay_date;
  $invoice->pay_time = $data->pay_time;
  
  $invoice->user_id = $data->user_id;
  
  $invoice->store_id = $data->store_id;
  
  $invoice->payComment = $data->payComment; 
  
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

