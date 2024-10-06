<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Doctors.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $doctor = new Doctors($db);

  // Blog post query
  $result = $doctor->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any posts
  if($num > 0) {
    // Post array
    $doctors_arr = array();
    // $doctors_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      
      $doctor_item = array(
        'dr_id' => $dr_id,
        'dr_name' => $dr_name,
        // 'body' => html_entity_decode($body),
        'dr_phone' => $dr_phone,
        'dr_spec' => $dr_spec,
        'dr_type' => $dr_type,
        'teckit_price' => $teckit_price
      );

      // Push to "data"
      array_push($doctors_arr, $doctor_item);
      // array_push($doctors_arr['data'], $doctor_item);
    }

    // Turn to JSON & output
    echo json_encode($doctors_arr);

  } else {
    // No Posts
    echo json_encode(
      array('message' => 'No Posts Found')
    );
  }
