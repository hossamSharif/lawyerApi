<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/case_status.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate case_status object
  $case_status = new caseStatus($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  // Set case_status properties
  $case_status->status_name = $data->status_name;
  $case_status->status = $data->status;
  $case_status->status_color = $data->status_color;

  // Create case_status
  if($case_status->create()) {
    $last_id = $db->lastInsertId();
    echo json_encode(
      array('message' => $last_id)
    );
  } else {
    echo json_encode(
      array('message' => 'Case Status Not Created')
    );
  }
?>
