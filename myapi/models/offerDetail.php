<?php
  class Offerdetail {
    // DB Stuff
    private $conn;
    private $table = 'offerdetail';

    // Properties
    public $id;
    public $offerId;
    public $descrb;
    

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get doctors
    public function read() {
      // Create query
      $query = 'SELECT
        id,
        offerId,
        descrb
      FROM
        ' . $this->table . '
        WHERE
        offerId !=""
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
        offerId,
        descrb
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
      $this->offerId = $row['offerId'];
      $this->descrb = $row['descrb'];
      
  }

////read detail of spacific offer
public function read_detail(){
  // Create query
  $query = 'SELECT 
        id,
        descrb,
        offerId
        FROM
        ' . $this->table . ' 
        WHERE 
        offerId = :offerId'; 
    //Prepare statement
    $stmt = $this->conn->prepare($query);

    // Bind id
    $stmt-> bindParam(':offerId', $this->offerId);
 
    
    // Execute query 
    // Execute query
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $stmt;
    
}


  // Create Category
  public function create() {
    // Create Query
    $query = 'INSERT INTO ' .
      $this->table . '
    SET
    offerId = :offerId ,descrb = :descrb';
      
  // Prepare Statement
  $stmt = $this->conn->prepare($query);

  // Clean data
  $this->offerId = htmlspecialchars(strip_tags($this->offerId));
  $this->descrb = htmlspecialchars(strip_tags($this->descrb));
  
   

  // Bind data
  $stmt-> bindParam(':offerId', $this->offerId);
  $stmt-> bindParam(':descrb', $this->descrb);
 
 

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
     offerId = :offerId , 
     descrb = :descrb 
     WHERE
     id = :id';

  // Prepare Statement
   $stmt = $this->conn->prepare($query);

  // Clean data
   $this->id = htmlspecialchars(strip_tags($this->id));
   $this->offerId = htmlspecialchars(strip_tags($this->offerId));
   $this->descrb = htmlspecialchars(strip_tags($this->descrb));
   
  
  

  // Bind data
   $stmt-> bindParam(':id', $this->id); 
   $stmt-> bindParam(':offerId', $this->offerId);
   $stmt-> bindParam(':descrb', $this->descrb);
   
   

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
  }
