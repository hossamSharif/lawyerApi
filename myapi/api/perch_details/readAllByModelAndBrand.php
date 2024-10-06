<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/perch_details.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $invoice = new Perch_details($db);

  // Get ID
 
  $invoice->store_id = isset($_GET['store_id']) ? $_GET['store_id'] : die(); 
  $invoice->brand = isset($_GET['brand']) ? $_GET['brand'] : die();
  $invoice->model = isset($_GET['model']) ? $_GET['model'] : die();
  $invoice->yearId = isset($_GET['yearId']) ? $_GET['yearId'] : die(); 

  // Get post
  $result = $invoice->readAllByModelAndBrand();
   
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
        'quantity' => $quantity,
        'store_id' => $store_id,
        'tot' => $tot,
        'item_id' => $item_id,
        'dateCreated' => $dateCreated,
        'perch_price' => $perch_price ,
        'cust_id' => $cust_id ,
        'pay_date' => $pay_date,
        'sub_name' => $sub_name , 
        'tot_pr' => $tot_pr ,
        'pay_time' => $pay_time ,   
        'discount' => $discount ,   
        'changee' => $changee ,   
        'user_id' => $user_id ,   
        'pay' => $pay ,   
        'pay_method' => $pay_method ,
           'yearId' => $yearId ,
           'netTot' => $tot - (($discount/$tot_pr)*100)/100 * $tot
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
 