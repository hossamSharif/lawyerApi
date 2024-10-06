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
      $services->pay_ref = $col['pay_ref'];
      $services->tot_pr = $col['tot_pr'] ;
      $services->pay_date = $col['pay_date'];
      $services->pay_time = $col['pay_time'] ;
      $services->cust_id = $col['cust_id'] ;
      $services->discount = $col['discount'] ;
      $services->changee = $col['changee'] ;
      $services->user_id = $col['user_id'] ;
      $services->pay = $col['pay'] ; 
      $services->store_id = $col['store_id'] ;
      $services->pay_method = "cash" ;
      $services->payComment = $col['payComment'] ;
       $services->nextPay = $col['nextPay'] ;
       $services->yearId = $col['yearId'] ;
       $services->companyId = $col['companyId'] ;
      
       // $services->create();
      // Create post
      array_push($res , array(
        "pay_id" => 'NULL',
        "pay_ref" => $col['pay_ref'],
        "store_id" => $col['store_id'], 
        "tot_pr" => $col['tot_pr'],
        "pay" => $col['pay'] ,  
        "changee" => $col['changee'] ,
        "pay_date" => $col['pay_date'],
        "pay_method" => $col['pay_method'] ,
        "cust_id" => $col['cust_id'], 
        "discount" => $col['discount'] ,
        "pay_time" => $col['pay_time'], 
        "user_id" => $col['user_id'] ,
        "payComment" => $col['payComment'] ,
        "nextPay" => $col['nextPay'] ,
        "yearId" => $col['yearId'] 
        "companyId" => $col['companyId'] 
        ) 
      );
     
    }
 
    
    $max = sizeof($res);
    $values = '';
     for($i = 0; $i < $max;$i++){
       if ($i == 0) { 
        $values = '('.$res[$i]['pay_id'].',"'.$res[$i]['pay_ref'].'","'.$res[$i]['store_id'].'","'.$res[$i]['tot_pr'].'","'.$res[$i]['pay'].'","'.$res[$i]['changee'].'","'.$res[$i]['pay_date'].'","'.$res[$i]['pay_method'].'",'.$res[$i]['cust_id'].',"'.$res[$i]['discount'].'","'.$res[$i]['pay_time'].'","'.$res[$i]['user_id'].'","'.$res[$i]['payomment'].'","'.$res[$i]['nextPay'].'","'.$res[$i]['yearId'].'","'.$res[$i]['companyId'].'")';
       }
      elseif ( $i == $max-1) { 
        $values = ''.$values.',('.$res[$i]['pay_id'].',"'.$res[$i]['pay_ref'].'","'.$res[$i]['store_id'].'","'.$res[$i]['tot_pr'].'","'.$res[$i]['pay'].'","'.$res[$i]['changee'].'","'.$res[$i]['pay_date'].'","'.$res[$i]['pay_method'].'",'.$res[$i]['cust_id'].',"'.$res[$i]['discount'].'","'.$res[$i]['pay_time'].'","'.$res[$i]['user_id'].'","'.$res[$i]['payomment'].'","'.$res[$i]['nextPay'].'","'.$res[$i]['yearId'].'","'.$res[$i]['companyId'].'")';
      }elseif ($i > 0 and $i < $max-1){ 
        $values = ''.$values.',('.$res[$i]['pay_id'].',"'.$res[$i]['pay_ref'].'","'.$res[$i]['store_id'].'","'.$res[$i]['tot_pr'].'","'.$res[$i]['pay'].'","'.$res[$i]['changee'].'","'.$res[$i]['pay_date'].'","'.$res[$i]['pay_method'].'",'.$res[$i]['cust_id'].',"'.$res[$i]['discount'].'","'.$res[$i]['pay_time'].'","'.$res[$i]['user_id'].'","'.$res[$i]['payomment'].'","'.$res[$i]['nextPay'].'","'.$res[$i]['yearId'].'","'.$res[$i]['companyId'].'")';
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
     


