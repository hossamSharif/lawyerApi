<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/customer.php';
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $category = new Customer($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  // Set ID to UPDATE
  $category->id = $data->id;


  $category->cust_name = $data->cust_name;
  $category->cust_type = $data->cust_type;
  $category->cust_ident = $data->cust_ident;
  $category->cust_ref = $data->cust_ref;
  $category->email = $data->email;
  $category->phone = $data->phone;
  $category->company_email = $data->company_email;
  $category->company_name = $data->company_name;
   $category->company_phone = $data->company_phone;
  $category->company_regno = $data->company_regno;
   $category->company_ident = $data->company_ident;
   $category->status = $data->status;
   $category->company_represent = $data->company_represent;
   $category->full_address = $data->full_address;
   $category->city = $data->city;
   $category->region = $data->region;
   $category->company_represent_desc = $data->company_represent_desc;
   $category->passport = $data->passport;
   $category->phone_key = $data->phone_key;   
 
   
  // $category->name = $data->name;

  // Update post
  if($category->update()) {
    echo json_encode(
      array('message' => 'Post Updated')
    );
  } else {
    echo json_encode(
      array('message' => 'Post not updated')
    );
  }
