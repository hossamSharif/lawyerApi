<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Insurans.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $insurans = new Insurans($db);

  // Get ID
  $insurans->insur_id = isset($_GET['insur_id']) ? $_GET['insur_id'] : die();

  // Get post
  $insurans->read_single();

  // Create array
  $insurans_arr = array(
    'insur_id' => $insurans->insur_id,
    'insur_desc' => $insurans->insur_desc, 
    'insur_price' => $insurans->insur_price
     
  );

  // Make JSON
  print_r(json_encode($insurans_arr));