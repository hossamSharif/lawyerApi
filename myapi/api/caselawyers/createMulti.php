<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/caselawyers.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $services = new Caselawyers($db);

  // Get raw posted data
  // $data = utf8_encode(file_get_contents("php://input")) ;
  // $data2 = json_decode($data ,true);
  $data2 = json_decode(file_get_contents("php://input") ,true);
  // print_r($data2);
  $res =array() ;
 // $values = string ; 
    foreach($data2 as $col){
     // print_r($col['pay_ref']);
      $services->user_id = $col['user_id'];
      $services->case_id = $col['case_id'] ;
       
       // $services->create();
      // Create post
      array_push($res , array(
        "case_id" => $col['case_id'],
        "user_id" => $col['user_id'] 
        ) 
      );
     
    }
 
    
    $max = sizeof($res);
    $values = '';
     for($i = 0; $i < $max;$i++){
       if ($i == 0) { 
        $values = '('.$res[$i]['case_id'].','.$res[$i]['user_id'].')';
       }
      elseif ( $i == $max-1) { 
        $values = ''.$values.',('.$res[$i]['case_id'].',"'.$res[$i]['user_id'].'" )';
      }elseif ($i > 0 and $i < $max-1){ 
        $values = ''.$values.',('.$res[$i]['case_id'].',"'.$res[$i]['user_id'].'" )';
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

