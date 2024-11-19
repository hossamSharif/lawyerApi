<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/courts.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate court object
  $court = new Courts($db);

  // Court read query
  $result = $court->read();
  
  // Get row count
  $num = $result->rowCount();

  // Check if any courts
  if($num > 0) {
        // Court array
        $court_arr = array();
        $court_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
          extract($row);
        
          $court_item = array(
            'id' => $row['id'],
            'court_name' => $row['court_name'],
            'status' => $row['status'] 
          );

          // Push to "data"
          array_push($court_arr['data'], $court_item);
        }

        // Turn to JSON & output
        echo json_encode($court_arr);

  } else {
        // No Courts
        echo json_encode(
          array('message' => 'No courts Found')
        );
  }
?>
