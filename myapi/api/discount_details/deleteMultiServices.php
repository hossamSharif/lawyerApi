<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: DELETE');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/discount_details.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $services = new Discount_details($db);

  // Get raw posted data
 // $data = json_decode(file_get_contents("php://input"));

  // Set ID to update
  $services->discount_id = isset($_GET['discount_id']) ? $_GET['discount_id'] : die();
  
  // Delete post
  if($services->deleteMultiServices()) {
    echo json_encode(
      array('message' => 'Post Deleted')
    );
  } else {
    echo json_encode(
      array('message' => 'Post Not Deleted')
    );
  }
