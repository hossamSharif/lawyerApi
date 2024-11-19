<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/contracts.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate contract object
  $contract = new Contracts($db);

  // Contract read query
  $result = $contract->read();
  
  // Get row count
  $num = $result->rowCount();

  // Check if any contracts
  if($num > 0) {
        // Contract array
        $contract_arr = array();
        $contract_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
          extract($row);
        
          $contract_item = array(
            'id' => $row['id'],
            'contract_title' => $row['contract_title'],
            'client_id' => $row['client_id'],
            'client_name' => $row['client_name'],
            'contract_date' => $row['contract_date'],
            'end_date' => $row['end_date'],
            'draft' => $row['draft'],
            'amount' => $row['amount'],
            'due_date' => $row['due_date'],
            'legal_services' => json_decode('[' . $row['legal_services'] . ']'),
            'payments' => json_decode('[' . $row['payments'] . ']')
          );

          // Push to "data"
          array_push($contract_arr['data'], $contract_item);
        }

        // Turn to JSON & output
        echo json_encode($contract_arr);

  } else {
        // No contracts found
        echo json_encode(
          array('message' => 'No contracts Found')
        );
  }
?>
