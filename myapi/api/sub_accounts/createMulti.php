<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/sub_accounts.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $services = new Sub_accounts($db);

  // Get raw posted data
  // $data = utf8_encode(file_get_contents("php://input")) ;
  // $data2 = json_decode($data ,true);
  $data2 = json_decode(file_get_contents("php://input") ,true);
  // print_r($data2);
  $res =array() ;
 // $values = string ;



    foreach($data2 as $col){
     // print_r($col['pay_ref']);
      $services->sub_name = $col['sub_name'];
      $services->ac_id = $col['ac_id'] ;
      $services->sub_type = $col['sub_type'];
      $services->sub_balance = $col['sub_balance'] ;
      $services->sub_code = $col['sub_code'] ;
      $services->store_id = $col['store_id'] ;
       $services->cat_id = $col['cat_id'] ;
      $services->cat_name = $col['cat_name'] ;
        $services->phone = $col['phone'] ;
          $services->address = $col['address'] ;
       // $services->create();
      // Create post
      array_push($res , array(
        "id" => 'NULL',
        "sub_name" => $col['sub_name'],
        "ac_id" => $col['ac_id'],
        "sub_type" => $col['sub_type'],
        "sub_balance" => $col['sub_balance'],
        "sub_code" => $col['sub_code'], 
        "store_id" => $col['store_id'],
         "cat_id" => $col['cat_id'],
         "cat_name" => $col['cat_name'],
          "phone" => $col['cat_name'],
           "address" => $col['address']
        ) 
      );
     
    }
 
    
      $max = sizeof($res);
    $values = '';
     for($i = 0; $i < $max;$i++){
       if ($i == 0) { 
        $values = '('.$res[$i]['id'].','.$res[$i]['ac_id'].',"'.$res[$i]['sub_name'].'","'.$res[$i]['sub_type'].'","'.$res[$i]['sub_balance'].'","'.$res[$i]['sub_code'].'","'.$res[$i]['cat_id'].'","'.$res[$i]['cat_name'].'","'.$res[$i]['store_id'].'","'.$res[$i]['phone'].'","'.$res[$i]['address'].'")';
       }
      elseif ( $i == $max-1) { 
        $values = ''.$values.',('.$res[$i]['id'].','.$res[$i]['ac_id'].',"'.$res[$i]['sub_name'].'","'.$res[$i]['sub_type'].'","'.$res[$i]['sub_balance'].'","'.$res[$i]['sub_code'].'","'.$res[$i]['cat_id'].'","'.$res[$i]['cat_name'].'","'.$res[$i]['store_id'].'","'.$res[$i]['phone'].'","'.$res[$i]['address'].'")';
      }elseif ($i > 0 and $i < $max-1){ 
        $values = ''.$values.',('.$res[$i]['id'].','.$res[$i]['ac_id'].',"'.$res[$i]['sub_name'].'","'.$res[$i]['sub_type'].'","'.$res[$i]['sub_balance'].'","'.$res[$i]['sub_code'].'","'.$res[$i]['cat_id'].'","'.$res[$i]['cat_name'].'","'.$res[$i]['store_id'].'","'.$res[$i]['phone'].'","'.$res[$i]['address'].'")';
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
     


