<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/users.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $users = new Users($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));
   
  $users->user_name = $data->user_name; 
  $users->password = $data->password;
  $users->full_name = $data->full_name;
  $users->level = $data->level;
  $users->phone = $data->phone;
  $users->email = $data->email;
  $users->job_title = $data->job_title;
 
 
  // Create post
  if($users->create()) {
    echo json_encode(
      array('message' => 'Post Created')
    );
  } else {
    echo json_encode(
      array('message' => 'Post Not Created')
    );
  }

