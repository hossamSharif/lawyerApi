<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Services.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $services = new Services($db);

  // Blog post query
  $result = $services->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any posts
  if($num > 0) {
    // Post array
    $servicess_arr = array();
    // $servicess_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      
      $services_item = array(
        'id' => $id,
        'ptinvo_id' => $ptinvo_id, 
        'serv_desc' => $serv_desc ,
        'serv_price' => $serv_price ,
        'serv_type' => $serv_type ,
        'list_ordering' => $list_ordering ,
        'status' => $status ,
        'serv_id' => $serv_id 
      );

      // Push to "data"
      array_push($servicess_arr, $services_item);
      // array_push($servicess_arr['data'], $services_item);
    }

    // Turn to JSON & output
    echo json_encode($servicess_arr);

  } else {
    // No Posts
    echo json_encode(
      array('message' => 'No Posts Found')
    );
  }
