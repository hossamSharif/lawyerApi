<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/year.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $invoice = new FinancialYear($db);
 

  // Get post
  $result = $invoice->readByStoreByRef();
   
  $num = $result->rowCount();
 
  if($num > 0) {
    // Post array
    $invoices_arr = array();
     $invoices_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
       
      $invoice_item = array( 
        'id' => $id,
        'yearDesc' => $yearDesc,
        'yearStart' => $yearStart,
        'yearEnd' => $yearEnd
      );

      // Push to "data"
     // array_push($invoices_arr, $invoice_item);
      array_push($invoices_arr['data'], $invoice_item);
    }

    // Turn to JSON & output
    echo json_encode($invoices_arr);

  } else {
    // No Posts
    echo json_encode(
      array('message' => 'No record Found')
    );
  }
 