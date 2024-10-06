<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/jdetails_from.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $services = new Jdetails_from($db);

  // Get raw posted data
 // $data = utf8_encode(file_get_contents("php://input")) ;
  $data2 = json_decode(file_get_contents("php://input") ,true);
  
  $res =array() ;
 // $values = string ;
 
    foreach($data2 as $col){
     // print_r($col['pay_ref']);
      $services->j_id = $col['j_id'];
      $services->j_ref = $col['j_ref'] ;
      $services->ac_id = $col['ac_id'];
      $services->j_type = $col['j_type'] ;
      $services->credit = $col['credit'] ;
      $services->debit = $col['debit'] ;
      $services->store_id = $col['store_id'] ; 
       $services->yearId = $col['yearId'] ; 
       // $services->create();
      // Create post
      array_push($res , array(
        "id" => 'NULL',
        "j_id" => $col['j_id'],
        "j_ref" => $col['j_ref'],
        "ac_id" => $col['ac_id'],
        "credit" => $col['credit'],
        "debit" => $col['debit'], 
        "j_desc" => $col['j_desc'], 
        "j_type" => $col['j_type'],
        "store_id" => $col['store_id'],
         "yearId" => $col['yearId']
        ) 
      );
     
    }
    
    
    
    
    $max = sizeof($res);
    $values = '';
     for($i = 0; $i < $max;$i++){
       if ($i == 0) { 
        
        $values = '('.$res[$i]['id'].',"'.$res[$i]['j_id'].'","'.$res[$i]['j_ref'].'","'.$res[$i]['ac_id'].'","'.$res[$i]['credit'].'","'.$res[$i]['debit'].'","'.$res[$i]['j_desc'].'","'.$res[$i]['j_type'].'","'.$res[$i]['store_id'].'","'.$res[$i]['yearId'].'")';
       }
      elseif ( $i == $max-1) { 
        $values = ''.$values.',('.$res[$i]['id'].',"'.$res[$i]['j_id'].'","'.$res[$i]['j_ref'].'","'.$res[$i]['ac_id'].'","'.$res[$i]['credit'].'","'.$res[$i]['debit'].'","'.$res[$i]['j_desc'].'","'.$res[$i]['j_type'].'","'.$res[$i]['store_id'].'","'.$res[$i]['yearId'].'")' ;
      }elseif ($i > 0 and $i < $max-1){ 
        $values = ''.$values.',('.$res[$i]['id'].',"'.$res[$i]['j_id'].'","'.$res[$i]['j_ref'].'","'.$res[$i]['ac_id'].'","'.$res[$i]['credit'].'","'.$res[$i]['debit'].'","'.$res[$i]['j_desc'].'","'.$res[$i]['j_type'].'","'.$res[$i]['store_id'].'","'.$res[$i]['yearId'].'")' ;
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
     
  

