<?php
  class Nursing {
    // DB Stuff
    private $conn;
    private $table = 'nursing';

    // Properties
    public $nurs_id;
    public $nurs_desc;
    public $nurs_price;
   

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get doctors
    public function read() {
      // Create query
      $query = 'SELECT
        nurs_id,
        nurs_desc,
        nurs_price
        
      FROM
        ' . $this->table . '
      ORDER BY
        nurs_id DESC';

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
          nurs_id,
        nurs_desc,
        nurs_price  
        FROM
          ' . $this->table . '
      WHERE nurs_id = ?
      LIMIT 0,1';

      //Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind nurs_id
      $stmt->bindParam(1, $this->nurs_id);

      // Execute query
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // set properties
      $this->nurs_id = $row['nurs_id'];
      $this->nurs_desc = $row['nurs_desc'];
      $this->nurs_price = $row['nurs_price'];
     
  }

  // Create Category
  public function create() {
    // Create Query
    $query = 'INSERT INTO ' .
      $this->table . '
    SET
    nurs_desc = :nurs_desc ,nurs_price = :nurs_price';
      
  // Prepare Statement
  $stmt = $this->conn->prepare($query);

  // Clean data
  $this->nurs_desc = htmlspecialchars(strip_tags($this->nurs_desc));
  $this->nurs_price = htmlspecialchars(strip_tags($this->nurs_price));
  

  // Bind data
  $stmt-> bindParam(':nurs_desc', $this->nurs_desc);
  $stmt-> bindParam(':nurs_price', $this->nurs_price);
  
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
     nurs_desc = :nurs_desc , 
     nurs_price = :nurs_price
     WHERE
     nurs_id = :nurs_id';

  // Prepare Statement
   $stmt = $this->conn->prepare($query);

  // Clean data
   $this->nurs_id = htmlspecialchars(strip_tags($this->nurs_id));
   $this->nurs_desc = htmlspecialchars(strip_tags($this->nurs_desc));
   $this->nurs_price = htmlspecialchars(strip_tags($this->nurs_price));
   
  

  // Bind data
   $stmt-> bindParam(':nurs_id', $this->nurs_id); 
   $stmt-> bindParam(':nurs_desc', $this->nurs_desc);
   $stmt-> bindParam(':nurs_price', $this->nurs_price);
 

 

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
    $query = 'DELETE FROM ' . $this->table . ' WHERE nurs_id = :nurs_id';

    // Prepare Statement
    $stmt = $this->conn->prepare($query);

    // clean data
    $this->nurs_id = htmlspecialchars(strip_tags($this->nurs_id));

    // Bind Data
    $stmt-> bindParam(':nurs_id', $this->nurs_id);

    // Execute query
    if($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: $s.\n", $stmt->error);

    return false;
    }
  }
