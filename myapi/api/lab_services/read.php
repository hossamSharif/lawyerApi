<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Lab_services.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $lab_services = new Lab_services($db);

  // Blog post query
  $result = $lab_services->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any posts
  if($num > 0) {
    // Post array
    $lab_servicess_arr = array();
    // $lab_servicess_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      
      $lab_services_item = array(
        'labserv_id' => $labserv_id,
        'labserv_desc' => $labserv_desc, 
        'labserv_price' => $labserv_price 
      );

      // Push to "data"
      array_push($lab_servicess_arr, $lab_services_item);
      // array_push($lab_servicess_arr['data'], $lab_services_item);
    }

    // Turn to JSON & output
    echo json_encode($lab_servicess_arr);

  } else {
    // No Posts
    echo json_encode(
      array('message' => 'No Posts Found')
    );
  }
