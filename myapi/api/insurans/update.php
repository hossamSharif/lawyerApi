<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Insurans.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $insurans = new Insurans($db);
  

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  // Set ID to update
  $insurans->insur_id = $data->insur_id;

  

  $insurans->insur_desc = $data->insur_desc; 
  $insurans->insur_price = $data->insur_price;

  // Update post
  if($insurans->update()) {
    echo json_encode(
      array('message' => 'Post Updated')
    );
  } else {
    echo json_encode(
      array('message' => 'Post Not Updated')
    );
  }

