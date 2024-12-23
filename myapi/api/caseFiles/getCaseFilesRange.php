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

  // Get range and case_id
  $caseFile->startrange = isset($_GET['startrange']) ? $_GET['startrange'] : die();
  $caseFile->endrange = isset($_GET['endrange']) ? $_GET['endrange'] : die();
  $caseFile->case_id = isset($_GET['case_id']) ? $_GET['case_id'] : die();
  $caseFile->category = isset($_GET['category']) ? $_GET['category'] : die();

  // Get case files
  $result = $caseFile->getCaseFilesInRange();
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
        'user_name' => $row['user_name'],
        'category' => $row['category']
      );                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
      // Push to "data"
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
