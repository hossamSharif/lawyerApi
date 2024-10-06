<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Nursing.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $nursing = new Nursing($db);

  // Blog post query
  $result = $nursing->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any posts
  if($num > 0) {
    // Post array
    $nursings_arr = array();
    // $nursings_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      
      $nursing_item = array(
        'nurs_id' => $nurs_id,
        'nurs_desc' => $nurs_desc, 
        'nurs_price' => $nurs_price 
      );

      // Push to "data"
      array_push($nursings_arr, $nursing_item);
      // array_push($nursings_arr['data'], $nursing_item);
    }

    // Turn to JSON & output
    echo json_encode($nursings_arr);

  } else {
    // No Posts
    echo json_encode(
      array('message' => 'No Posts Found')
    );
  }
