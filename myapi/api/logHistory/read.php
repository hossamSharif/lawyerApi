<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Pay.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $invoice = new pay($db);

  // Blog post query
  $result = $invoice->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any posts
  if($num > 0) {
    // Post array
    $invoices_arr = array();
    // $invoices_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      
       
      $invoice_item = array( 
        'pay_id' => $pay_id,
        'pay_ref' => $pay_ref,
        'tot_pr' => $tot_pr,
        'pay_date' => $pay_date, 
        'pay_time' => $pay_time,
        'cust_id' => $cust_id,
        'discount' => $discount,
        'change' => $change,
        'user_id' => $user_id,
        'pay' => $pay,
        'store_id' => $store_id,
        'pay_method' => $pay_method,
         'payComment' => $payComment 
      );

      // Push to "data"
      array_push($invoices_arr, $invoice_item);
      // array_push($invoices_arr['data'], $invoice_item);
    }

    // Turn to JSON & output
    echo json_encode($invoices_arr);

  } else {
    // No Posts
    echo json_encode(
      array('message' => 'No Posts Found')
    );
  }