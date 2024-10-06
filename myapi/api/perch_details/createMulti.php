<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/perch_details.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $services = new Perch_details($db);

  // Get raw posted data
  // $data = utf8_encode(file_get_contents("php://input")) ;
  // $data2 = json_decode($data ,true);
  // print_r($data2);
  $data2 = json_decode(file_get_contents("php://input") ,true);
  $res =array() ;
 // $values = string ;


    foreach($data2 as $col){
     // print_r($col['pay_ref']);
      $services->pay_ref = $col['pay_ref'];
      $services->item_name = $col['item_name'] ;
      $services->pay_price = $col['pay_price'];
      $services->quantity = $col['quantity'] ;
      $services->tot = $col['tot'] ;
      $services->store_id = $col['store_id'] ;
      $services->item_id = $col['item_id'] ;
      $services->dateCreated = $col['dateCreated'] ;
      $services->perch_price = $col['perch_price'] ;
       $services->yearId = $col['yearId'] ;
       // $services->create();
      // Create post
      array_push($res , array(
        "id" => 'NULL',
        "pay_ref" => $col['pay_ref'],
        "item_name" => $col['item_name'],
        "pay_price" => $col['pay_price'],
        "quantity" => $col['quantity'],
        "tot" => $col['tot'], 
        "store_id" => $col['store_id'], 
        "item_id" => $col['item_id'],
        "dateCreated" => $col['dateCreated'],
        "perch_price" => $col['perch_price'],
         "yearId" => $col['yearId']
        ) 
      );
     
    }
 
    
    $max = sizeof($res);
    $values = '';
     for($i = 0; $i < $max;$i++){
       if ($i == 0) { 
        $values = '('.$res[$i]['id'].',"'.$res[$i]['pay_ref'].'","'.$res[$i]['item_name'].'","'.$res[$i]['pay_price'].'",'.$res[$i]['quantity'].',"'.$res[$i]['tot'].'","'.$res[$i]['store_id'].'",'.$res[$i]['item_id'].',"'.$res[$i]['dateCreated'].'","'.$res[$i]['perch_price'].'",'.$res[$i]['yearId'].')';
       }
      elseif ( $i == $max-1) { 
        $values = ''.$values.',('.$res[$i]['id'].',"'.$res[$i]['pay_ref'].'","'.$res[$i]['item_name'].'","'.$res[$i]['pay_price'].'",'.$res[$i]['quantity'].',"'.$res[$i]['tot'].'",'.$res[$i]['store_id'].','.$res[$i]['item_id'].',"'.$res[$i]['dateCreated'].'","'.$res[$i]['perch_price'].'",'.$res[$i]['yearId'].')' ;
      }elseif ($i > 0 and $i < $max-1){ 
        $values = ''.$values.',('.$res[$i]['id'].',"'.$res[$i]['pay_ref'].'","'.$res[$i]['item_name'].'","'.$res[$i]['pay_price'].'",'.$res[$i]['quantity'].',"'.$res[$i]['tot'].'",'.$res[$i]['store_id'].','.$res[$i]['item_id'].',"'.$res[$i]['dateCreated'].'","'.$res[$i]['perch_price'].'",'.$res[$i]['yearId'].')' ;
      }   
     };
     
      if($services->createMulti($values)) {
          echo json_encode(
            array('message' => 'Post Created')
          );
        } else {
          echo json_encode(
            array('message' => 'Post Not Created')
          );
        }
     
  // $services->pay_ref = $data->pay_ref;
  // $services->item_name = $data->item_name;
  // $services->pay_price = $data->pay_price;
  // $services->quantity = $data->quantity;
  // $services->tot = $data->tot;
  // $services->store_id = $data->store_id;
  // $services->item_id = $data->item_id;
 
  // // Create post
  // if($services->create()) {
  //   echo json_encode(
  //     array('message' => 'Post Created')
  //   );
  // } else {
  //   echo json_encode(
  //     array('message' => 'Post Not Created')
  //   );
  // }

