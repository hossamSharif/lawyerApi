<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/student.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $student = new Student($db);

  // Get ID
  $student->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Get post
  $student->read_single();

  // Create array
  $student_arr = array(
    'id' => $id,
        'name' => $name,
        // 'body' => html_entity_decode($body),
        'email' => $email,
        'phone' => $phone,
        'offerId' => $offerId
  );

  // Make JSON
  print_r(json_encode($student_arr));