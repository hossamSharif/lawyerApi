<?php
  class Discount_details {
    // DB Stuff
    private $conn;
    private $table = 'discount_details';
  
    // Properties
    public $id;
    public $perc;
    public $from_date;
    public $to_date;
    public $discount_id; 
    public $item_id;

    public $dateCreated;
    public $perch_price; 
    public $pay_date; 
    public $cust_id; 
     public $yearId; 
      public $brand; 
      public $model; 
      public $tax; 
    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get doctors
    public function read() {
      // Create query
      $query = 'SELECT
        id,
        perc,
        from_date,
        to_date,
        discount_id,
        tot,
        store_id,
        item_id,
        dateCreated ,
        perch_price,
        yearId ,
          tax 

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

    // Get Single Category
  public function read_single(){
    // Create query
    $query = 'SELECT
          id,
        perc,
        from_date,
        to_date,
        discount_id,
        tot,
        store_id,
        dateCreated,
        yearId,
        tax 

        FROM
          ' . $this->table . '
      WHERE id = ?
      LIMIT 0,1';

      //Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind id
      $stmt->bindParam(1, $this->id);

      // Execute query
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // set properties
      $this->id = $row['id'];
      $this->perc = $row['perc'];
      $this->from_date = $row['from_date'];
      $this->to_date = $row['to_date'];
      $this->discount_id = $row['discount_id'];
      $this->discount_id = $row['tot']; 
      $this->store_id = $row['store_id']; 
      $this->dateCreated = $row['dateCreated']; 
      $this->yearId = $row['yearId']; 
      $this->tax = $row['tax']; 
  }

  /// read for spacific branch store
public function readByDiscount(){
  // Create query
  $query = 'SELECT 
        id,
        perc,
        from_date,
        to_date,
        discount_id, 
        item_id 

      FROM
       ' . $this->table . ' 
      WHERE 
      discount_id = :discount_id 
      ORDER BY
      id ASC
      ';

    //Prepare statement
    $stmt = $this->conn->prepare($query);

    // Bind pay_id
    $stmt->bindParam(':discount_id', $this->discount_id, PDO::PARAM_INT); 
    

    // Execute query
    $stmt->execute();

    return $stmt ;
   
}




  public function readAllByStore(){
    // Create query
    $query = 'SELECT 
          id,
          perc,
          from_date,
          to_date,
          discount_id,
          tot,
          store_id,
          item_id,
          dateCreated ,
          perch_price ,
          yearId ,
          tax
        FROM
         ' . $this->table . ' 
        WHERE 
        store_id = :store_id AND yearId = :yearId AND yearId = :yearId AND from_date != ""
        ORDER BY
        id ASC
        ';
  
      //Prepare statement
      $stmt = $this->conn->prepare($query);
  
      // Bind pay_id
      $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT);
        $stmt->bindParam(':yearId', $this->yearId, PDO::PARAM_INT); 
      $stmt->bindParam(':yearId', $this->yearId, PDO::PARAM_INT); 
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
    perc = :perc ,from_date = :from_date, to_date = :to_date, discount_id = :discount_id, tot = :tot, store_id = :store_id, dateCreated = :dateCreated, yearId = :yearId, tax = :tax';
//    VALUES (NULL,:perc,:from_date,:to_date,:discount_id,:tot,:store_id,:dateCreated)';
  // Prepare Statement
  $stmt = $this->conn->prepare($query);

  // Clean data
  $this->perc = htmlspecialchars(strip_tags($this->perc));
  $this->from_date = htmlspecialchars(strip_tags($this->from_date));
  $this->to_date = htmlspecialchars(strip_tags($this->to_date));
  $this->discount_id = htmlspecialchars(strip_tags($this->discount_id));
  $this->tot = htmlspecialchars(strip_tags($this->tot));
  $this->store_id = htmlspecialchars(strip_tags($this->store_id));
  $this->dateCreated = htmlspecialchars(strip_tags($this->dateCreated));
  $this->perch_price = htmlspecialchars(strip_tags($this->perch_price));
  $this->yearId = htmlspecialchars(strip_tags($this->yearId));
  $this->tax = htmlspecialchars(strip_tags($this->tax));

  // Bind data
  $stmt-> bindParam(':perc', $this->perc);
  $stmt-> bindParam(':from_date', $this->from_date);
  $stmt-> bindParam(':to_date', $this->to_date);
  $stmt-> bindParam(':discount_id', $this->discount_id);
  $stmt-> bindParam(':tot', $this->tot);
  $stmt-> bindParam(':store_id', $this->store_id);
  $stmt-> bindParam(':dateCreated', $this->dateCreated);
  $stmt-> bindParam(':perch_price', $this->perch_price);
  $stmt-> bindParam(':yearId', $this->yearId);
  $stmt-> bindParam(':tax', $this->tax);

  // Execute query
  if($stmt->execute()) {
    return true;
  }

  // Print error if something goes wrong
  printf("Error: $s.\n", $stmt->error);

  return false;
  }




 public function readAllByModelAndBrand(){
    // Create query
    $query = 'SELECT 
          pay_details.id,
          pay_details.perc,
          pay_details.from_date,
          pay_details.to_date,
          pay_details.discount_id,
          pay_details.tot,
          pay_details.store_id,
          pay_details.item_id,
          pay_details.dateCreated ,
          pay_details.perch_price ,
          pay.cust_id ,
          pay.pay_date ,
          pay.tot_pr, 
          pay.pay_time, 
          pay.discount,
          pay.changee,
          pay.user_id, 
          pay.pay, 
          pay.pay_method,
          pay_details.yearId,
          pay_details.tax,
          IFNULL((SELECT sub_name FROM sub_accounts WHERE  sub_accounts.id =  pay.cust_id), 0) AS sub_name 
        FROM
         ' . $this->table . '  INNER JOIN pay ON pay_details.perc = pay.perc INNER JOIN items ON pay_details.item_id = items.id 
        WHERE 
        pay_details.store_id = :store_id AND pay_details.yearId = :yearId AND items.brand= :brand AND items.model= :model 
        ORDER BY
          pay.pay_date DESC
        '; 
  
      //Prepare statement
      $stmt = $this->conn->prepare($query);
  
      // Bind pay_id
      
      $stmt->bindParam(':brand', $this->brand, PDO::PARAM_STR);
        $stmt->bindParam(':model', $this->model, PDO::PARAM_STR);
      $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT); 
       $stmt->bindParam(':yearId', $this->yearId, PDO::PARAM_INT); 
  
      // Execute query
     if($stmt->execute()) {
    return true;
  }

  // Print error if something goes wrong
  printf("Error: $s.\n", $stmt->error);

  return false;
     
  }

  public function readAllByBrand(){
    // Create query
    $query = 'SELECT 
          pay_details.id,
          pay_details.perc,
          pay_details.from_date,
          pay_details.to_date,
          pay_details.discount_id,
          pay_details.tot,
          pay_details.store_id,
          pay_details.item_id,
          pay_details.dateCreated ,
          pay_details.perch_price ,
          pay.cust_id ,
          pay.pay_date ,
          pay.tot_pr, 
          pay.pay_time, 
          pay.discount,
          pay.changee,
          pay.user_id, 
          pay.pay, 
          pay.pay_method,
          pay_details.yearId,
          pay_details.tax,
          IFNULL((SELECT sub_name FROM sub_accounts WHERE  sub_accounts.id =  pay.cust_id), 0) AS sub_name 
        FROM
         ' . $this->table . '  INNER JOIN pay ON pay_details.perc = pay.perc INNER JOIN items ON pay_details.item_id = items.id 
        WHERE 
        pay_details.store_id = :store_id AND pay_details.yearId = :yearId AND items.brand = :brand 
        ORDER BY
          pay.pay_date DESC
        '; 
  
      //Prepare statement
      $stmt = $this->conn->prepare($query);
  
      // Bind pay_id
      
      $stmt->bindParam(':brand', $this->brand, PDO::PARAM_STR); 
      $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT); 
       $stmt->bindParam(':yearId', $this->yearId, PDO::PARAM_INT); 
  
      // Execute query
      $stmt->execute();
  
      return $stmt ;
     
  }
  
   public function readAllByModel(){
    // Create query
    $query = 'SELECT 
          pay_details.id,
          pay_details.perc,
          pay_details.from_date,
          pay_details.to_date,
          pay_details.discount_id,
          pay_details.tot,
          pay_details.store_id,
          pay_details.item_id,
          pay_details.dateCreated ,
          pay_details.perch_price ,
          pay.cust_id ,
          pay.pay_date ,
          pay.tot_pr, 
          pay.pay_time, 
          pay.discount,
          pay.changee,
          pay.user_id, 
          pay.pay, 
          pay.pay_method,
          pay_details.yearId,
          pay_details.tax,
          IFNULL((SELECT sub_name FROM sub_accounts WHERE  sub_accounts.id =  pay.cust_id), 0) AS sub_name 
        FROM
         ' . $this->table . '  INNER JOIN pay ON pay_details.perc = pay.perc INNER JOIN items ON pay_details.item_id = items.id 
        WHERE 
        pay_details.store_id = :store_id AND pay_details.yearId = :yearId AND items.model= :model 
        ORDER BY
          pay.pay_date DESC
        '; 
  
      //Prepare statement
      $stmt = $this->conn->prepare($query);
  
      // Bind pay_id
      
      $stmt->bindParam(':model', $this->model, PDO::PARAM_STR); 
      $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT); 
       $stmt->bindParam(':yearId', $this->yearId, PDO::PARAM_INT); 
  
      // Execute query
      $stmt->execute();
  
      return $stmt ;
     
  }



   public function readAllByItemId(){
    // Create query
    $query = 'SELECT 
          pay_details.id,
          pay_details.perc,
          pay_details.from_date,
          pay_details.to_date,
          pay_details.discount_id,
          pay_details.tot,
          pay_details.store_id,
          pay_details.item_id,
          pay_details.dateCreated ,
          pay_details.perch_price ,
          pay.cust_id ,
          pay.pay_date ,
          pay.tot_pr, 
           pay.pay_time, 
          pay.discount,
          pay.changee,
          pay.user_id, 
          pay.pay, 
          pay.pay_method,
          pay_details.yearId,
          pay_details.tax,
          IFNULL((SELECT sub_name FROM sub_accounts WHERE  sub_accounts.id =  pay.cust_id), 0) AS sub_name 
        FROM
         ' . $this->table . '  INNER JOIN pay ON pay_details.perc = pay.perc
        WHERE 
        pay_details.store_id = :store_id AND pay_details.yearId = :yearId AND pay_details.item_id= :item_id 
        ORDER BY
          pay.pay_date DESC
        ';
  
      //Prepare statement
      $stmt = $this->conn->prepare($query);
  
      // Bind pay_id
      
      $stmt->bindParam(':item_id', $this->item_id, PDO::PARAM_INT); 
      $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT); 
       $stmt->bindParam(':yearId', $this->yearId, PDO::PARAM_INT); 
  
      // Execute query
      $stmt->execute();
  
      return $stmt ;
     
  }


 public function readAllByDate(){
    // Create query
    $query = 'SELECT 
          pay_details.id,
          pay_details.perc,
          pay_details.from_date,
          pay_details.to_date,
          pay_details.discount_id,
          pay_details.tot,
          pay_details.store_id,
          pay_details.item_id,
          pay_details.dateCreated ,
          pay_details.perch_price ,
          pay.cust_id ,
          pay.pay_date ,
           pay.tot_pr, 
          pay.pay_time, 
          pay.discount,
          pay.changee,
          pay.user_id, 
          pay.pay, 
          pay.pay_method,
          pay_details.yearId,
        pay_details.tax,
         IFNULL((SELECT sub_name FROM sub_accounts WHERE  sub_accounts.id =  pay.cust_id), 0) AS sub_name 
        FROM
         ' . $this->table . '  INNER JOIN pay ON pay_details.perc = pay.perc
        WHERE 
        pay_details.store_id = :store_id AND pay_details.yearId = :yearId  AND pay.pay_date = :from 
        ORDER BY
          pay.pay_date DESC
        ';
  
      //Prepare statement
      $stmt = $this->conn->prepare($query);
  
      // Bind pay_id
      $stmt->bindParam(':from', $this->pay_date, PDO::PARAM_STR); 
      $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT); 
      $stmt->bindParam(':yearId', $this->yearId, PDO::PARAM_INT); 
  
      // Execute query
      $stmt->execute();
  
      return $stmt ;
     
  }

  public function readAllByItemIdDate(){
    // Create query
    $query = 'SELECT 
          pay_details.id,
          pay_details.perc,
          pay_details.from_date,
          pay_details.to_date,
          pay_details.discount_id,
          pay_details.tot,
          pay_details.store_id,
          pay_details.item_id,
          pay_details.dateCreated ,
          pay_details.perch_price ,
          pay.cust_id ,
          pay.pay_date ,
           pay.tot_pr, 
          pay.pay_time, 
          pay.discount,
          pay.changee,
          pay.user_id, 
          pay.pay, 
          pay.pay_method,
          pay_details.yearId,
        pay_details.tax,
         IFNULL((SELECT sub_name FROM sub_accounts WHERE  sub_accounts.id =  pay.cust_id), 0) AS sub_name 
        FROM
         ' . $this->table . '  INNER JOIN pay ON pay_details.perc = pay.perc
        WHERE 
        pay_details.store_id = :store_id AND pay_details.yearId = :yearId AND pay_details.item_id= :item_id AND pay.pay_date = :from 
        ORDER BY
          pay.pay_date DESC
        ';
  
      //Prepare statement
      $stmt = $this->conn->prepare($query);
  
      // Bind pay_id
      $stmt->bindParam(':from', $this->pay_date, PDO::PARAM_STR); 
      $stmt->bindParam(':item_id', $this->item_id, PDO::PARAM_INT); 
      $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT); 
      $stmt->bindParam(':yearId', $this->yearId, PDO::PARAM_INT); 
  
      // Execute query
      $stmt->execute();
  
      return $stmt ;
     
  }

  public function readAllByItemId2Date(){
    // Create query
    $query = 'SELECT 
          pay_details.id,
          pay_details.perc,
          pay_details.from_date,
          pay_details.to_date,
          pay_details.discount_id,
          pay_details.tot,
          pay_details.store_id,
          pay_details.item_id,
          pay_details.dateCreated ,
          pay_details.perch_price ,
          pay.cust_id ,
          pay.pay_date ,
           pay.tot_pr, 
          pay.pay_time, 
          pay.discount,
          pay.changee,
          pay.user_id, 
          pay.pay, 
          pay.pay_method,
          pay_details.yearId,
          pay_details.tax,
         IFNULL((SELECT sub_name FROM sub_accounts WHERE  sub_accounts.id =  pay.cust_id), 0) AS sub_name 
        FROM
         ' . $this->table . '  INNER JOIN pay ON pay_details.perc = pay.perc
        WHERE 
        pay_details.store_id = :store_id AND pay_details.yearId = :yearId  AND pay_details.item_id= :item_id AND (pay.pay_date BETWEEN :from AND :to)
        ORDER BY
          pay.pay_date DESC
        ';
  
      //Prepare statement
      $stmt = $this->conn->prepare($query);
  
      // Bind pay_id
      $stmt->bindParam(':from', $this->pay_date, PDO::PARAM_STR); 
      $stmt->bindParam(':to', $this->pay_date2, PDO::PARAM_STR); 
      $stmt->bindParam(':item_id', $this->item_id, PDO::PARAM_INT); 
      $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT); 
       $stmt->bindParam(':yearId', $this->yearId, PDO::PARAM_INT); 
      
      // Execute query
      $stmt->execute();
  
      return $stmt ;
     
  }
//// create multi record 
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

  // reordering service 
  public function reorder() {
    // Create Query
     $query = 'UPDATE ' . $this->table . '
     SET 
     tot = :tot 
     WHERE
     id = :id';

  // Prepare Statement
   $stmt = $this->conn->prepare($query);

  // Clean data
   $this->id = htmlspecialchars(strip_tags($this->id));
  
   $this->tot = htmlspecialchars(strip_tags($this->tot));
  
  // Bind data
   $stmt-> bindParam(':id', $this->id);  
   $stmt-> bindParam(':tot', $this->tot);
  

 

   // Execute query
   if($stmt->execute()) {
    return true;
   }

  // Print error if something goes wrong
    printf("Error: $s.\n", $stmt->error);

   return false;
  }

  public function update() {
    // Create Query
     $query = 'UPDATE ' .
      $this->table . '
     SET
     perc = :perc , 
     from_date = :from_date,
     to_date = :to_date,
     discount_id = :discount_id,
     tot = :tot,
     store_id = :store_id,
     dateCreated = :dateCreated,
     yearId = :yearId
     tax = :tax
     WHERE
     id = :id';

  // Prepare Statement
   $stmt = $this->conn->prepare($query);

  // Clean data
   $this->id = htmlspecialchars(strip_tags($this->id));
   $this->perc = htmlspecialchars(strip_tags($this->perc));
   $this->from_date = htmlspecialchars(strip_tags($this->from_date));
   $this->to_date = htmlspecialchars(strip_tags($this->to_date));
   $this->discount_id = htmlspecialchars(strip_tags($this->discount_id));
   $this->tot = htmlspecialchars(strip_tags($this->tot));
   $this->store_id = htmlspecialchars(strip_tags($this->store_id));
   $this->dateCreated = htmlspecialchars(strip_tags($this->dateCreated));
   $this->yearId = htmlspecialchars(strip_tags($this->yearId));
   $this->tax = htmlspecialchars(strip_tags($this->tax));

  // Bind data
   $stmt-> bindParam(':id', $this->id); 
   $stmt-> bindParam(':perc', $this->perc);
   $stmt-> bindParam(':from_date', $this->from_date);
   $stmt-> bindParam(':to_date', $this->to_date);
   $stmt-> bindParam(':discount_id', $this->discount_id);
   $stmt-> bindParam(':tot', $this->tot);
   $stmt-> bindParam(':store_id', $this->store_id);
   $stmt-> bindParam(':dateCreated', $this->dateCreated);
   $stmt-> bindParam(':yearId', $this->yearId);
   $stmt-> bindParam(':tax', $this->tax);

 

   // Execute query
   if($stmt->execute()) {
    return true;
   }

  // Print error if something goes wrong
    printf("Error: $s.\n", $stmt->error);

   return false;
  }

// delete multi services
public function deleteMultiServices() {
  // Create query
  $query = 'DELETE FROM ' . $this->table . ' WHERE perc = :perc';

  // Prepare Statement
  $stmt = $this->conn->prepare($query);

  // clean data
  $this->perc = htmlspecialchars(strip_tags($this->perc));

  // Bind Data
  $stmt-> bindParam(':perc', $this->perc);

  // Execute query
  if($stmt->execute()) {
    return true;
  }

  // Print error if something goes wrong
  printf("Error: $s.\n", $stmt->error);

  return false;
  }
 

 
// Delete services
  public function delete() {
    // Create query
    $query = 'DELETE FROM ' . $this->table . ' WHERE perc = :perc';

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
  }
