<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/sections.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $section = new Section($db);

  // Blog post query
  $result = $section->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any posts
  if($num > 0) {
    // Post array
    $sections_arr = array();
    // $sections_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      
      $section_item = array(
        'id' => $id,
        'shortDescr' => $shortDescr,
        // 'body' => html_entity_decode($body),
        'imgUrl' => $imgUrl,
        'title' => $title
         
      );

      // Push to "data"
      array_push($sections_arr, $section_item);
      // array_push($sections_arr['data'], $section_item);
    }

    // Turn to JSON & output
    echo json_encode($sections_arr);

  } else {
    // No Posts
    echo json_encode(
      array('message' => 'No Posts Found')
    );
  }
