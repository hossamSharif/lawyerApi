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
      $payments->id = $col['id'];
      $payments->case_id = $col['case_id'];
      $payments->amount = $col['amount'];
      $payments->payment_date = $col['payment_date'];
      $payments->notification_date = $col['notification_date'];
      $payments->notification_daysBefor = $col['notification_daysBefor'];
      $payments->notification_type = $col['notification_type'];
      $payments->notification_id = $col['notification_id'];
      $payments->client_id = $col['client_id'];
      $payments->status = $col['status'];
      $payments->description = $col['description'];
       
      array_push($res, array(
        "id" => $col['id'],
        "case_id" => $col['case_id'],
        "amount" => $col['amount'],
        "payment_date" => $col['payment_date'],
        "notification_date" => $col['notification_date'],
        "notification_daysBefor" => $col['notification_daysBefor'],
        "notification_type" => $col['notification_type'],
        "notification_id" => $col['notification_id'],
        "client_id" => $col['client_id'],
        "status" => $col['status'],
        "description" =>  $col['description']

      ));
  }

  $max = sizeof($res);
  $values = '';
  for($i = 0; $i < $max; $i++){
    if ($i == 0) { 
      $values = '( '.$res[$i]['id'].','.$res[$i]['case_id'].',"'.$res[$i]['amount'].'","'.$res[$i]['payment_date'].'","'.$res[$i]['notification_date'].'","'.$res[$i]['notification_daysBefor'].'","'.$res[$i]['notification_type'].'",'.$res[$i]['notification_id'].','.$res[$i]['client_id'].',"'.$res[$i]['status'].'","'.$res[$i]['description'].'")';
    } elseif ($i == $max-1) { 
      $values = ''.$values.',('.$res[$i]['id'].','.$res[$i]['case_id'].',"'.$res[$i]['amount'].'","'.$res[$i]['payment_date'].'","'.$res[$i]['notification_date'].'","'.$res[$i]['notification_daysBefor'].'","'.$res[$i]['notification_type'].'",'.$res[$i]['notification_id'].','.$res[$i]['client_id'].',"'.$res[$i]['status'].'","'.$res[$i]['description'].'")';
    } elseif ($i > 0 && $i < $max-1) { 
      $values = ''.$values.',('.$res[$i]['id'].','.$res[$i]['case_id'].',"'.$res[$i]['amount'].'","'.$res[$i]['payment_date'].'","'.$res[$i]['notification_date'].'","'.$res[$i]['notification_daysBefor'].'","'.$res[$i]['notification_type'].'",'.$res[$i]['notification_id'].','.$res[$i]['client_id'].',"'.$res[$i]['status'].'","'.$res[$i]['description'].'")';
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
