<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/contracts.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate contract object
  $contract = new Contracts($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  // Set ID to UPDATE
  $contract->id = $data->id;

  // Set contract properties
  $contract->contract_title = $data->contract_title;
  $contract->client_id = $data->client_id;
  $contract->contract_date = $data->contract_date;
  $contract->end_date = $data->end_date;
  $contract->draft = $data->draft;
  $contract->amount = $data->amount;
  $contract->due_date = $data->due_date;

  // Update contract
  if($contract->update()) {
    echo json_encode(
      array('message' => 'Contract Updated')
    );
  } else {
    echo json_encode(
      array('message' => 'Contract Not Updated')
    );
  }
?>
