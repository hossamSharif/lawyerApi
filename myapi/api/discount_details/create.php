<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/offer.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $offer = new Offer($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input")) ;
  
      
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
  
 
  // Create post
  if($offer->create()) {
    echo json_encode(
      array('message' => 'Post Created')
    );
  } else {
    echo json_encode(
      array('message' => 'Post Not Created')
    );
  }

