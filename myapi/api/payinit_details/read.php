<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/offer.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $offer = new Offer($db);

  // Blog post query
  $result = $offer->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any posts
  if($num > 0) {
    // Post array
    $offers_arr = array();
    // $offers_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
     
      $offer_item = array(
        'id' => $id,
        'title' => $title, 
        'dailyTime' => $dailyTime ,
        'hourCount' => $hourCount ,
        'price' => $price ,
        'price_note' => $price_note ,
        'start' => $start ,
        'sectionId' => $sectionId, 
        'shortDescr' => $shortDescr ,
        'teacher' => $teacher, 
        'imgUrl' => $imgUrl ,
        'ordering' => $ordering,
        'discountLbl' => $discountLbl,
        'newLbl' => $newLbl,
        'status' => $status
      );

      // Push to "data"
      array_push($offers_arr, $offer_item);
      // array_push($offers_arr['data'], $offer_item);
    }

    // Turn to JSON & output
    echo json_encode($offers_arr);

  } else {
    // No Posts
    echo json_encode(
      array('message' => 'No Posts Found')
    );
  }
