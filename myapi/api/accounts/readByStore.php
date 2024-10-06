<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/accounts.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $invoice = new Accounts($db);

  // Get ID
 
  

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
        'ac_name' => $ac_name,
        'ac_id' => $ac_id,
        'actype_id' => $actype_id,  
        'ac_balance' => $sub_balance,
        'eng_name' => $eng_name,
        'ac_type' => $ac_type
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
 