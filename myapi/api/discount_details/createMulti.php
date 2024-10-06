<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/discount_details.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $services = new Discount_details($db);
  // Get raw posted data
  // $data = utf8_encode(file_get_contents("php://input")) ;
  // $data2 = json_decode($data ,true);
  $data2 = json_decode(file_get_contents("php://input") ,true);
  // print_r($data2);
  $res =array() ;
 // $values = string ;


    foreach($data2 as $col){
     // print_r($col['pay_ref']);
     $services->item_id = $col['item_id'] ; 
     $services->discount_id = $col['discount_id'] ; 
     $services->perc = $col['perc'] ; 
     $services->from_date = $col['from_date'] ; 
     $services->to_date = $col['to_date'] ; 
    
       // $services->create();
      // Create post
      array_push($res , array(
        "id" => "NULL",  
        "from_date" => $col['from_date'] ,
        "to_date" => $col['to_date'], 
        "discount_id" => $col['discount_id'],
        "item_id" => $col['item_id'],
        "perc" => $col['perc']  
      )
      );
    }
 
    
    $max = sizeof($res);
    $values = '';
     for($i = 0; $i < $max;$i++){
       if ($i == 0) { 
        $values = '('.$res[$i]['id'].',"'.$res[$i]['from_date'].'","'.$res[$i]['to_date'].'","'.$res[$i]['discount_id'].'",'.$res[$i]['item_id'].',"'.$res[$i]['perc'].'")' ;
       }
      elseif ( $i == $max-1) { 
        $values = ''.$values.',('.$res[$i]['id'].',"'.$res[$i]['from_date'].'","'.$res[$i]['to_date'].'","'.$res[$i]['discount_id'].'",'.$res[$i]['item_id'].',"'.$res[$i]['perc'].'")' ;
      }elseif ($i > 0 and $i < $max-1){ 
        $values = ''.$values.',('.$res[$i]['id'].',"'.$res[$i]['from_date'].'","'.$res[$i]['to_date'].'","'.$res[$i]['discount_id'].'",'.$res[$i]['item_id'].',"'.$res[$i]['perc'].'")' ;
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

