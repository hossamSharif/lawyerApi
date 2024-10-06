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

  // Get ID
  $offerDetail->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Get post
  $offerDetail->read_single();

  // Create array
  $offerDetail_arr = array(
    'id' => $id,
    'descrb' => $descrb,
    // 'body' => html_entity_decode($body),
    'offerId' => $offerId
  );

  // Make JSON
  print_r(json_encode($offerDetail_arr));