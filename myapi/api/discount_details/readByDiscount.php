<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/discount_details.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $invoice = new discount_details($db);

  // Get ID
 
  
  $invoice->discount_id = isset($_GET['discount_id']) ? $_GET['discount_id'] : die(); 

  // Get post
  $result = $invoice->readByDiscount();
   
  $num = $result->rowCount();
 
  if($num > 0) {
    // Post array
    $invoices_arr = array();
     $invoices_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      
      $invoice_item = array( 
        'id' => $id,
        'discount_id' => $discount_id,
        'perc' => $perc,
        'from_date' => $from_date, 
        'to_date' => $to_date,
        'item_id' => $item_id 
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
 