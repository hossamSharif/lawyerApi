<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/sessions.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate session object
  $session = new Sessions($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  // Set session properties
  $session->lawyer_id = $data->lawyer_id;
  $session->case_id = $data->case_id;
  $session->cust_id = $data->cust_id;
  $session->court_id = $data->court_id;
  $session->session_date = $data->session_date;
  $session->session_time = $data->session_time;
  $session->session_type = $data->session_type;
  $session->session_title = $data->session_title;
  $session->opponent_name = $data->opponent_name;
  $session->opponent_representative = $data->opponent_representative;
  $session->session_status = $data->session_status;
  $session->session_result = $data->session_result;

  // Create session
  if($session->create()) {
    $last_id = $db->lastInsertId();
    echo json_encode(
      array('message' => $last_id)
    );
  } else {
    echo json_encode(
      array('message' => 'Session Not Created')
    );
  }
?>
