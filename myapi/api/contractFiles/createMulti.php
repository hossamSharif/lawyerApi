<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/contract_files.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate contract files object
  $contract_files = new ContractFiles($db);

  // Get raw posted data
  $data2 = json_decode(file_get_contents("php://input"), true);

  $res = array();
  foreach($data2 as $col){
      $contract_files->contract_id = $col['contract_id'];
      $contract_files->user_id = $col['user_id'];
      $contract_files->file_name = $col['file_name'];
      $contract_files->file_size = $col['file_size'];
      $contract_files->file_url = $col['file_url'];
      $contract_files->file_notes = $col['file_notes'];
       
      array_push($res, array(
        "contract_id" => $col['contract_id'],
        "user_id" => $col['user_id'],
        "file_name" => $col['file_name'],
        "file_size" => $col['file_size'],
        "file_url" => $col['file_url'],
        "file_notes" => $col['file_notes']
      ));
  }

  $max = sizeof($res);
  $values = '';
  for($i = 0; $i < $max; $i++){
    if ($i == 0) { 
      $values = '('.$res[$i]['contract_id'].','.$res[$i]['user_id'].',"'.$res[$i]['file_name'].'",'.$res[$i]['file_size'].',"'.$res[$i]['file_url'].'","'.$res[$i]['file_notes'].'")';
    } elseif ($i == $max-1) { 
      $values = ''.$values.',('.$res[$i]['contract_id'].','.$res[$i]['user_id'].',"'.$res[$i]['file_name'].'",'.$res[$i]['file_size'].',"'.$res[$i]['file_url'].'","'.$res[$i]['file_notes'].'")';
    } elseif ($i > 0 && $i < $max-1) { 
      $values = ''.$values.',('.$res[$i]['contract_id'].','.$res[$i]['user_id'].',"'.$res[$i]['file_name'].'",'.$res[$i]['file_size'].',"'.$res[$i]['file_url'].'","'.$res[$i]['file_notes'].'")';
    }   
  }

  if($contract_files->createMulti($values)) {
    echo json_encode(
      array('message' => 'Contract Files Created')
    );
  } else {
    echo json_encode(
      array('message' => 'Contract Files Not Created')
    );
  }
?>
