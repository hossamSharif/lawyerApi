<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/cases.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate case object
  $case = new Cases($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  // Set case properties
  $case->case_title = $data->case_title;
  $case->client_id = $data->client_id;
  $case->case_type = $data->case_type;
  $case->client_role = $data->client_role;
  $case->service_classification = $data->service_classification;
  $case->branch = $data->branch;
  $case->court_name = $data->court_name;
  $case->opponent_name = $data->opponent_name;
  $case->opponent_id = $data->opponent_id;
  $case->opponent_representative = $data->opponent_representative;
  $case->case_open_date = $data->case_open_date;
  $case->deadline = $data->deadline;
  $case->billing_type = $data->billing_type;
  $case->claim_type = $data->claim_type;
  $case->work_hour_value = $data->work_hour_value;
  $case->estimated_work_hours = $data->estimated_work_hours;
  $case->case_status = $data->case_status;
  $case->constraintId_najz = $data->constraintId_najz;
  $case->archive_id_najz = $data->archive_id_najz;
  $case->caseId_najz = $data->caseId_najz;
  $case->case_classification_najz = $data->case_classification_najz;
  $case->case_open_date_najz = $data->case_open_date_najz;
  $case->Plaintiff_Requests = $data->Plaintiff_Requests;
  $case->case_status_najz = $data->case_status_najz;
  $case->case_subject = $data->case_subject;

  // Create case
  if($case->create()) {
    $last_id = $db->lastInsertId();
    echo json_encode(
      array('message' => $last_id)
    );
  } else {
    echo json_encode(
      array('message' => 'Case Not Created')
    );
  }
?>
