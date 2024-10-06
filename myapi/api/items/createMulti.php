<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/items.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $services = new Items($db);

  // Get raw posted data
  // $data = utf8_encode(file_get_contents("php://input")) ;
  // $data2 = json_decode($data ,true);
  $data2 = json_decode(file_get_contents("php://input") ,true);
  // print_r($data2);
  $res =array() ;
 // $values = string ;

 
    foreach($data2 as $col){
     // print_r($col['pay_ref']);
      $services->item_name = $col['item_name'];
      $services->item_unit = $col['item_unit'] ;
      $services->model = $col['model'];
      $services->part_no = $col['part_no'] ;
      $services->brand = $col['brand'] ;
      $services->min_qty = $col['min_qty'] ;
      $services->pay_price = $col['pay_price'] ;
      $services->item_desc = $col['item_desc'] ;
      $services->perch_price = $col['perch_price'] ;
      $services->item_parcode = $col['item_parcode'] ;
      $services->aliasEn = $col['aliasEn'] ;
      $services->tax = $col['tax'] ;
      $services->imgUrl = $col['imgUrl'] ;
       // $services->create();
      // Create post
      array_push($res , array(
        "id" => 'NULL',
        "item_name" => $col['item_name'],
        "model" => $col['model'],
        "part_no" => $col['part_no'],
        "brand" => $col['brand'], 
        "min_qty" => $col['min_qty'], 
        "item_unit" => $col['item_unit'],  
        "pay_price" => $col['pay_price'],
        "perch_price" => $col['perch_price'],
        "item_desc" => $col['item_desc'], 
        "item_parcode" => $col['item_parcode'],
        "aliasEn" => $col['aliasEn'],
        "tax" => $col['tax'],
        "imgUrl" => $col['imgUrl']
        ) 
      );
     
    }
 
    
    $max = sizeof($res);
    $values = '';
     for($i = 0; $i < $max;$i++){
       if ($i == 0) { 
        $values = '('.$res[$i]['id'].',"'.$res[$i]['item_name'].'","'.$res[$i]['model'].'","'.$res[$i]['part_no'].'","'.$res[$i]['brand'].'","'.$res[$i]['min_qty'].'","'.$res[$i]['item_unit'].'","'.$res[$i]['pay_price'].'","'.$res[$i]['perch_price'].'","'.$res[$i]['item_desc'].'","'.$res[$i]['item_parcode'].'","'.$res[$i]['aliasEn'].'","'.$res[$i]['tax'].'","'.$res[$i]['imgUrl'].'")';
       }
      elseif ( $i == $max-1) { 
        $values = ''.$values.',('.$res[$i]['id'].',"'.$res[$i]['item_name'].'","'.$res[$i]['model'].'","'.$res[$i]['part_no'].'","'.$res[$i]['brand'].'","'.$res[$i]['min_qty'].'","'.$res[$i]['item_unit'].'","'.$res[$i]['pay_price'].'","'.$res[$i]['perch_price'].'","'.$res[$i]['item_desc'].'","'.$res[$i]['item_parcode'].'","'.$res[$i]['aliasEn'].'","'.$res[$i]['tax'].'","'.$res[$i]['imgUrl'].'")';
      }elseif ($i > 0 and $i < $max-1){ 
        $values = ''.$values.',('.$res[$i]['id'].',"'.$res[$i]['item_name'].'","'.$res[$i]['model'].'","'.$res[$i]['part_no'].'","'.$res[$i]['brand'].'","'.$res[$i]['min_qty'].'","'.$res[$i]['item_unit'].'","'.$res[$i]['pay_price'].'","'.$res[$i]['perch_price'].'","'.$res[$i]['item_desc'].'","'.$res[$i]['item_parcode'].'","'.$res[$i]['aliasEn'].'","'.$res[$i]['tax'].'","'.$res[$i]['imgUrl'].'")';
      }   
     };
      
        if($services->createMulti($values)) {
          $last_id = $db->lastInsertId();
          echo json_encode(
            array('message' => $last_id)
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

