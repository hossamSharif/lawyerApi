<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/journal.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $invoice = new Journal($db);

  // Get ID
 
  $invoice->store_id = isset($_GET['store_id']) ? $_GET['store_id'] : die();
$invoice->yearId = isset($_GET['yearId']) ? $_GET['yearId'] : die();
  // Get post
  $result = $invoice->readByStore();
   
  $num = $result->rowCount();
  
  if($num > 0) {
    // Post array
    $invoices_arr = array();
    $invoices_arr['data'] = array();

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
        'store_id' => $store_id ,
         'j_pay' => $j_pay ,
          'standard_details' => $standard_details ,
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
 