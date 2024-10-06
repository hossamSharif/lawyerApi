<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/discount.php'; 
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect(); 
  // Instantiate blog post object
  $invoice = new Discount($db); 

  // Get ID
 
  $invoice->store_id = isset($_GET['store_id']) ? $_GET['store_id'] : die();
  $invoice->yearId = isset($_GET['yearId']) ? $_GET['yearId'] : die();
  // Get post
  $result = $invoice->getTopSales();
   
  $num = $result->rowCount();
  
  if($num > 0) {
    // Post array
    $invoices_arr = array();
      $invoices_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row); 
      $invoice_item = array( 
        'id' => $id,
        'perc' => $perc,
        'from_date' => $from_date,
        'to_date' => $to_date, 
        'descr' => $descr, 
        'store_id' => $store_id,
        'yearId' => $yearId  ,
        'user_id' => $user_id  ,
        'user_name' => $user_name  ,
        'status' => $status  

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
 