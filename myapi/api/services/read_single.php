<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Services.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $services = new Services($db);

  // Get ID
  $services->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Get post
  $services->read_single();

  // Create array
  $services_arr = array(
    'id' => $services->id,
    'ptinvo_id' => $services->ptinvo_id,
    'serv_desc' => $services->serv_desc, 
    'serv_price' => $services->serv_price,
    'serv_type' => $services->serv_type,
    'list_ordering' => $services->list_ordering,
    'status' => $services->status,
    'serv_id' => $services->serv_id 
 
  );

  // Make JSON
  print_r(json_encode($services_arr));