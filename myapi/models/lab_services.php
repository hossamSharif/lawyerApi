<?php
  class Lab_services {
    // DB Stuff
    private $conn;
    private $table = 'lab_services';

    // Properties
    public $labserv_id;
    public $labserv_desc;
    public $labserv_price;
   

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get doctors
    public function read() {
      // Create query
      $query = 'SELECT
        labserv_id,
        labserv_desc,
        labserv_price
        
      FROM
        ' . $this->table . '
      ORDER BY
        labserv_id DESC';

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
          labserv_id,
        labserv_desc,
        labserv_price  
        FROM
          ' . $this->table . '
      WHERE labserv_id = ?
      LIMIT 0,1';

      //Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind labserv_id
      $stmt->bindParam(1, $this->labserv_id);

      // Execute query
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // set properties
      $this->labserv_id = $row['labserv_id'];
      $this->labserv_desc = $row['labserv_desc'];
      $this->labserv_price = $row['labserv_price'];
     
  }

  // Create Category
  public function create() {
    // Create Query
    $query = 'INSERT INTO ' .
      $this->table . '
    SET
    labserv_desc = :labserv_desc ,labserv_price = :labserv_price';
      
  // Prepare Statement
  $stmt = $this->conn->prepare($query);

  // Clean data
  $this->labserv_desc = htmlspecialchars(strip_tags($this->labserv_desc));
  $this->labserv_price = htmlspecialchars(strip_tags($this->labserv_price));
  

  // Bind data
  $stmt-> bindParam(':labserv_desc', $this->labserv_desc);
  $stmt-> bindParam(':labserv_price', $this->labserv_price);
  
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
     labserv_desc = :labserv_desc , 
     labserv_price = :labserv_price
     WHERE
     labserv_id = :labserv_id';

  // Prepare Statement
   $stmt = $this->conn->prepare($query);

  // Clean data
   $this->labserv_id = htmlspecialchars(strip_tags($this->labserv_id));
   $this->labserv_desc = htmlspecialchars(strip_tags($this->labserv_desc));
   $this->labserv_price = htmlspecialchars(strip_tags($this->labserv_price));
   
  

  // Bind data
   $stmt-> bindParam(':labserv_id', $this->labserv_id); 
   $stmt-> bindParam(':labserv_desc', $this->labserv_desc);
   $stmt-> bindParam(':labserv_price', $this->labserv_price);
 

 

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
    $query = 'DELETE FROM ' . $this->table . ' WHERE labserv_id = :labserv_id';

    // Prepare Statement
    $stmt = $this->conn->prepare($query);

    // clean data
    $this->labserv_id = htmlspecialchars(strip_tags($this->labserv_id));

    // Bind Data
    $stmt-> bindParam(':labserv_id', $this->labserv_id);

    // Execute query
    if($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: $s.\n", $stmt->error);

    return false;
    }
  }
