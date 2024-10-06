<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/pay.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $services = new Pay($db);

  // Get raw posted data
  // $data = utf8_encode(file_get_contents("php://input")) ;
  // $data2 = json_decode($data ,true);
  $data2 = json_decode(file_get_contents("php://input") ,true);
  // print_r($data2);
  $res =array() ;
 // $values = string ;
 
    foreach($data2 as $col){
     // print_r($col['pay_ref']);
      $services->logRef = $col['logRef'];
      $services->store_id = $col['store_id'] ;
      $services->datee = $col['datee'] ;
      $services->typee = $col['typee'];
      $services->logToken = $col['logToken'] ;
      $services->logStatus = $col['logStatus'] ; 
      $services->user_id = $col['user_id'] ;
      $services->yearId = $col['yearId'] ; 
     
    
      $services->yearId = $col['yearId'] ;
      
       // $services->create();
      // Create post
      array_push($res , array(
        "id" => 'NULL',
        "logRef" => $col['logRef'],
        "store_id" => $col['store_id'], 
        "datee" => $col['datee'],
        "typee" => $col['typee'] ,  
        "logToken" => $col['logToken'] ,
        "logStatus" => $col['logStatus'],
        "user_id" => $col['user_id'] ,
        "yearId" => $col['yearId'] 
        ) 
      );
     
    }
 
    
    $max = sizeof($res);
    $values = '';
     for($i = 0; $i < $max;$i++){
       if ($i == 0) { 
        $values = '('.$res[$i]['id'].',"'.$res[$i]['log_ref'].'","'.$res[$i]['userId'].'","'.$res[$i]['typee'].'","'.$res[$i]['datee'].'","'.$res[$i]['logStatus'].'","'.$res[$i]['logToken'].'",'.$res[$i]['yearId'].','.$res[$i]['store_id'].')';
       }
      elseif ( $i == $max-1) { 
        $values = ''.$values.',('.$res[$i]['id'].',"'.$res[$i]['log_ref'].'","'.$res[$i]['userId'].'","'.$res[$i]['typee'].'","'.$res[$i]['datee'].'","'.$res[$i]['logStatus'].'","'.$res[$i]['logToken'].'",'.$res[$i]['yearId'].','.$res[$i]['store_id'].')';
      }elseif ($i > 0 and $i < $max-1){ 
        $values = ''.$values.',('.$res[$i]['id'].',"'.$res[$i]['log_ref'].'","'.$res[$i]['userId'].'","'.$res[$i]['typee'].'","'.$res[$i]['datee'].'","'.$res[$i]['logStatus'].'","'.$res[$i]['logToken'].'",'.$res[$i]['yearId'].','.$res[$i]['store_id'].')';
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
     


