<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/xray.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $xray = new Xray($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));
   
  $xray->xray_desc = $data->xray_desc;
  $xray->xray_type = $data->xray_type;
  $xray->xray_price = $data->xray_price;
 
 
  // Create post
  if($xray->create()) {
    echo json_encode(
      array('message' => 'Post Created')
    );
  } else {
    echo json_encode(
      array('message' => 'Post Not Created')
    );
  }

