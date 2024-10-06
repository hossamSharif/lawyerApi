<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Doctors.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $doctor = new Doctors($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));
   
  $doctor->dr_name = $data->dr_name;
  $doctor->dr_phone = $data->dr_phone;
  $doctor->dr_spec = $data->dr_spec;
  $doctor->dr_type = $data->dr_type;
  $doctor->teckit_price = $data->teckit_price;

  // Create post
  if($doctor->create()) {
    echo json_encode(
      array('message' => 'Post Created')
    );
  } else {
    echo json_encode(
      array('message' => 'Post Not Created')
    );
  }

