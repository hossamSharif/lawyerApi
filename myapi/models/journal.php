<?php
  class Journal {
    // DB Stuff
    private $conn;
    private $table = 'journal';
    
     
     
    // Properties
    public $j_id;
    public $j_ref;
    public $j_details;
    public $j_type;
    public $invo_ref;
    public $j_desc;
    public $j_date;
    public $store_id;
    public $user_id;
    public $standard_details;
      public $j_pay;
         public $yearId;
 
  public $j_date2;
    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get doctors
    public function read() {
      // Create query
      $query = 'SELECT
        j_id,
        j_ref,
        j_date,
        j_details,
        j_type,
        invo_ref,
        store_id,
        j_desc,
        user_id,
          standard_details,
       j_pay,
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
        j_id,
        j_ref,
        j_date,
        j_details,
        j_type,
        invo_ref,
        store_id,
        j_desc,
        user_id,
        standard_details,
       j_pay,
       yearId
    
          FROM
           ' . $this->table . ' 
          WHERE 
          store_id = :store_id  
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
       j_id,
        j_ref,
        j_date,
        j_details,
        j_type,
        invo_ref,
        store_id,
        j_desc,
        user_id,
        standard_details,
       j_pay ,
       yearId
          FROM
           ' . $this->table . ' 
          WHERE 
          store_id = :store_id  
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
        j_date,
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
      $this->sub_name = $row['j_date'];
      $this->sub_type = $row['sub_type'];
     
  }


 public function getTopSales(){
    // Create query
    $query = 'SELECT  
         j_id,
        j_ref,
        j_date,
        j_details,
        j_type,
        invo_ref,
        store_id,
        j_desc,
        user_id,
        standard_details,
       j_pay,
       yearId
        FROM
         ' . $this->table . ' 
        WHERE 
        store_id = :store_id AND yearId = :yearId
        ORDER BY
        j_date DESC
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
          j_id,
        j_ref,
        j_date,
        j_details,
        j_type,
        invo_ref,
        store_id,
        j_desc,
        user_id,
        standard_details,
       j_pay,
       yearId
        FROM
         ' . $this->table . ' 
        WHERE 
        store_id = :store_id AND yearId = :yearId  AND  j_date = :from
        ORDER BY
         j_date DESC 
        ';
  
      //Prepare statement
      $stmt = $this->conn->prepare($query);
  
      // Bind pay_id
      $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT); 
      $stmt->bindParam(':from', $this->j_date, PDO::PARAM_STR); 
       $stmt->bindParam(':yearId', $this->yearId, PDO::PARAM_INT); 
  
      // Execute query
      $stmt->execute();
  
      return $stmt ;
     
  }
  
  public function getSales2Date(){
    // Create query
    $query = 'SELECT 
           j_id,
        j_ref,
        j_date,
        j_details,
        j_type,
        invo_ref,
        store_id,
        j_desc,
        user_id,
        standard_details,
       j_pay,
       yearId
        FROM
         ' . $this->table . ' 
        WHERE 
        store_id = :store_id AND AND yearId = :yearId AND j_date >= :from AND   j_date <= :to 
        ORDER BY
        j_date DESC
        ';
  
      //Prepare statement
      $stmt = $this->conn->prepare($query);
  
      // Bind pay_id
      $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT); 
      $stmt->bindParam(':from', $this->j_date, PDO::PARAM_STR); 
      $stmt->bindParam(':to', $this->j_date2, PDO::PARAM_STR); 
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
     j_ref = :j_ref ,j_details = :j_details,j_type = :j_type ,invo_ref = :invo_ref ,j_desc = :j_desc ,user_id = :user_id ,j_date = :j_date ,store_id = :store_id,j_pay = :j_pay,standard_details = :standard_details ,yearId = :yearId ';
      
  // Prepare Statement
  $stmt = $this->conn->prepare($query);

   
   


  // Clean data
  $this->j_ref = htmlspecialchars(strip_tags($this->j_ref));
  $this->j_details = htmlspecialchars(strip_tags($this->j_details));
  $this->j_type = htmlspecialchars(strip_tags($this->j_type));
  $this->invo_ref = htmlspecialchars(strip_tags($this->invo_ref));
  $this->j_desc = htmlspecialchars(strip_tags($this->j_desc));
  $this->user_id = htmlspecialchars(strip_tags($this->user_id));
  $this->j_date = htmlspecialchars(strip_tags($this->j_date));
  $this->store_id = htmlspecialchars(strip_tags($this->store_id));
    $this->j_pay = htmlspecialchars(strip_tags($this->j_pay));
  $this->standard_details = htmlspecialchars(strip_tags($this->standard_details));
    $this->yearId = htmlspecialchars(strip_tags($this->yearId));

  // Bind data
  $stmt-> bindParam(':j_ref', $this->j_ref);
  $stmt-> bindParam(':j_details', $this->j_details);
  $stmt-> bindParam(':j_type', $this->j_type);
  $stmt-> bindParam(':invo_ref', $this->invo_ref);
  $stmt-> bindParam(':j_desc', $this->j_desc);
  $stmt-> bindParam(':user_id', $this->user_id);
  $stmt-> bindParam(':j_date', $this->j_date);
  $stmt-> bindParam(':store_id', $this->store_id);
  $stmt-> bindParam(':j_pay', $this->j_pay);
  $stmt-> bindParam(':standard_details', $this->standard_details);
   $stmt-> bindParam(':yearId', $this->yearId);
  
  // Execute query
  if($this->j_ref == '') {
    return true;
  }else{
      if($stmt->execute()) {
    return true;
  }

  // Print error if something goes wrong
  printf("Error: $s.\n", $stmt->error);

  return false; 
  }
 
  }

  // Update Category
  public function update() {
    // Create Query
     $query = 'UPDATE ' .
      $this->table . '
     SET 
     j_ref = :j_ref ,j_details = :j_details,j_type = :j_type ,invo_ref = :invo_ref ,j_desc = :j_desc ,user_id = :user_id ,j_date = :j_date ,store_id = :store_id,j_pay = :j_pay,standard_details = :standard_details,yearId = :yearId
     WHERE
     j_id = :j_id';

  // Prepare Statement
   $stmt = $this->conn->prepare($query);

  // Clean data
   $this->j_id = htmlspecialchars(strip_tags($this->j_id));
   $this->j_ref = htmlspecialchars(strip_tags($this->j_ref));
  $this->j_details = htmlspecialchars(strip_tags($this->j_details));
  $this->j_type = htmlspecialchars(strip_tags($this->j_type));
  $this->invo_ref = htmlspecialchars(strip_tags($this->invo_ref));
  $this->j_desc = htmlspecialchars(strip_tags($this->j_desc));
  $this->user_id = htmlspecialchars(strip_tags($this->user_id));
  $this->j_date = htmlspecialchars(strip_tags($this->j_date));
  $this->store_id = htmlspecialchars(strip_tags($this->store_id));
       $this->j_pay = htmlspecialchars(strip_tags($this->j_pay));
  $this->standard_details = htmlspecialchars(strip_tags($this->standard_details));
   $this->yearId = htmlspecialchars(strip_tags($this->yearId));

  // Bind data
  $stmt-> bindParam(':j_id', $this->j_id);

  $stmt-> bindParam(':j_ref', $this->j_ref);
  $stmt-> bindParam(':j_details', $this->j_details);
  $stmt-> bindParam(':j_type', $this->j_type);
  $stmt-> bindParam(':invo_ref', $this->invo_ref);
  $stmt-> bindParam(':j_desc', $this->j_desc);
  $stmt-> bindParam(':user_id', $this->user_id);
  $stmt-> bindParam(':j_date', $this->j_date);
  $stmt-> bindParam(':store_id', $this->store_id);
   $stmt-> bindParam(':yearId', $this->yearId);
$stmt-> bindParam(':j_pay', $this->j_pay);
  $stmt-> bindParam(':standard_details', $this->standard_details);
 

   // Execute query
   if($stmt->execute()) {
    return true;
   }

  // Print error if something goes wrong
    printf("Error: $s.\n", $stmt->error);

   return false;
  }


  public function deleteMultiServices() {
    // Create query
    $query = 'DELETE FROM ' . $this->table . ' WHERE j_ref = :j_ref';
  
    // Prepare Statement
    $stmt = $this->conn->prepare($query);
  
    // clean data
    $this->pay_ref = htmlspecialchars(strip_tags($this->j_ref));
  
    // Bind Data
    $stmt-> bindParam(':j_ref', $this->j_ref);
  
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
    $query = 'DELETE FROM ' . $this->table . ' WHERE j_id = :j_id';

    // Prepare Statement
    $stmt = $this->conn->prepare($query);

    // clean data
    $this->id = htmlspecialchars(strip_tags($this->id));

    // Bind Data
    $stmt-> bindParam(':j_id', $this->j_id);

    // Execute query
    if($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: $s.\n", $stmt->error);

    return false;
    }
  }
