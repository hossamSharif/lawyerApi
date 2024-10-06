<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/offerDetail.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $offerDetail = new Offerdetail($db);

  // Blog post query
  $result = $offerDetail->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any posts
  if($num > 0) {
    // Post array
    $offerDetails_arr = array();
    // $offerDetails_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      
      $offerDetail_item = array(
        'id' => $id,
        'descrb' => $descrb,
        // 'body' => html_entity_decode($body),
        'offerId' => $offerId
         
         
      );

      // Push to "data"
      array_push($offerDetails_arr, $offerDetail_item);
      // array_push($offerDetails_arr['data'], $offerDetail_item);
    }

    // Turn to JSON & output
    echo json_encode($offerDetails_arr);

  } else {
    // No Posts
    echo json_encode(
      array('message' => 'No Posts Found')
    );
  }
