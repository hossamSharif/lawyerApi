<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Doctors.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $doctor = new Doctors($db);

  // Get ID
  $doctor->dr_id = isset($_GET['dr_id']) ? $_GET['dr_id'] : die();

  // Get post
  $doctor->read_single();

  // Create array
  $doctor_arr = array(
    'dr_id' => $doctor->dr_id,
    'dr_name' => $doctor->dr_name,
    // 'body' => html_entity_decode($body),
    'dr_phone' => $doctor->dr_phone,
    'dr_spec' => $doctor->dr_spec,
    'dr_type' => $doctor->dr_type,
    'teckit_price' => $doctor->teckit_price 
  );

  // Make JSON
  print_r(json_encode($doctor_arr));