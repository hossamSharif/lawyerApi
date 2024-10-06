<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: DELETE');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/firstq.php';
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $category = new Firstq($db);

  // Get raw posted data
 
  $category->store_id = isset($_GET['store_id']) ? $_GET['store_id'] : die();
  $category->fq_year = isset($_GET['fq_year']) ? $_GET['fq_year'] : die();
  // Set ID to UPDATE
   

  // Delete post
  if($category->deleteByStore()) {
    echo json_encode(
      array('message' => 'Post deleted')
    );
  } else {
    echo json_encode(
      array('message' => 'Post not deleted')
    );
  }
