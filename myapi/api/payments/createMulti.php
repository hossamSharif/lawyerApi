<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/payments.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate payments object
  $payments = new Payments($db);

  // Get raw posted data
  $data2 = json_decode(file_get_contents("php://input"), true);

  $res = array();
  foreach($data2 as $col){
      $payments->contract_id = $col['contract_id'];
      $payments->amount = $col['amount'];
      $payments->payment_date = $col['payment_date'];
      $payments->due_date = $col['due_date'];
       
      array_push($res, array(
        "contract_id" => $col['contract_id'],
        "amount" => $col['amount'],
        "payment_date" => $col['payment_date'],
        "due_date" => $col['due_date']
      ));
  }

  $max = sizeof($res);
  $values = '';
  for($i = 0; $i < $max; $i++){
    if ($i == 0) { 
      $values = '('.$res[$i]['contract_id'].','.$res[$i]['amount'].',"'.$res[$i]['payment_date'].'","'.$res[$i]['due_date'].'")';
    } elseif ($i == $max-1) { 
      $values = ''.$values.',('.$res[$i]['contract_id'].','.$res[$i]['amount'].',"'.$res[$i]['payment_date'].'","'.$res[$i]['due_date'].'")';
    } elseif ($i > 0 && $i < $max-1) { 
      $values = ''.$values.',('.$res[$i]['contract_id'].','.$res[$i]['amount'].',"'.$res[$i]['payment_date'].'","'.$res[$i]['due_date'].'")';
    }   
  }

  if($payments->createMulti($values)) {
    echo json_encode(
      array('message' => 'Payments Created')
    );
  } else {
    echo json_encode(
      array('message' => 'Payments Not Created')
    );
  }
?>
