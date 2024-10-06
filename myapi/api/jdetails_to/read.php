<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/jdetails_to.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $invoice = new Jdetails_to($db);

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
        'j_id' => $j_id,
        'j_ref' => $j_ref,
        'j_date' => $j_date, 
        'j_details' => $j_details,
        'j_type' => $j_type,
        'invo_ref' => $invo_ref,
        'j_desc' => $j_desc, 
        'user_id' => $user_id, 
        'store_id' => $store_id 
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
