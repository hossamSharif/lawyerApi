<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/caseFiles.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate consultation object
  $caseFile = new CaseFiles($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  $caseFile->id = $data->id;
  // Set case file properties
  $caseFile->case_id = $data->case_id;
  $caseFile->user_id = $data->user_id;
  $caseFile->file_name = $data->file_name;
  $caseFile->file_size = $data->file_size;
  $caseFile->file_url = $data->file_url;
  $caseFile->file_notes = $data->file_notes;
  $caseFile->uploaded_at = $data->uploaded_at;

  // Update consultation
  if($caseFile->update()) {
    echo json_encode(
      array('message' => 'Consultation Updated')
    );
  } else {
    echo json_encode(
      array('message' => 'Consultation Not Updated')
    );
  }
?>
