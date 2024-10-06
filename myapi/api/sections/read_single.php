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

  // Get ID
  $section->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Get post
  $section->read_single();

  // Create array
  $section_arr = array(
    'id' => $section->id,
    'shortDescr' => $shortDescr,
        // 'body' => html_entity_decode($body),
        'imgUrl' => $imgUrl,
        'title' => $title
  );

  // Make JSON
  print_r(json_encode($section_arr));