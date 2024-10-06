<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/teacher.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $teacher = new Teacher($db);

  // Get ID
  $teacher->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Get post
  $teacher->read_single();

  // Create array
  $teacher_arr = array(
    'id' => $teacher->id,
    'shortDescr' => $shortDescr,
        // 'body' => html_entity_decode($body),
        'imgUrl' => $imgUrl,
        'name' => $name
  );

  // Make JSON
  print_r(json_encode($teacher_arr));