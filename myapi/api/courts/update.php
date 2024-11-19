<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/courts.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate court object
  $court = new Courts($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  // Set ID to UPDATE
  $court->id = $data->id;

  // Set court properties
  $court->court_name = $data->court_name;
  $court->status = $data->status;

  // Update court
  if($court->update()) {
    echo json_encode(
      array('message' => 'Court Updated')
    );
  } else {
    echo json_encode(
      array('message' => 'Court Not Updated')
    );
  }
?>
