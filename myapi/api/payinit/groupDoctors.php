<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Invoice.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $invoice = new Invoice($db);

  // Get ID
  $invoice->datee = isset($_GET['datee']) ? $_GET['datee'] : die();
  $invoice->serv_type = isset($_GET['serv_type']) ? $_GET['serv_type'] : die();
  $invoice->serv_id = isset($_GET['serv_id']) ? $_GET['serv_id'] : die();
 

  // Get post
  $result = $invoice->gorupDoctors();
   
  $num = $result->rowCount();
  
  if($num > 0) {
    // Post array
    $invoices_arr = array();
    // $invoices_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      
      $invoice_item = array( 
        'invo_id' => $invo_id,
        'pt_name' => $pt_name,
        'pt_age' => $pt_age, 
        'pt_phone' => $pt_phone,
        'datee' => $datee,
        'total' => $total,
        'net_total' => $net_total,
        'insurans' => $insurans,
        'insur_price' => $insur_price,
        'status' => $status,
        'user_id' => $user_id,
        'device_id' => $device_id,
        'user_name' => $user_name,
        'invo_type' => $invo_type,  
        'list_ordering' => $list_ordering ,
        'serviceId' => $id  
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
 