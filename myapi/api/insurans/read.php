<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Insurans.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $insurans = new Insurans($db);

  // Blog post query
  $result = $insurans->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any posts
  if($num > 0) {
    // Post array
    $insuranss_arr = array();
    // $insuranss_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      
      $insurans_item = array(
        'insur_id' => $insur_id,
        'insur_desc' => $insur_desc, 
        'insur_price' => $insur_price 
      );

      // Push to "data"
      array_push($insuranss_arr, $insurans_item);
      // array_push($insuranss_arr['data'], $insurans_item);
    }

    // Turn to JSON & output
    echo json_encode($insuranss_arr);

  } else {
    // No Posts
    echo json_encode(
      array('message' => 'No Posts Found')
    );
  }
