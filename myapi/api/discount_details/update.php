<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/offer.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $offer = new Offer($db);
  

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  // Set ID to update
  $offer->id = $data->id;

  $offer->title = $data->title;
  $offer->dailyTime = $data->dailyTime;
  $offer->hourCount = $data->hourCount;
  $offer->price = $data->price;
  $offer->price_note = $data->price_note;
  $offer->start = $data->start;
  $offer->sectionId = $data->sectionId;
  $offer->shortDescr = $data->shortDescr;
  $offer->teacher = $data->teacher;
  $offer->imgUrl = $data->imgUrl;
   $offer->ordering = $data->ordering;
    $offer->discountLbl = $data->discountLbl;
     $offer->newLbl = $data->newLbl;
      $offer->status = $data->status;
      $offer->yearId = $data->yearId;
      $offer->tax = $data->tax;

   

  // Update post
  if($offer->update()) {
    echo json_encode(
      array('message' => 'Post Updated')
    );
  } else {
    echo json_encode(
      array('message' => 'Post Not Updated')
    );
  }

