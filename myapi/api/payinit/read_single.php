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
  $invoice->invo_id = isset($_GET['invo_id']) ? $_GET['invo_id'] : die();

  // Get post
  $invoice->read_single();

  // Create array
  $invoice_arr = array(
    'invo_id' => $invoice->invo_id,
    'pt_name' => $invoice->pt_name,
    'pt_age' => $invoice->pt_age, 
    'pt_phone' => $invoice->pt_phone,
    'datee' => $invoice->datee,
    'total' => $invoice->total,
    'net_total' => $invoice->net_total,
    'insurans' => $invoice->insurans,
    'insur_price' => $invoice->insur_price,
    'status' => $invoice->status,
    'user_id' => $invoice->user_id,
    'device_id' => $invoice->device_id,
    'user_name' => $invoice->user_name,
    'invo_type' => $invoice->invo_type
 
 
  );

  // Make JSON
  print_r(json_encode($invoice_arr));