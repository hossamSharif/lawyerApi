<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Xray.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $xray = new Xray($db);

  // Blog post query
  $result = $xray->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any posts
  if($num > 0) {
    // Post array
    $xrays_arr = array();
    // $xrays_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      
      $xray_item = array(
        'xray_id' => $xray_id,
        'xray_desc' => $xray_desc,
        // 'body' => html_entity_decode($body),
        'xray_type' => $xray_type,
        'xray_price' => $xray_price
         
      );

      // Push to "data"
      array_push($xrays_arr, $xray_item);
      // array_push($xrays_arr['data'], $xray_item);
    }

    // Turn to JSON & output
    echo json_encode($xrays_arr);

  } else {
    // No Posts
    echo json_encode(
      array('message' => 'No Posts Found')
    );
  }
