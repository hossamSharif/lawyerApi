<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Services.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $services = new Services($db);

  // Get raw posted data
  // $data = utf8_encode(file_get_contents("php://input")) ;
  // $data2 = json_decode($data ,true);
  // print_r($data2);
  $data2 = json_decode(file_get_contents("php://input") ,true);
  $res =array() ;
 // $values = string ;
    foreach($data2 as $col){
     // print_r($col['ptinvo_id']);
      $services->ptinvo_id = $col['ptinvo_id'];
      $services->serv_desc = $col['serv_desc'] ;
      $services->serv_price = $col['serv_price'];
      $services->serv_type = $col['serv_type'] ;
      $services->list_ordering = $col['list_ordering'] ;
      $services->status = $col['status'] ;
      $services->serv_id = $col['serv_id'] ;
     // $services->create();
      // Create post
      array_push($res , array(
        "id" => 'NULL',
        "ptinvo_id" => $col['ptinvo_id'],
        "serv_desc" => $col['serv_desc'],
        "serv_price" => $col['serv_price'],
        "serv_type" => $col['serv_type'],
        "list_ordering" => $col['list_ordering'], 
        "status" => $col['status'], 
        "serv_id" => $col['serv_id']
        ) 
      );
     
    }
 
    
    $max = sizeof($res);
    $values = '';
     for($i = 0; $i < $max;$i++){
       if ($i == 0) { 
        $values = '('.$res[$i]['id'].','.$res[$i]['ptinvo_id'].',"'.$res[$i]['serv_desc'].'",'.$res[$i]['serv_price'].',"'.$res[$i]['serv_type'].'","'.$res[$i]['list_ordering'].'","'.$res[$i]['status'].'","'.$res[$i]['serv_id'].'")';
       }
      elseif ( $i == $max-1) { 
        $values = ''.$values.',('.$res[$i]['id'].','.$res[$i]['ptinvo_id'].',"'.$res[$i]['serv_desc'].'",'.$res[$i]['serv_price'].',"'.$res[$i]['serv_type'].'","'.$res[$i]['list_ordering'].'","'.$res[$i]['status'].'","'.$res[$i]['serv_id'].'")' ;
      }elseif ($i > 0 and $i < $max-1){ 
        $values = ''.$values.',('.$res[$i]['id'].','.$res[$i]['ptinvo_id'].',"'.$res[$i]['serv_desc'].'",'.$res[$i]['serv_price'].',"'.$res[$i]['serv_type'].'","'.$res[$i]['list_ordering'].'","'.$res[$i]['status'].'","'.$res[$i]['serv_id'].'")' ;
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
     
  // $services->ptinvo_id = $data->ptinvo_id;
  // $services->serv_desc = $data->serv_desc;
  // $services->serv_price = $data->serv_price;
  // $services->serv_type = $data->serv_type;
  // $services->list_ordering = $data->list_ordering;
  // $services->status = $data->status;
  // $services->serv_id = $data->serv_id;
 
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

