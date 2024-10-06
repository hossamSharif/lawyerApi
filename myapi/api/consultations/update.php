<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/consultations.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate consultation object
  $consultation = new Consultation($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  // Set ID to UPDATE
  $consultation->id = $data->id;

  // Set consultation properties
  $consultation->title = $data->title;
  $consultation->client_id = $data->client_id;
  $consultation->lawyer_id = $data->lawyer_id;
  $consultation->case_id = $data->case_id;
  $consultation->consultation_date = $data->consultation_date;
  $consultation->duration = $data->duration;
  $consultation->consultation_notes = $data->consultation_notes;
  $consultation->consultation_fee = $data->consultation_fee;
  $consultation->consultation_type = $data->consultation_type;
  $consultation->status = $data->status;

  // Update consultation
  if($consultation->update()) {
    echo json_encode(
      array('message' => 'Consultation Updated')
    );
  } else {
    echo json_encode(
      array('message' => 'Consultation Not Updated')
    );
  }
?>
