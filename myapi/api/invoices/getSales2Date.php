<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/invoices.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $invoice = new Invoices($db);

  // Get ID
 
  $invoice->store_id = isset($_GET['store_id']) ? $_GET['store_id'] : die();
  $invoice->rec_date = isset($_GET['from']) ? $_GET['from'] : die();
  $invoice->rec_date2 = isset($_GET['to']) ? $_GET['to'] : die();
  $invoice->yearId = isset($_GET['yearId']) ? $_GET['yearId'] : die();
   

  // Get post
  $result = $invoice->getSales2Date();
   
  $num = $result->rowCount();
  
  if($num > 0) {
    // Post array
    $invoices_arr = array();
      $invoices_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
    
      $invoice_item = array( 
        'rec_id' => $rec_id,
        'rec_ref' => $rec_ref,
        'ac_id' => $ac_id,
        'rec_type' => $rec_type, 
        'rec_date' => $rec_date,
        'rec_detailes' => $rec_detailes,
        'store_id' => $store_id,
        'rec_pay' => $rec_pay,
        'user_id' => $user_id ,
         'yearId' => $yearId 

      );

      // Push to "data"
      array_push($invoices_arr['data'], $invoice_item);
      // array_push($invoices_arr['data'], $invoice_item);
    }

    // Turn to JSON & output
    echo json_encode($invoices_arr);

  } else {
    // No Posts
    echo json_encode(
      array('message' => 'No record Found')
    );
  }
 