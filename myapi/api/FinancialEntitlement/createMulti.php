<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/financialEntitlements.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate financial entitlement object
  $financial_entitlement = new Financial_entitlement($db);

  // Get raw posted data
  $data2 = json_decode(file_get_contents("php://input"), true);

  $res = array();
  foreach($data2 as $col){
      $financial_entitlement->case_id = $col['case_id'];
      $financial_entitlement->client_id = $col['client_id'];
      $financial_entitlement->amount = $col['amount'];
      $financial_entitlement->status = $col['status'];
      $financial_entitlement->description = $col['description'];
       
      array_push($res, array( 
        "case_id" => $col['case_id'],
        "client_id" => $col['client_id'],
        "amount" => $col['amount'],
        "status" => $col['status'],
        "description" => $col['description']
      ));
  }

  $max = sizeof($res);
  $values = '';
  for($i = 0; $i < $max; $i++){
    if ($i == 0) { 
      $values = '('.$res[$i]['case_id'].','.$res[$i]['client_id'].',"'.$res[$i]['amount'].'","'.$res[$i]['status'].'","'.$res[$i]['description'].'")';
    } elseif ($i == $max-1) { 
      $values = ''.$values.',('.$res[$i]['case_id'].','.$res[$i]['client_id'].',"'.$res[$i]['amount'].'","'.$res[$i]['status'].'","'.$res[$i]['description'].'")';
    } elseif ($i > 0 && $i < $max-1) { 
      $values = ''.$values.',('.$res[$i]['case_id'].','.$res[$i]['client_id'].',"'.$res[$i]['amount'].'","'.$res[$i]['status'].'","'.$res[$i]['description'].'")';
    }   
  }

  if($financial_entitlement->createMulti($values)) {
    echo json_encode(
      array('message' => 'Financial Entitlements Created')
    );
  } else {
    echo json_encode(
      array('message' => 'Financial Entitlements Not Created')
    );
  }
?>
