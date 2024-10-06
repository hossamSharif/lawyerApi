<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Services.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $services = new Services($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input")) ;
  
     
  $services->ptinvo_id = $data->ptinvo_id;
  $services->serv_desc = $data->serv_desc;
  $services->serv_price = $data->serv_price;
  $services->serv_type = $data->serv_type;
  $services->list_ordering = $data->list_ordering;
  $services->status = $data->status;
  $services->serv_id = $data->serv_id;
 
  // Create post
  if($services->create()) {
    echo json_encode(
      array('message' => 'Post Created')
    );
  } else {
    echo json_encode(
      array('message' => 'Post Not Created')
    );
  }

