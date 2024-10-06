<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: DELETE');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/caseFiles.php';
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $case = new CaseFiles($db);

  $data = json_decode(file_get_contents("php://input"));
  $case->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Delete post
  if($case->delete()) {
    echo json_encode(
      array('message' => 'File deleted')
    );
  } else {
    echo json_encode(
      array('message' => 'File not deleted')
    );
  }
