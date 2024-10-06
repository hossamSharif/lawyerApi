<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Xray.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $xray = new Xray($db);

  // Get ID
  $xray->xray_id = isset($_GET['xray_id']) ? $_GET['xray_id'] : die();

  // Get post
  $xray->read_single();

  // Create array
  $xray_arr = array(
    'xray_id' => $xray->xray_id,
    'xray_desc' => $xray->xray_desc,
    // 'body' => html_entity_decode($body),
    'xray_type' => $xray->xray_type,
    'xray_price' => $xray->xray_price
     
  );

  // Make JSON
  print_r(json_encode($xray_arr));