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

  // Get ID
  $caseFile->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Get case file
  $result = $caseFile->getCaseFileById();
  $num = $result->rowCount();

  // Create array
  $caseFile_arr = array();
  $caseFile_arr['data'] = array();

  if($num > 0) {
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
        'user_name' => $row['user_name']
      );    
      array_push($caseFile_arr['data'], $caseFile_item);
    }
    // Make JSON
    echo json_encode($caseFile_arr);
  } else { 
    // No Case Files Found
    echo json_encode(
      array('message' => 'No Case Files Found')
    );  
  }
?>
