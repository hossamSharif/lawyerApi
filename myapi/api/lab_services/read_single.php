<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Lab_services.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $lab_services = new Nursing($db);

  // Get ID
  $lab_services->labserv_id = isset($_GET['labserv_id']) ? $_GET['labserv_id'] : die();

  // Get post
  $lab_services->read_single();

  // Create array
  $lab_services_arr = array(
    'labserv_id' => $lab_services->labserv_id,
    'labserv_desc' => $lab_services->labserv_desc, 
    'labserv_price' => $lab_services->labserv_price
     
  );

  // Make JSON
  print_r(json_encode($lab_services_arr));