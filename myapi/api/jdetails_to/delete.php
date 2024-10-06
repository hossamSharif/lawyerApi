<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: DELETE');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/jdetails_to.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $invoice = new jdetails_to($db);

  // Get raw posted data
 // $data = json_decode(file_get_contents("php://input"));
  // Set ID to update
  $invoice->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Delete post
  if($invoice->delete()) {
    echo json_encode(
      array('message' => 'Post Deleted')
    );
  } else {
    echo json_encode(
      array('message' => 'Post Not Deleted')
    );
  }
