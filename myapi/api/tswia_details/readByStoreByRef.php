<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/tswia_details.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $invoice = new Tswia_details($db);

  // Get ID
 
  $invoice->store_id = isset($_GET['store_id']) ? $_GET['store_id'] : die();
  $invoice->pay_ref = isset($_GET['pay_ref']) ? $_GET['pay_ref'] : die();
  $invoice->yearId = isset($_GET['yearId']) ? $_GET['yearId'] : die(); 
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
        'pay_ref' => $pay_ref,
        'item_name' => $item_name,
        'pay_price' => $pay_price, 
        'qtyReal' => $qtyReal,
        'store_id' => $store_id,
        'tot' => $tot,
        'item_id' => $item_id,
        'dateCreated' => $dateCreated,
        'perch_price' => $perch_price,
          'yearId' => $yearId ,
           'availQty' => $availQty 
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
 