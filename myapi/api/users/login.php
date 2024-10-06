<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/users.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $users = new Users($db);

  // Get ID
  $users->user_name = isset($_GET['user_name']) ? $_GET['user_name'] : die();
  $users->password = isset($_GET['password']) ? $_GET['password'] : die();

  // Get post
  $users->login();
 
  // Create array
  $users_arr = array(
    'id' => $users->id,
    'user_name' => $users->user_name, 
    'password' => $users->password,
    'full_name' => $users->full_name,
    'level' => $users->level ,
    'phone' => $users->phone, 
    'email' => $users->email ,
    'job_title' => $users->job_title 
     
  );

  // Make JSON
  print_r(json_encode($users_arr));