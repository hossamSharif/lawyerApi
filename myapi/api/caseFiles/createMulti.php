<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/caseFiles.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate casefiles object
  $casefiles = new CaseFiles($db);

  // Get raw posted data
  $data2 = json_decode(file_get_contents("php://input"), true);

  $res = array();

  foreach($data2 as $col){
    $casefiles->case_id = $col['case_id'];
    $casefiles->user_id = $col['user_id'];
    $casefiles->file_name = $col['file_name'];
    $casefiles->file_size = $col['file_size'];
    $casefiles->file_url = $col['file_url'];
    $casefiles->file_notes = $col['file_notes'];
    $casefiles->uploaded_at = $col['uploaded_at'];
    $casefiles->category = $col['category'];

    array_push($res, array(
      "case_id" => $col['case_id'],
      "user_id" => $col['user_id'],
      "file_name" => $col['file_name'],
      "file_size" => $col['file_size'],
      "file_url" => $col['file_url'],
      "file_notes" => $col['file_notes'],
      "uploaded_at" => $col['uploaded_at'],
      "category" => $col['category']
    ));
  }

  $max = sizeof($res);
  $values = '';
  for($i = 0; $i < $max; $i++){
    if ($i == 0) { 
      $values = '('.$res[$i]['case_id'].','.$res[$i]['user_id'].',"'.$res[$i]['file_name'].'",'.$res[$i]['file_size'].',"'.$res[$i]['file_url'].'","'.$res[$i]['file_notes'].'","'.$res[$i]['uploaded_at'].'","'.$res[$i]['category'].'")';
    } elseif ($i == $max-1) { 
      $values = ''.$values.',('.$res[$i]['case_id'].','.$res[$i]['user_id'].',"'.$res[$i]['file_name'].'",'.$res[$i]['file_size'].',"'.$res[$i]['file_url'].'","'.$res[$i]['file_notes'].'","'.$res[$i]['uploaded_at'].'","'.$res[$i]['category'].'")';
    } elseif ($i > 0 && $i < $max-1){ 
      $values = ''.$values.',('.$res[$i]['case_id'].','.$res[$i]['user_id'].',"'.$res[$i]['file_name'].'",'.$res[$i]['file_size'].',"'.$res[$i]['file_url'].'","'.$res[$i]['file_notes'].'","'.$res[$i]['uploaded_at'].'","'.$res[$i]['category'].'")';
    }   
  }

  if($casefiles->createMulti($values)) {
    echo json_encode(
      array('message' => 'Post Created')
    );
  } else {
    echo json_encode(
      array('message' => 'Post Not Created')
    );
  }
?>
