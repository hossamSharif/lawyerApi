<?php 
$connect = mysqli_connect("localhost", "aljouryc_hossam", "Hossam1990@", "aljouryc_erp");
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
include_once './PHPExcel/PHPExcel/IOFactory.php'; 

 // Instantiate DB & connect

$response = array();
$upload_dir = '/home/aljouryc/erp.hosamdev.com/myapi/uploads/';
$server_url = 'https://erp.hosamdev.com';
 
 

if($_FILES['avatar'])
{
    $avatar_name = $_FILES["avatar"]["name"];
    $avatar_tmp_name = $_FILES["avatar"]["tmp_name"];
    $error = $_FILES["avatar"]["error"];

    if($error > 0){
        $response = array(
            "status" => "error",
            "error" => true,
            "message" => "Error uploading the file!"
        );
    } else {
    // insert data from xsl sheet
    $extension = end(explode(".", $_FILES["avatar"]["name"])); // For getting Extension of selected file
    $allowed_extension = array("xls", "xlsx", "csv"); //allowed extension
    if(in_array($extension, $allowed_extension)) //check selected file extension is present in allowed extension array
    {
     $file = $_FILES["avatar"]["tmp_name"]; // getting temporary source of excel file
    
     $objPHPExcel = PHPExcel_IOFactory::load($file); // create object of PHPExcel library by using load() method and in load method define path of selected file
   
    
     foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
     {
      $highestRow = $worksheet->getHighestRow();
      for($row=2; $row<=$highestRow; $row++)
      {
       
       $fq_year = '2022';
       $store_id ='1';
       
       ///
 
       
       $item_id = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(12, $row)->getValue());
       $quantity = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(1, $row)->getValue());
       $pay_price = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(3, $row)->getValue());
       $perch_price = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(4, $row)->getValue());
       
       
       
       $query = "INSERT INTO firstq(id,item_id,quantity,fq_year,pay_price,perch_price,store_id) VALUES ('NULL', '".$item_id."', '".$quantity."', '".$fq_year."', '".$pay_price."', '".$perch_price."', '".$store_id."')";
       mysqli_query($connect, $query);
       
      }
     }  
    }
    else
    {
     $output = '<label class="text-danger">Invalid File</label>'; //if non excel file then
    }
     //
        $random_name = rand(1000,1000000)."-".$avatar_name;
        $upload_name = $upload_dir.strtolower($random_name);
        $upload_name = preg_replace('/\s+/', '-', $upload_name);
    
        if(move_uploaded_file($avatar_tmp_name ,$upload_name)) {
            $response = array(
                "status" => "success",
                "error" => false,
                "message" => "File uploaded successfully",
                "url" => $server_url."/myapi/uploads/".$random_name
              );
        }else
        {
            $response = array(
                "status" => "error",
                "error" => true,
                "message" => "Error uploading the file!"
            );
        }
    }   

}else{
    $response = array(
        "status" => "error",
        "error" => true,
        "message" => "No file was sent!"
    );
}

echo json_encode($response);
?>