<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/teacher.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $teacher = new Teacher($db);

  // Blog post query
  $result = $teacher->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any posts
  if($num > 0) {
    // Post array
    $teachers_arr = array();
    // $teachers_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      
      $teacher_item = array(
        'id' => $id,
        'shortDescr' => $shortDescr,
        // 'body' => html_entity_decode($body),
        'imgUrl' => $imgUrl,
        'name' => $name
         
      );

      // Push to "data"
      array_push($teachers_arr, $teacher_item);
      // array_push($teachers_arr['data'], $teacher_item);
    }


    // Turn to JSON & output
    echo json_encode($teachers_arr);

  } else {
    // No Posts
    echo json_encode(
      array('message' => 'No Posts Found')
    );
  }
