<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: DELETE');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/items.php';
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $category = new Items($db);

  // Get raw posted data
   
  // Set ID to UPDATE
   

  // Delete post
  if($category->truncateItems()) {
    echo json_encode(
      array('message' => 'Post deleted')
    );
  } else {
    echo json_encode(
      array('message' => 'Post not deleted')
    );
  }
