<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/halls.php';
  include_once '../../models/hallImages.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate category object
  $halls = new Halls($db);
  $hallImages = new HallImages($db);

  // halls read query
  $result = $halls->read(); 
  // Get row count
  $num = $result->rowCount();

  // Check if any categories
  if($num > 0) {
        // Cat array
        $hall_arr = array();
        $img_arr = array();
        $img_arr['data'] = array();
        $hall_arr['data'] = array(); 
        //  $hall_arr['img'] = array(); 
        $i=-1;
        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
          extract($row); 
            $hall_item = array(
              'id' => $id,
              'name' => $name,
              'price' => $price,
              'location' => $location,
              'person' => $person,
              'imgs'=>[]
             
            ); 
            // Push to "data" 
            array_push($hall_arr['data'], $hall_item);
            $result1 = $hallImages->read($hall_item['id']);
            $num1 = $result1->rowCount();
            // echo '<li>' . $i . '</li>';
            $i++;
            if($num1 > 0) {
              while($row1 = $result1->fetch(PDO::FETCH_ASSOC)) {
                extract($row1); 
                $img_item = array(
                  'hallId' => $hallId,
                  'isDefault' => $isDefault, 
                  'url' => $url 
                );
                array_push($img_arr['data'], $img_item);  
              }
               // array_push($hall_arr['data'][$i],$img_arr['data']);
               $hall_arr['data'][$i]['imgs'] = $img_arr['data'];
              $img_arr['data']=[];
            }
        }

        // Turn to JSON & output
        echo json_encode($hall_arr);

  } else {
        // No Categories
        echo json_encode(
          array('message' => 'No hall Found')
        );
  }
?>