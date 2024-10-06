<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/sub_accounts.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $invoice = new Sub_accounts($db);

  // Get ID
 
  $invoice->store_id = isset($_GET['store_id']) ? $_GET['store_id'] : die();
  

  // Get post
  $result = $invoice->readAllStore();
   
  $num = $result->rowCount();
  
  if($num > 0) {
    // Post array
    $invoices_arr = array();
    $invoices_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      $invoice_item = array( 
        'id' => $id,
        'sub_name' => $sub_name,
        'ac_id' => $ac_id,
        'sub_type' => $sub_type, 
        'sub_code' => $sub_code,
        'sub_balance' => $sub_balance,
        'store_id' => $store_id, 
        'debitTot' => $debitTot, 
        'creditTot' => $creditTot 
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
 