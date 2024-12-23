<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/caseFiles.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate case file object
  $caseFile = new CaseFile($db);
  $caseFile->category = isset($_GET['category']) ? $_GET['category'] : die();
  // Case file read query
  $result = $caseFile->read();
  
  // Get row count
  $num = $result->rowCount();

  // Check if any case files
  if($num > 0) {
        // Case file array
        $caseFile_arr = array();
        $caseFile_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
          extract($row);
        
          $caseFile_item = array(
            'id' => $row['id'],
            'case_id' => $row['case_id'],
            'user_id' => $row['user_id'],
            'file_name' => $row['file_name'],
            'file_size' => $row['file_size'],
            'file_url' => $row['file_url'],
            'file_notes' => $row['file_notes'],
            'uploaded_at' => $row['uploaded_at'],
            'user_name' => $row['user_name'],
            'category' => $row['category']
          );

          // Push to "data"
          array_push($caseFile_arr['data'], $caseFile_item);
        }

        // Turn to JSON & output
        echo json_encode($caseFile_arr);

  } else {
        // No Case Files
        echo json_encode(
          array('message' => 'No Case Files Found')
        );
  }
?>
