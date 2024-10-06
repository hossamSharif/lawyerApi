<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Nursing.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $nursing = new Nursing($db);

  // Get ID
  $nursing->nurs_id = isset($_GET['nurs_id']) ? $_GET['nurs_id'] : die();

  // Get post
  $nursing->read_single();

  // Create array
  $nursing_arr = array(
    'nurs_id' => $nursing->nurs_id,
    'nurs_desc' => $nursing->nurs_desc, 
    'nurs_price' => $nursing->nurs_price
     
  );

  // Make JSON
  print_r(json_encode($nursing_arr));