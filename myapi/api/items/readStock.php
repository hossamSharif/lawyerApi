<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/items.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $invoice = new Items($db);

  // Get ID
 
  $invoice->store_id = isset($_GET['store_id']) ? $_GET['store_id'] : die();

  // Get post
  $result = $invoice->readStock();
   
  $num = $result->rowCount();
  
  if($num > 0) {
    // Post array
    $invoices_arr = array();
    $invoices_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      $invoice_item = array( 
        'id' => $id,
        'item_name' => $item_name,
        'part_no' => $part_no,
         'model' => $model,
        'brand' => $brand,
        'min_qty' => $min_qty,
        'item_unit' => $item_unit,
        'pay_price' => $pay_price, 
        'perch_price' => $perch_price,
        'item_desc' => $item_desc,
        'item_parcode' => $item_parcode,
        'salesQuantity' => $salesQuantity ,
        'perchQuantity' => $perchQuantity ,
        'firstQuantity' => $firstQuantity ,
        'lastSoldDate' => $lastSoldDate ,
        'lastSoldQty' => $lastSoldQty,
         'aliasEn' => $aliasEn,
          'tswiaQuantity' => $tswiaQuantity,
          'sales29' => $sales28,
          'purch28' => $purch28,
          'imgUrl' => $imgUrl,
          'tax' => $tax
          
         
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
 