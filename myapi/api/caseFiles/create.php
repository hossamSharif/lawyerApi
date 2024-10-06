<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/caseFiles.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate case file object
  $caseFile = new CaseFiles($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  // Set case file properties
  $caseFile->case_id = $data->case_id;
  $caseFile->user_id = $data->user_id;
  $caseFile->file_name = $data->file_name;
  $caseFile->file_size = $data->file_size;
  $caseFile->file_url = $data->file_url;
  $caseFile->file_notes = $data->file_notes;
  $caseFile->uploaded_at = $data->uploaded_at;

  // Create case file
  if($caseFile->create()) {
    $last_id = $db->lastInsertId();
    echo json_encode(
      array('message' => $last_id)
    );
  } else {
    echo json_encode(
      array('message' => 'Case File Not Created')
    );
  }
?>
