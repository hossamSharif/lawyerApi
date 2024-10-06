<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/logHistory.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $invoice = new LogHistory($db);

  // Get ID
 
  $invoice->store_id = isset($_GET['store_id']) ? $_GET['store_id'] : die();
  $invoice->yearId = isset($_GET['yearId']) ? $_GET['yearId'] : die();
   $invoice->from= isset($_GET['from']) ? $_GET['from'] : die();
  // Get post
  $result = $invoice->readByStore();
   
  $num = $result->rowCount();
  
  if($num > 0) {
    // Post array
    $invoices_arr = array();
    // $invoices_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      
    $invoice_item = array( 
        'id' => $id,
        'logRef' => $logRef,
        'userId' => $userId,
        'datee' => $datee, 
        'typee' => $typee,
        'logStatus' => $logStatus, 
        'store_id' => $store_id, 
        'yearId' => $yearId,
         'user_name' => $user_name
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
      array('message' => 'No record Found')
    );
  }
 