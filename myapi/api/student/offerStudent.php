<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/student.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $student = new Student($db);

  // Get ID 
   $student->offerId = isset($_GET['offerId']) ? $_GET['offerId'] : die();
  // Get post
  $result = $student->offerStudent();
  
  $num = $result->rowCount();
  // Create array
  if($num > 0) {
    // Post array
    $students_arr = array();
    // $students_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      
      $student_item = array(
        'id' => $id,
        'name' => $name,
        // 'body' => html_entity_decode($body),
        'email' => $email,
        'phone' => $phone,
        'offerId' => $offerId
         
         
      );

      // Push to "data"
      array_push($students_arr, $student_item);
      // array_push($students_arr['data'], $student_item);
    }

    // Turn to JSON & output
    echo json_encode($students_arr);

  } else {
    // No Posts
    echo json_encode(
      array('message' => 'No Posts Found')
    );
  }
