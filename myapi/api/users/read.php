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

  // Blog post query
  $result = $users->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any posts
  if($num > 0) {
    // Post array
    //$userss_arr = array();
      $userss_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      
      $users_item = array(
        'id' => $id,
        'user_name' => $user_name, 
        'password' => $password,
        'full_name' => $full_name,
        'level' => $level ,
            'phone' => $phone, 
            'email' => $email ,
            'job_title' => $job_title 
      );

      // Push to "data"
      array_push($userss_arr['data'], $users_item);
      // array_push($userss_arr['data'], $users_item);
    }

    // Turn to JSON & output
    echo json_encode($userss_arr);

  } else {
    // No Posts
    echo json_encode(
      array('message' => 'No Posts Found')
    );
  }
