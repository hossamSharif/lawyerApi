<?php
  class Xray {
    // DB Stuff
    private $conn;
    private $table = 'xray';

    // Properties
    public $xray_id;
    public $xray_desc;
    public $xray_type;
    public $xray_price;
    
    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get doctors
    public function read() {
      // Create query
      $query = 'SELECT
        xray_id,
        xray_desc,
        xray_type,
        xray_price
        
      FROM
        ' . $this->table . '
      ORDER BY
        xray_id DESC';

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
          xray_id,
          xray_desc,
        xray_type,
        xray_price  
        FROM
          ' . $this->table . '
      WHERE xray_id = ?
      LIMIT 0,1';

      //Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind xray_id
      $stmt->bindParam(1, $this->xray_id);

      // Execute query
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // set properties
      $this->xray_id = $row['xray_id'];
      $this->xray_desc = $row['xray_desc'];
      $this->xray_desc = $row['xray_type'];
      $this->xray_price = $row['xray_price'];
     
  }

  // Create Category
  public function create() {
    // Create Query
    $query = 'INSERT INTO ' .
      $this->table . '
    SET
    xray_desc = :xray_desc ,xray_type = :xray_type ,xray_price = :xray_price';
      
  // Prepare Statement
  $stmt = $this->conn->prepare($query);

  // Clean data
  $this->xray_desc = htmlspecialchars(strip_tags($this->xray_desc));
  $this->xray_type = htmlspecialchars(strip_tags($this->xray_type));
  $this->xray_price = htmlspecialchars(strip_tags($this->xray_price));
  

  // Bind data
  $stmt-> bindParam(':xray_desc', $this->xray_desc);
  $stmt-> bindParam(':xray_type', $this->xray_desc);
  $stmt-> bindParam(':xray_price', $this->xray_price);
  
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
     xray_desc = :xray_desc , 
     xray_type = :xray_type , 
     xray_price = :xray_price
     WHERE
     xray_id = :xray_id';

  // Prepare Statement
   $stmt = $this->conn->prepare($query);

  // Clean data
   $this->xray_id = htmlspecialchars(strip_tags($this->xray_id));
   $this->xray_desc = htmlspecialchars(strip_tags($this->xray_desc));
   $this->xray_type = htmlspecialchars(strip_tags($this->xray_type));
   $this->xray_price = htmlspecialchars(strip_tags($this->xray_price));
   
  

  // Bind data
   $stmt-> bindParam(':xray_id', $this->xray_id); 
   $stmt-> bindParam(':xray_desc', $this->xray_desc);
   $stmt-> bindParam(':xray_type', $this->xray_type);
   $stmt-> bindParam(':xray_price', $this->xray_price);
 

 

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
    $query = 'DELETE FROM ' . $this->table . ' WHERE xray_id = :xray_id';

    // Prepare Statement
    $stmt = $this->conn->prepare($query);

    // clean data
    $this->xray_id = htmlspecialchars(strip_tags($this->xray_id));

    // Bind Data
    $stmt-> bindParam(':xray_id', $this->xray_id);

    // Execute query
    if($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: $s.\n", $stmt->error);

    return false;
    }
  }
