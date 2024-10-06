<?php
  class Invoices {
    // DB Stuff
    private $conn;
    private $table = 'invoices';
    

     
    // Properties
    public $rec_id;
    public $rec_ref;
    public $rec_type;
    public $rec_date;
    public $rec_detailes;
    public $rec_pay;
    public $ac_id;
    public $store_id;
    public $user_id;
    public $yearId;
    
    public $rec_date2;
    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get doctors
    public function read() {
      // Create query
      $query = 'SELECT
        rec_id,
        rec_ref,
        ac_id,
        rec_type,
        rec_date,
        rec_detailes,
        store_id,
        rec_pay,
        user_id ,
        yearId
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

    public function readByStore(){
      // Create query
      $query = 'SELECT 
        rec_id,
        rec_ref,
        ac_id,
        rec_type,
        rec_date,
        rec_detailes,
        store_id,
        rec_pay,
        user_id,
        yearId 
          FROM
           ' . $this->table . ' 
          WHERE 
          store_id = :store_id  AND yearId = :yearId
          ORDER BY
          id ASC
          ';
    
        //Prepare statement
        $stmt = $this->conn->prepare($query);
    
        // Bind pay_id
        $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT); 
        $stmt->bindParam(':yearId', $this->yearId, PDO::PARAM_INT);
        // Execute query
        $stmt->execute(); 
        return $stmt ;
       
    }


    public function readAllStore(){
      // readAllStore excep purch and sales
      $query = 'SELECT 
        id,
        sub_name,
        ac_id,
        sub_type,
        sub_code,
        sub_balance,
        store_id ,
        yearId
          FROM
           ' . $this->table . ' 
          WHERE 
          store_id = :store_id AND yearId = :yearId  AND ac_id != 1  AND ac_id != 2 
          ORDER BY
          id ASC
          ';
    
        //Prepare statement
        $stmt = $this->conn->prepare($query);
    
        // Bind pay_id
        $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT);  
         $stmt->bindParam(':yearId', $this->yearId, PDO::PARAM_INT); 
        // Execute query
        $stmt->execute();
    
        return $stmt ;
       
    }

    // Get Single Category
  public function read_single(){
    // Create query
    $query = 'SELECT
          id,
          sub_name,
        ac_id,
        sub_type  
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
      $this->sub_name = $row['sub_name'];
      $this->sub_name = $row['ac_id'];
      $this->sub_type = $row['sub_type'];
     
  }

 
  public function getTopSales(){
    // Create query
    $query = 'SELECT 
          rec_id,
        rec_ref,
        ac_id,
        rec_type,
        rec_date,
        rec_detailes,
        store_id,
        rec_pay,
        user_id,
        yearId
        FROM
         ' . $this->table . ' 
        WHERE 
        store_id = :store_id AND yearId = :yearId
        ORDER BY
        rec_date DESC
        LIMIT 40
        ';
  
      //Prepare statement
      $stmt = $this->conn->prepare($query);
  
      // Bind pay_id
      $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT); 
      $stmt->bindParam(':yearId', $this->yearId, PDO::PARAM_INT); 
  
      // Execute query
      $stmt->execute();
  
      return $stmt ;
     
  }
  
  public function getSalesByDate(){
    // Create query
    $query = 'SELECT 
           rec_id,
        rec_ref,
        ac_id,
        rec_type,
        rec_date,
        rec_detailes,
        store_id,
        rec_pay,
        user_id 
        yearId
        FROM
         ' . $this->table . ' 
        WHERE 
        store_id = :store_id AND yearId = :yearId  AND  rec_date = :from
        ORDER BY
         rec_date DESC
         LIMIT 40
        ';
  
      //Prepare statement
      $stmt = $this->conn->prepare($query);
  
      // Bind pay_id
      $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT); 
      $stmt->bindParam(':from', $this->rec_date, PDO::PARAM_STR); 
       $stmt->bindParam(':yearId', $this->yearId, PDO::PARAM_INT); 
  
      // Execute query
      $stmt->execute();
  
      return $stmt ;
     
  }
  
  public function getSales2Date(){
    // Create query
    $query = 'SELECT 
           rec_id,
        rec_ref,
        ac_id,
        rec_type,
        rec_date,
        rec_detailes,
        store_id,
        rec_pay,
        user_id,
        
        FROM
         ' . $this->table . ' 
        WHERE 
        store_id = :store_id AND  yearId = :yearId AND rec_date >= :from AND   rec_date <= :to 
        ORDER BY
        rec_date DESC
        LIMIT 40
        ';
  
      //Prepare statement
      $stmt = $this->conn->prepare($query);
  
      // Bind pay_id
      $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT); 
      $stmt->bindParam(':from', $this->rec_date, PDO::PARAM_STR); 
      $stmt->bindParam(':to', $this->rec_date2, PDO::PARAM_STR); 
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
     rec_ref = :rec_ref ,rec_type = :rec_type,rec_date = :rec_date ,rec_detailes = :rec_detailes ,rec_pay = :rec_pay ,user_id = :user_id ,ac_id = :ac_id ,store_id = :store_id,yearId = :yearId';
      
  // Prepare Statement
  $stmt = $this->conn->prepare($query);

   
   


  // Clean data
  $this->rec_ref = htmlspecialchars(strip_tags($this->rec_ref));
  $this->rec_type = htmlspecialchars(strip_tags($this->rec_type));
  $this->rec_date = htmlspecialchars(strip_tags($this->rec_date));
  $this->rec_detailes = htmlspecialchars(strip_tags($this->rec_detailes));
  $this->rec_pay = htmlspecialchars(strip_tags($this->rec_pay));
  $this->user_id = htmlspecialchars(strip_tags($this->user_id));
  $this->ac_id = htmlspecialchars(strip_tags($this->ac_id));
  $this->store_id = htmlspecialchars(strip_tags($this->store_id));
   $this->yearId = htmlspecialchars(strip_tags($this->yearId));
  

  // Bind data
  $stmt-> bindParam(':rec_ref', $this->rec_ref);
  $stmt-> bindParam(':rec_type', $this->rec_type);
  $stmt-> bindParam(':rec_date', $this->rec_date);
  $stmt-> bindParam(':rec_detailes', $this->rec_detailes);
  $stmt-> bindParam(':rec_pay', $this->rec_pay);
  $stmt-> bindParam(':user_id', $this->user_id);
  $stmt-> bindParam(':ac_id', $this->ac_id);
  $stmt-> bindParam(':store_id', $this->store_id);
  $stmt-> bindParam(':yearId', $this->yearId);
  
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
     SET 
     rec_ref = :rec_ref ,rec_type = :rec_type,rec_date = :rec_date ,rec_detailes = :rec_detailes ,rec_pay = :rec_pay ,user_id = :user_id ,ac_id = :ac_id ,store_id = :store_id ,yearId = :yearId
     WHERE
     rec_id = :rec_id';

  // Prepare Statement
   $stmt = $this->conn->prepare($query);

  // Clean data
   $this->rec_id = htmlspecialchars(strip_tags($this->rec_id));
   $this->rec_ref = htmlspecialchars(strip_tags($this->rec_ref));
  $this->rec_type = htmlspecialchars(strip_tags($this->rec_type));
  $this->rec_date = htmlspecialchars(strip_tags($this->rec_date));
  $this->rec_detailes = htmlspecialchars(strip_tags($this->rec_detailes));
  $this->rec_pay = htmlspecialchars(strip_tags($this->rec_pay));
  $this->user_id = htmlspecialchars(strip_tags($this->user_id));
  $this->ac_id = htmlspecialchars(strip_tags($this->ac_id));
  $this->store_id = htmlspecialchars(strip_tags($this->store_id));
    $this->yearId = htmlspecialchars(strip_tags($this->yearId)); 
  

  // Bind data
  $stmt-> bindParam(':rec_id', $this->rec_id);

  $stmt-> bindParam(':rec_ref', $this->rec_ref);
  $stmt-> bindParam(':rec_type', $this->rec_type);
  $stmt-> bindParam(':rec_date', $this->rec_date);
  $stmt-> bindParam(':rec_detailes', $this->rec_detailes);
  $stmt-> bindParam(':rec_pay', $this->rec_pay);
  $stmt-> bindParam(':user_id', $this->user_id);
  $stmt-> bindParam(':ac_id', $this->ac_id);
  $stmt-> bindParam(':store_id', $this->store_id);
  $stmt-> bindParam(':yearId', $this->yearId);

 

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
    $query = 'DELETE FROM ' . $this->table . ' WHERE rec_id = :rec_id';

    // Prepare Statement
    $stmt = $this->conn->prepare($query);

    // clean data
    $this->id = htmlspecialchars(strip_tags($this->id));

    // Bind Data
    $stmt-> bindParam(':rec_id', $this->rec_id);

    // Execute query
    if($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: $s.\n", $stmt->error);

    return false;
    }
  }
