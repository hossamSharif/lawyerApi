<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/firstq.php';
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $category2 = new Firstq($db);

  // Get raw posted data
  $data2 = json_decode(file_get_contents("php://input"));
 
  $category2->item_id = $data2->item_id;
  $category2->quantity = $data2->quantity;
  $category2->pay_price = $data2->pay_price;
  $category2->perch_price = $data2->perch_price;
  $category2->fq_year = $data2->fq_year; 
  $category2->store_id = $data2->store_id;


  // Create Category
  if($category2->create()) {
    $last_id = $db->lastInsertId();
    echo json_encode(
      array('message' => $last_id)
    );
  } else {
    echo json_encode(
      array('message' => 'Post Not Created')
    );
  }
