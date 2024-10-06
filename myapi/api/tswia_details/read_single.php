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

  // Get ID
  $offer->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Get post
  $offer->read_single();

  // Create array
  $offer_arr = array(
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
        'imgUrl' => $imgUrl,
        'ordering' => $ordering,
        'discountLbl' => $discountLbl,
        'newLbl' => $newLbl,
        'status' => $status
 
  );

  // Make JSON
  print_r(json_encode($offer_arr));