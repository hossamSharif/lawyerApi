<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/consultations.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate consultation object
  $consultation = new Consultation($db);

  // Consultation read query
  $result = $consultation->read();
  
  // Get row count
  $num = $result->rowCount();

  // Check if any consultations
  if($num > 0) {
        // Consultation array
        $consultation_arr = array();
        $consultation_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
          extract($row);
        
          $consultation_item = array(
            'id' => $row['id'],
            'title' => $row['title'],
            'client_id' => $row['client_id'],
            'lawyer_id' => $row['lawyer_id'],
            'case_id' => $row['case_id'],
            'consultation_date' => $row['consultation_date'],
            'duration' => $row['duration'],
            'consultation_notes' => $row['consultation_notes'],
            'consultation_fee' => $row['consultation_fee'],
            'consultation_type' => $row['consultation_type'],
            'status' => $row['status'],
            'lawyer_name' => $row['lawyer_name'],
            'customer' => $row['customer']
          );

          // Push to "data"
          array_push($consultation_arr['data'], $consultation_item);
        }

        // Turn to JSON & output
        echo json_encode($consultation_arr);

  } else {
        // No Consultations
        echo json_encode(
          array('message' => 'No Consultations Found')
        );
  }
?>