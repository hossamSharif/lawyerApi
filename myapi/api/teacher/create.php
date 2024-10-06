<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/teacher.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $teacher = new Teacher($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));
    
  $teacher->shortDescr = $data->shortDescr;
  $teacher->name = $data->name; 
  $teacher->imgUrl = $data->imgUrl; 

  // Create post
  if($teacher->create()) {
    echo json_encode(
      array('message' => 'Post Created')
    );
  } else {
    echo json_encode(
      array('message' => 'Post Not Created')
    );
  }

