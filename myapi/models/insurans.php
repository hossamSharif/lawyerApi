<?php
  class Insurans {
    // DB Stuff
    private $conn;
    private $table = 'insurans';

    // Properties
    public $insur_id;
    public $insur_desc;
    public $insur_price;
   

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get doctors
    public function read() {
      // Create query
      $query = 'SELECT
        insur_id,
        insur_desc,
        insur_price
        
      FROM
        ' . $this->table . '
      ORDER BY
        insur_id DESC';

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
          insur_id,
        insur_desc,
        insur_price  
        FROM
          ' . $this->table . '
      WHERE insur_id = ?
      LIMIT 0,1';

      //Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind insur_id
      $stmt->bindParam(1, $this->insur_id);

      // Execute query
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // set properties
      $this->insur_id = $row['insur_id'];
      $this->insur_desc = $row['insur_desc'];
      $this->insur_price = $row['insur_price'];
     
  }

  // Create Category
  public function create() {
    // Create Query
    $query = 'INSERT INTO ' .
      $this->table . '
    SET
    insur_desc = :insur_desc ,insur_price = :insur_price';
      
  // Prepare Statement
  $stmt = $this->conn->prepare($query);

  // Clean data
  $this->insur_desc = htmlspecialchars(strip_tags($this->insur_desc));
  $this->insur_price = htmlspecialchars(strip_tags($this->insur_price));
  

  // Bind data
  $stmt-> bindParam(':insur_desc', $this->insur_desc);
  $stmt-> bindParam(':insur_price', $this->insur_price);
  
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
     insur_desc = :insur_desc , 
     insur_price = :insur_price
     WHERE
     insur_id = :insur_id';

  // Prepare Statement
   $stmt = $this->conn->prepare($query);

  // Clean data
   $this->insur_id = htmlspecialchars(strip_tags($this->insur_id));
   $this->insur_desc = htmlspecialchars(strip_tags($this->insur_desc));
   $this->insur_price = htmlspecialchars(strip_tags($this->insur_price));
   
  

  // Bind data
   $stmt-> bindParam(':insur_id', $this->insur_id); 
   $stmt-> bindParam(':insur_desc', $this->insur_desc);
   $stmt-> bindParam(':insur_price', $this->insur_price);
 

 

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
    $query = 'DELETE FROM ' . $this->table . ' WHERE insur_id = :insur_id';

    // Prepare Statement
    $stmt = $this->conn->prepare($query);

    // clean data
    $this->insur_id = htmlspecialchars(strip_tags($this->insur_id));

    // Bind Data
    $stmt-> bindParam(':insur_id', $this->insur_id);

    // Execute query
    if($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: $s.\n", $stmt->error);

    return false;
    }
  }
