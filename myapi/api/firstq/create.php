<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/items.php';
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $category = new Items($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  $category->item_name = $data->item_name;
  $category->item_unit = $data->item_unit;
  $category->pay_price = $data->pay_price;
  $category->perch_price = $data->perch_price;
  $category->item_desc = $data->item_desc; 
  $category->item_parcode = $data->item_parcode;


  // Create Category
  if($category->create()) {
    $last_id = $db->lastInsertId();
    echo json_encode(
      array('message' => $last_id)
    );
  } else {
    echo json_encode(
      array('message' => 'Post Not Created')
    );
  }
