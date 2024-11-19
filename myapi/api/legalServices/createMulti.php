<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/legal_services.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate legal services object
  $legal_services = new LegalServices($db);

  // Get raw posted data
  $data2 = json_decode(file_get_contents("php://input"), true);

  $res = array();
  foreach($data2 as $col){
      $legal_services->contract_id = $col['contract_id'];
      $legal_services->service_type = $col['service_type'];
      $legal_services->service_title = $col['service_title'];
      $legal_services->service_id = $col['service_id'];
       
      array_push($res, array(
        "contract_id" => $col['contract_id'],
        "service_type" => $col['service_type'],
        "service_title" => $col['service_title'],
        "service_id" => $col['service_id']
      ));
  }

  $max = sizeof($res);
  $values = '';
  for($i = 0; $i < $max; $i++){
    if ($i == 0) { 
      $values = '('.$res[$i]['contract_id'].',"'.$res[$i]['service_type'].'","'.$res[$i]['service_title'].'",'.$res[$i]['service_id'].')';
    } elseif ($i == $max-1) { 
      $values = ''.$values.',('.$res[$i]['contract_id'].',"'.$res[$i]['service_type'].'","'.$res[$i]['service_title'].'",'.$res[$i]['service_id'].')';
    } elseif ($i > 0 && $i < $max-1) { 
      $values = ''.$values.',('.$res[$i]['contract_id'].',"'.$res[$i]['service_type'].'","'.$res[$i]['service_title'].'",'.$res[$i]['service_id'].')';
    }   
  }

  if($legal_services->createMulti($values)) {
    echo json_encode(
      array('message' => 'Legal Services Created')
    );
  } else {
    echo json_encode(
      array('message' => 'Legal Services Not Created')
    );
  }
?>
