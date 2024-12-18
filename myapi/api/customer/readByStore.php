<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/customer.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $invoice = new Customer($db);

  // Get ID
 
  // $invoice->store_id = isset($_GET['store_id']) ? $_GET['store_id'] : die();
  // $invoice->ac_id = isset($_GET['ac_id']) ? $_GET['ac_id'] : die();
  // $invoice->yearId = isset($_GET['yearId']) ? $_GET['yearId'] : die();
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
        'id' => $id,
        'cust_name' => $cust_name,
        'cust_type' => $cust_type, 
        'cust_ref' => $cust_ref,
        'cust_ident' => $cust_ident,
        'phone' => $phone,
        'email' => $email ,
        'company_name' => $company_name ,
        'company_ident' => $company_ident ,
        'company_regno' => $company_regno ,
        'company_phone' => $company_phone ,
         'company_represent' => $company_represent ,
         'company_email' => $company_email ,
         'status' => $status  ,
         'passport' => $passport ,
         'full_address' => $full_address ,
         'city' => $city ,
         'region' => $region ,
         'company_represent_desc' => $company_represent_desc,
         'phone_key' => $phone_key  
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
 