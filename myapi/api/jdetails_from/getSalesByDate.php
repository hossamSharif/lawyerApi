<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/jdetails_from.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $invoice = new Jdetails_from($db);

  // Get ID
 
  $invoice->store_id = isset($_GET['store_id']) ? $_GET['store_id'] : die();
  $invoice->j_date = isset($_GET['from']) ? $_GET['from'] : die();
    $invoice->yearId = isset($_GET['yearId']) ? $_GET['yearId'] : die();

  // Get post
  $result = $invoice->readByDate();
   
  $num = $result->rowCount();
  
  if($num > 0) {
    // Post array
    $invoices_arr = array();
      $invoices_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      
      $invoice_item = array( 
      'id'=> $id,
        'j_id' => $j_id,
        'j_ref' => $j_ref,
        'ac_id' => $ac_id,
        'j_type' => $j_type,
         'credit' => $credit,
         'store_id' => $store_id,
        'debit' => $debit,
         'j_date' => $j_date,
        'j_details' => $j_details,
         'invo_ref' => $invo_ref,
         'j_desc' => $j_desc,
         'store_id' => $store_id,
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
 