<?php
  class Items {
 // DB Stuff
    private $conn;
    private $table = 'items';
    private $table2 = 'stock';
    private $table3 = 'esesr';
  
   
    // Properties
    public $id;
    public $item_name;
    public $item_unit;
      public $model;
    public $part_no;
    public $brand;
    public $min_qty;
    public $pay_price;
    public $perch_price;
    public $total;
    public $item_desc;
    public $item_parcode;
     public $aliasEn;
     public $imgUrl;
     public $tax;
     public $discount;

    public $tswiaQuantity;
    public $perchQuantity;
    public $salesQuantity;
    public $firstQuantity;
    public $quantity; 
     public $lastSoldQty; 
      public $lastSoldDate;
         public $purch28;
         public $sales28;

    public $payval; 
    public $perchval; 

   

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get doctors
    public function read() {
      // Create query
      date_default_timezone_set('Asia/Riyadh');
      $date = date('Y-m-d');
      $query = 'SELECT
        id,
        item_name,
        item_unit,
        part_no,
         model,
        brand,
        min_qty,
        pay_price,
        perch_price, 
        item_desc,
        item_parcode ,
        aliasEn,
        tax,
        imgUrl,
         IFNULL((SELECT  discount_details.perc  FROM discount_details INNER JOIN discount ON discount_details.discount_id = discount.id  WHERE  discount_details.item_id = items.id AND discount.status = 1 ), 0) AS discount

      FROM
        ' . $this->table . '
      ORDER BY
        id DESC';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

// read from stock
public function createMulti($values) {
  // Create Query

  $query = 'INSERT INTO ' .
    $this->table . '
    VALUES '. $values .'';
// Prepare Statement
$stmt = $this->conn->prepare($query);


// Execute query
if($stmt->execute()) {
  return true;
}

// Print error if something goes wrong
printf("Error: $s.\n", $stmt->error);

return false;
}
// select count(o.id) as tot_order ,
// sum(o.total) as total_amount,
// (select sum(p.qty) from orders o join order_product p on o.id=p.order) as prd_qty     
// from orders o;
public function readStock() {
  // Create query
  $query = 'SELECT
    items.id,
    items.item_name,
    items.part_no,
    items.brand,
    items.model,
    items.min_qty,
    items.item_unit,
    items.pay_price,
    items.perch_price, 
    items.item_desc,
    items.item_parcode,
    items.aliasEn,
    items.tax,
    items.imgUrl, 
     IFNULL((SELECT SUM(pay_details.quantity) FROM pay_details INNER JOIN pay ON pay_details.pay_ref = pay.pay_ref  WHERE  pay_details.item_id = items.id AND pay_details.store_id = :store_id AND pay.pay_date > "2023-03-29" AND pay.yearId = 2), 0) AS sales28 ,
    IFNULL((SELECT SUM(perch_details.quantity) FROM perch_details INNER JOIN perch ON perch_details.pay_ref = perch.pay_ref WHERE  perch_details.item_id = items.id AND perch_details.store_id = :store_id AND perch.pay_date <= "2023-01-28" AND perch.yearId = 2), 0) AS purch28,
    
    IFNULL((SELECT SUM(pay_details.quantity) FROM pay_details INNER JOIN pay ON pay_details.pay_ref = pay.pay_ref  WHERE  pay_details.item_id = items.id AND pay_details.store_id = :store_id AND pay.pay_date >= "2023-01-01"), 0) AS salesQuantity ,
    IFNULL((SELECT SUM(perch_details.quantity) FROM perch_details INNER JOIN perch ON perch_details.pay_ref = perch.pay_ref WHERE  perch_details.item_id = items.id AND perch_details.store_id = :store_id AND perch.pay_date >= "2023-01-01"), 0) AS perchQuantity,
    IFNULL((SELECT SUM((tswia_details.availQty - tswia_details.qtyReal)) FROM tswia_details INNER JOIN tswia ON tswia_details.pay_ref = tswia.pay_ref WHERE  tswia_details.item_id = items.id AND tswia_details.store_id = :store_id AND tswia.pay_date >= "2023-01-01"), 0) AS tswiaQuantity,
    IFNULL((SELECT SUM(firstq.quantity) FROM firstq WHERE  firstq.item_id = items.id AND firstq.store_id = :store_id ), 0) AS firstQuantity ,
    IFNULL((SELECT MAX(pay.pay_date) FROM pay_details INNER JOIN pay ON pay_details.pay_ref = pay.pay_ref WHERE  pay_details.item_id = items.id AND pay_details.store_id = :store_id ), 0) AS lastSoldDate,
    IFNULL((SELECT MAX(pay_details.quantity) FROM pay_details INNER JOIN pay ON pay_details.pay_ref = pay.pay_ref WHERE  pay_details.item_id = items.id AND pay_details.store_id = :store_id And pay.pay_date = lastSoldDate), 0) AS lastSoldQty
    FROM
    ' . $this->table . '
     WHERE
     items.item_name != "" 
    '; 
        //Prepare statement
        $stmt = $this->conn->prepare($query); 
        // Bind pay_id
        $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT); 
        // Execute query
        $stmt->execute();
    
        return $stmt ;
}

public function readStockResturant() {
  // Create query
  $query = 'SELECT
    items.id,
    items.item_name,
    items.part_no,
    items.brand,
    items.model,
    items.min_qty,
    items.item_unit,
    items.pay_price,
    items.perch_price, 
    items.item_desc,
    items.item_parcode,
    items.aliasEn,
    items.tax,
    items.imgUrl   
    FROM
    ' . $this->table . '
     WHERE
     items.item_name != "" 
    '; 
        //Prepare statement
        $stmt = $this->conn->prepare($query); 
        // Bind pay_id
        $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT); 
        // Execute query
        $stmt->execute();
    
        return $stmt ;
}

public function readBrand() {
  // Create query
  $query = 'SELECT
    DISTINCT items.brand 
    FROM
    ' . $this->table . '
     WHERE
     items.item_name != "" 
    '; 
        //Prepare statement
        $stmt = $this->conn->prepare($query);  
        $stmt->execute(); 
        return $stmt ;
}




public function readStockTest() {
  // Create query
  date_default_timezone_set('Asia/Riyadh');
  $date = date('Y-m-d');
  $query = 'SELECT
    items.id,
    items.item_name,
    items.part_no,
    items.brand,
    items.model,
    items.min_qty,
    items.item_unit,
    items.pay_price,
    items.perch_price, 
    items.item_desc,
    items.item_parcode,
    items.aliasEn,
    items.tax,
    items.imgUrl, 
    IFNULL((SELECT SUM(pay_details.quantity) FROM pay_details INNER JOIN pay ON pay_details.pay_ref = pay.pay_ref  WHERE  pay_details.item_id = items.id AND pay_details.store_id = :store_id AND pay.pay_date <= "2023-01-28" AND pay.yearId = 2), 0) AS salesQuantity ,
    IFNULL((SELECT SUM(perch_details.quantity) FROM perch_details INNER JOIN perch ON perch_details.pay_ref = perch.pay_ref WHERE  perch_details.item_id = items.id AND perch_details.store_id = :store_id AND perch.pay_date <= "2023-01-28" AND perch.yearId = 2), 0) AS perchQuantity,
    IFNULL((SELECT SUM((tswia_details.availQty - tswia_details.qtyReal)) FROM tswia_details INNER JOIN tswia ON tswia_details.pay_ref = tswia.pay_ref WHERE  tswia_details.item_id = items.id AND tswia_details.store_id = :store_id AND tswia.pay_date <= "2023-01-28" AND tswia.yearId = 2), 0) AS tswiaQuantity,
    IFNULL((SELECT SUM(firstq.quantity) FROM firstq WHERE  firstq.item_id = items.id AND firstq.store_id = :store_id ), 0) AS firstQuantity ,
    IFNULL((SELECT MAX(pay.pay_date) FROM pay_details INNER JOIN pay ON pay_details.pay_ref = pay.pay_ref WHERE  pay_details.item_id = items.id AND pay_details.store_id = :store_id ), 0) AS lastSoldDate,
    IFNULL((SELECT MAX(pay_details.quantity) FROM pay_details INNER JOIN pay ON pay_details.pay_ref = pay.pay_ref WHERE  pay_details.item_id = items.id AND pay_details.store_id = :store_id And pay.pay_date = lastSoldDate), 0) AS lastSoldQty
    IFNULL((SELECT  discount_details.perc  FROM dicount_details  WHERE  dicount.item_id = items.id AND dicount.date_to >= ' .$date. ' ), 0) AS dicount
    FROM
    ' . $this->table . '
     WHERE
     items.item_name != "" 
    '; 
        //Prepare statement
        $stmt = $this->conn->prepare($query); 
        // Bind pay_id
        $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT); 
        // Execute query
        $stmt->execute();
    
        return $stmt ;
}
 


    // Get Single Category
  public function read_single(){
    // Create query
    $query = 'SELECT
          id,
        item_name,
        part_no,
        brand,
          model,
        min_qty,
        item_unit,
        pay_price,
        perch_price, 
        item_desc,
        item_parcode,
        aliasEn,
         tax,
   imgUrl, 
        FROM
          ' . $this->table . '
      WHERE id = ?
      LIMIT 0,1';

      //Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind invo_id
      $stmt->bindParam(1, $this->invo_id);

      // Execute query
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);
  
      // set properties
      $this->id = $row['id'];
      $this->item_name = $row['item_name'];
       $this->model = $row['model'];
      $this->part_no = $row['part_no'];
      $this->brand = $row['brand'];
      $this->min_qty = $row['min_qty'];
      $this->item_unit = $row['item_unit'];
      $this->pay_price = $row['pay_price'];
      $this->perch_price = $row['perch_price'];
      $this->item_desc = $row['item_desc']; 
      $this->item_parcode = $row['item_parcode'];
      $this->aliasEn = $row['aliasEn'];
      $this->tax = $row['tax'];
      $this->imgUrl = $row['imgUrl'];
  }

///get group invoice with services only
  
  public function gorupServicesOnly(){
    // Create query
    $query = 'SELECT 
        invoice.invo_id,
        invoice.item_name,
        invoice.item_unit,
        invoice.pay_price,
        invoice.perch_price,
        invoice.total,
        invoice.item_desc,
        invoice.item_parcode,
        invoice.expireDate,
        invoice.status,
        invoice.user_id,
        invoice.device_id,
        invoice.user_name,
        invoice.invo_type ,
         

        FROM
         ' . $this->table . ' 
        WHERE 
        invoice.invo_type = :invo_type AND invoice.perch_price = :perch_price 
        ORDER BY
        invoice.invo_id ASC
        ';

      //Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind invo_id
     
      $stmt->bindParam(':perch_price',  $this->perch_price, PDO::PARAM_STR);
      $stmt->bindParam(':invo_type', $this->invo_type, PDO::PARAM_STR); 

      // Execute query
      $stmt->execute();

      return $stmt ;
     
  }

      // Get group invoices of spacific doctor at date
      public function gorupDoctors(){
        // Create query
        $query = 'SELECT
            invoice.invo_id,
            invoice.item_name,
            invoice.item_unit,
            invoice.pay_price,
            invoice.perch_price,
            invoice.total,
            invoice.item_desc,
            invoice.item_parcode,
            invoice.expireDate,
            invoice.status,
            invoice.user_id,
            invoice.device_id,
            invoice.user_name,
            invoice.invo_type, 
            services.list_ordering,
            services.id

            FROM
             ' . $this->table . ' 
            INNER JOIN  
            services ON invoice.invo_id = services.ptinvo_id
            WHERE 
            invoice.perch_price = :perch_price AND services.serv_type = :serv_type AND services.serv_id = :serv_id
            ORDER BY
            invoice.invo_id ASC
            ';
     
          //Prepare statement
          $stmt = $this->conn->prepare($query); 
          // Bind invo_id 
          $stmt->bindParam(':perch_price',  $this->perch_price, PDO::PARAM_STR);
          $stmt->bindParam(':serv_type', $this->serv_type, PDO::PARAM_STR);
          $stmt->bindParam(':serv_id', $this->serv_id, PDO::PARAM_INT); 
          // Execute query
          $stmt->execute(); 
          return $stmt ; 
      }

      
/// get invoice with detail
public function getInvoiceDetails(){
  // Create query
  $query = 'SELECT
      invoice.invo_id,
      invoice.item_name,
      invoice.item_unit,
      invoice.pay_price,
      invoice.perch_price,
      invoice.total,
      invoice.item_desc,
      invoice.item_parcode,
      invoice.expireDate,
      invoice.status,
      invoice.user_id,
      invoice.device_id,
      invoice.user_name,
      invoice.invo_type, 
      services.list_ordering,
      services.id ,
      services.ptinvo_id ,
      services.serv_desc ,
      services.serv_type ,
      services.serv_price ,
      services.serv_id ,
      invoice.pt_adress
       
      FROM
       ' . $this->table . ' 
      INNER JOIN  
      services ON invoice.invo_id = services.ptinvo_id
      WHERE 
      invoice.invo_id = :invo_id';

    //Prepare statement
    $stmt = $this->conn->prepare($query);

    // Bind invo_id 
    $stmt->bindParam(':invo_id', $this->invo_id, PDO::PARAM_INT);

    // Execute query
    $stmt->execute();

    return $stmt ;
   
}

  // Get group invoices of spacific doctor at date
  public function invoceInDate(){
    // Create query
    $query = 'SELECT
        invoice.invo_id,
        invoice.item_name,
        invoice.item_unit,
        invoice.pay_price,
        invoice.perch_price,
        invoice.total,
        invoice.item_desc,
        invoice.item_parcode,
        invoice.expireDate,
        invoice.status,
        invoice.user_id,
        invoice.device_id,
        invoice.user_name,
        invoice.invo_type ,
        services.serv_price ,
        services.serv_id ,
        services.serv_desc

        FROM
         ' . $this->table . ' 
          INNER JOIN  
          services ON invoice.invo_id = services.ptinvo_id 
        WHERE 
        invoice.perch_price = :perch_price AND services.serv_type = :serv_type
        ORDER BY
        invoice.invo_id ASC
        '; 
      //Prepare statement
      $stmt = $this->conn->prepare($query); 
      // Bind invo_id 
      $stmt->bindParam(':perch_price',  $this->perch_price, PDO::PARAM_STR); 
      $stmt->bindParam(':serv_type',  $this->serv_type, PDO::PARAM_STR); 
      // Execute query
      $stmt->execute(); 
      return $stmt ; 
  }


  // Get group invoices  
      public function invoceBetweenDate(){
        // Create query
        $query = 'SELECT
            invoice.invo_id,
            invoice.item_name,
            invoice.item_unit,
            invoice.pay_price,
            invoice.perch_price,
            invoice.total,
            invoice.item_desc,
            invoice.item_parcode,
            invoice.expireDate,
            invoice.status,
            invoice.user_id,
            invoice.device_id,
            invoice.user_name,
            invoice.invo_type ,
            services.serv_price ,
            services.serv_id ,
            services.serv_desc 
            FROM
             ' . $this->table . '  
             INNER JOIN  
             services ON invoice.invo_id = services.ptinvo_id 
            WHERE 
            invoice.perch_price >= :perch_price1 AND invoice.perch_price <= :perch_price2 AND services.serv_type = :serv_type
            ORDER BY
            invoice.invo_id ASC
            ';
    
          //Prepare statement
          $stmt = $this->conn->prepare($query);
    
          // Bind invo_id
         
          $stmt->bindParam(':perch_price1',  $this->perch_price1, PDO::PARAM_STR);
          $stmt->bindParam(':perch_price2', $this->perch_price2, PDO::PARAM_STR); 
          $stmt->bindParam(':serv_type',  $this->serv_type, PDO::PARAM_STR); 
    
          // Execute query
          $stmt->execute();
    
          return $stmt ;
         
      }


  // Create Category
  public function create() {
    // Create Query
    $query = 'INSERT INTO ' .
    $this->table . '
    SET   
    item_name = :item_name ,
    model = :model ,
    part_no = :part_no ,
    brand = :brand ,
    min_qty = :min_qty ,
     item_unit = :item_unit,
     pay_price = :pay_price, 
     perch_price = :perch_price,
     item_desc = :item_desc,
     item_parcode = :item_parcode ,
     aliasEn = :aliasEn, 
     tax = :tax , 
     imgUrl = :imgUrl  
     ';
      
  // Prepare Statement
  $stmt = $this->conn->prepare($query);

  // Clean data
  $this->item_name = htmlspecialchars(strip_tags($this->item_name));
   $this->model = htmlspecialchars(strip_tags($this->model));
  $this->part_no = htmlspecialchars(strip_tags($this->part_no));
  $this->brand = htmlspecialchars(strip_tags($this->brand));
  $this->min_qty = htmlspecialchars(strip_tags($this->min_qty));
  $this->item_unit = htmlspecialchars(strip_tags($this->item_unit));
  $this->pay_price = htmlspecialchars(strip_tags($this->pay_price));
  $this->perch_price = htmlspecialchars(strip_tags($this->perch_price)); 
  $this->item_desc = htmlspecialchars(strip_tags($this->item_desc));
  $this->item_parcode = htmlspecialchars(strip_tags($this->item_parcode));
  $this->aliasEn = htmlspecialchars(strip_tags($this->aliasEn));
  $this->tax = htmlspecialchars(strip_tags($this->tax));
  $this->imgUrl = htmlspecialchars(strip_tags($this->imgUrl));
 
  
  // Bind data
  $stmt-> bindParam(':item_name', $this->item_name);
   $stmt-> bindParam(':model', $this->model);
  $stmt-> bindParam(':part_no', $this->part_no);
  $stmt-> bindParam(':brand', $this->brand);
  $stmt-> bindParam(':min_qty', $this->min_qty);
  $stmt-> bindParam(':item_unit', $this->item_unit);
  $stmt-> bindParam(':pay_price', $this->pay_price);
  $stmt-> bindParam(':perch_price', $this->perch_price);
  
  $stmt-> bindParam(':item_desc', $this->item_desc);
  $stmt-> bindParam(':item_parcode', $this->item_parcode);
  $stmt-> bindParam(':aliasEn', $this->aliasEn);
  $stmt-> bindParam(':tax', $this->tax);
  $stmt-> bindParam(':imgUrl', $this->imgUrl);

  // Execute query
  if($stmt->execute()) {
    return true;
  }

  // Print error if something goes wrong
  printf("Error: $s.\n", $stmt->error); 
  return false;
  }

  // Update Category
  public function update() {
    // Create Query
     $query = 'UPDATE ' .
      $this->table . '
     SET
     item_name = :item_name , 
      model = :model , 
     part_no = :part_no , 
     brand = :brand , 
     min_qty = :min_qty , 
     item_unit = :item_unit,
     pay_price = :pay_price,
     perch_price = :perch_price, 
     item_desc = :item_desc,
     item_parcode = :item_parcode,
     aliasEn = :aliasEn ,
     tax = :tax ,
      imgUrl = :imgUrl
     WHERE
     id = :id';

  // Prepare Statement
   $stmt = $this->conn->prepare($query);

  // Clean data
   $this->id = htmlspecialchars(strip_tags($this->id));
   $this->item_name = htmlspecialchars(strip_tags($this->item_name));
   $this->model = htmlspecialchars(strip_tags($this->model));
   $this->part_no = htmlspecialchars(strip_tags($this->part_no));
   $this->brand = htmlspecialchars(strip_tags($this->brand));
   $this->min_qty = htmlspecialchars(strip_tags($this->min_qty));
   $this->item_unit = htmlspecialchars(strip_tags($this->item_unit));
   $this->pay_price = htmlspecialchars(strip_tags($this->pay_price));
   $this->perch_price = htmlspecialchars(strip_tags($this->perch_price));
   $this->item_desc = htmlspecialchars(strip_tags($this->item_desc));
   $this->item_parcode = htmlspecialchars(strip_tags($this->item_parcode));
   $this->aliasEn = htmlspecialchars(strip_tags($this->aliasEn));
   $this->tax = htmlspecialchars(strip_tags($this->tax));
  $this->imgUrl = htmlspecialchars(strip_tags($this->imgUrl));

  // Bind data
   $stmt-> bindParam(':id', $this->id);  
  $stmt-> bindParam(':item_name', $this->item_name);
   $stmt-> bindParam(':model', $this->model);
  $stmt-> bindParam(':part_no', $this->part_no);
  $stmt-> bindParam(':brand', $this->brand);
  $stmt-> bindParam(':min_qty', $this->min_qty);
  $stmt-> bindParam(':item_unit', $this->item_unit);
  $stmt-> bindParam(':pay_price', $this->pay_price);
  $stmt-> bindParam(':perch_price', $this->perch_price);
  
  $stmt-> bindParam(':item_desc', $this->item_desc);
  $stmt-> bindParam(':item_parcode', $this->item_parcode);
  $stmt-> bindParam(':aliasEn', $this->aliasEn);
  $stmt-> bindParam(':tax', $this->tax);
  $stmt-> bindParam(':imgUrl', $this->imgUrl);
 

   // Execute query
   if($stmt->execute()) {
    return true;
   }

  // Print error if something goes wrong
    printf("Error: $s.\n", $stmt->error); 
   return false;
  }




  public function increasePrice() {
      // Create Query
      $query = 'UPDATE ' .
        $this->table . '
      SET 
      pay_price = pay_price + :payval,
      perch_price = perch_price + :perchval  
      ';

    // Prepare Statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    
    $this->payval = htmlspecialchars(strip_tags($this->payval));
    $this->perchval = htmlspecialchars(strip_tags($this->perchval));
    


      // Bind data
    
  
      $stmt-> bindParam(':perchval', $this->perchval); 
      $stmt-> bindParam(':payval', $this->payval); 
    

      // Execute query
      if($stmt->execute()) {
        return true;
      }

      // Print error if something goes wrong
        printf("Error: $s.\n", $stmt->error); 
      return false;
  }

  public function decreasePrice() {
        // Create Query
        $query = 'UPDATE ' .
          $this->table . '
        SET 
        pay_price = pay_price - :payval,
        perch_price = perch_price - :perchval  
        ';

      // Prepare Statement
      $stmt = $this->conn->prepare($query);

      // Clean data
    
      $this->payval = htmlspecialchars(strip_tags($this->payval));
      $this->perchval = htmlspecialchars(strip_tags($this->perchval));
      


        // Bind data
      
    
        $stmt-> bindParam(':perchval', $this->perchval); 
        $stmt-> bindParam(':payval', $this->payval); 
      

        // Execute query
        if($stmt->execute()) {
          return true;
        }

        // Print error if something goes wrong
          printf("Error: $s.\n", $stmt->error); 
        return false;
}

  // Delete Category
  public function delete() {
    // Create query
    $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

    // Prepare Statement
    $stmt = $this->conn->prepare($query);

    // clean data
    $this->id = htmlspecialchars(strip_tags($this->id));

    // Bind Data
    $stmt-> bindParam(':id', $this->id);

    // Execute query
    if($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: $s.\n", $stmt->error);

    return false;
    }

    public function truncateItems() {
      // Create query
      $query = 'TRUNCATE TABLE ' . $this->table . ' ';
  
      // Prepare Statement
      $stmt = $this->conn->prepare($query);
  
  
      // Execute query
      if($stmt->execute()) {
        return true;
      }
  
      // Print error if something goes wrong
      printf("Error: $s.\n", $stmt->error);
  
      return false;
      }
  }
