<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Invoice.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $invoice = new Invoice($db);
  

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  // Set ID to update
  $invoice->invo_id = $data->invo_id; 
  $invoice->pt_name = $data->pt_name;
  $invoice->pt_age = $data->pt_age;
  $invoice->pt_phone = $data->pt_phone;
  $invoice->datee = $data->datee;
  $invoice->total = $data->total;
  $invoice->net_total = $data->net_total;
  $invoice->insurans = $data->insurans;
  $invoice->insur_price = $data->insur_price;
  $invoice->status = $data->status;
  $invoice->user_id = $data->user_id;
  $invoice->device_id = $data->device_id;
  $invoice->user_name = $data->user_name;
  $invoice->invo_type = $data->invo_type;
  $invoice->pt_adress = $data->pt_adress;

  // Update post
  if($invoice->update()) {
    echo json_encode(
      array('message' => 'Post Updated')
    );
  } else {
    echo json_encode(
      array('message' => 'Post Not Updated')
    );
  }

