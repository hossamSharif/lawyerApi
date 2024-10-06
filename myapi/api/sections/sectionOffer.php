<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/sections.php';
  include_once '../../models/offer.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate category object
  $section = new Section($db);
  $offer = new Offer($db);

  // halls read query
  $result = $section->read(); 
  // Get row count
  $num = $result->rowCount();

  // Check if any categories
  if($num > 0) {
        // Cat array
        $section_arr = array();
        $offer_arr = array();
        $offer_arr['data'] = array();
        $section_arr['data'] = array(); 
        //  $hall_arr['img'] = array(); 
        $i=-1;
        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
          extract($row); 
            $section_item = array(
              'id' => $id,
              'shortDescr' => $shortDescr,
              // 'body' => html_entity_decode($body),
              'imgUrl' => $imgUrl,
              'title' => $title,
              'offers'=>[]
             
            ); 
            // Push to "data" 
            array_push($section_arr['data'], $section_item);
            $result1 = $offer->read2($section_item['id']);
            $num1 = $result1->rowCount();
            // echo '<li>' . $i . '</li>';
            $i++;
            if($num1 > 0) {
              while($row1 = $result1->fetch(PDO::FETCH_ASSOC)) {
                extract($row1); 
                $offer_item = array(
                  'id' => $id,
                  'title' => $title, 
                  'dailyTime' => $dailyTime ,
                  'hourCount' => $hourCount ,
                  'price' => $price ,
                  'price_note' => $price_note ,
                  'start' => $start ,
                  'sectionId' => $sectionId, 
                  'shortDescr' => $shortDescr ,
                  'teacher' => $teacher, 
                  'imgUrl' => $imgUrl,
                   'ordering' => $ordering,
                   'discountLbl' => $discountLbl,
                    'newLbl' => $newLbl,
                    'status' => $status
                );
                array_push($offer_arr['data'], $offer_item);  
              }
               // array_push($hall_arr['data'][$i],$img_arr['data']);
               $section_arr['data'][$i]['offers'] = $offer_arr['data'];
              $offer_arr['data']=[];
            }
        }

        // Turn to JSON & output
        echo json_encode($section_arr);

  } else {
        // No Categories
        echo json_encode(
          array('message' => 'No hall Found')
        );
  }
?>