<?php
  class Student {
    // DB Stuff
    private $conn;
    private $table = 'student';

    // Properties
    public $id;
    public $name;
    public $email;
    public $phone;  
    public $offerId;  

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get doctors
    public function read() {
      // Create query
      $query = 'SELECT
        id,
        name,
        email,
        phone,
        offerId
      FROM
        ' . $this->table . '
        WHERE
        name !=""
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
        name,
        email,
        phone,
        offerId
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
      $this->name = $row['name'];
      $this->email = $row['email'];
      $this->phone = $row['phone']; 
      $this->offerId = $row['offerId']; 
  }

//offerStudent
public function offerStudent(){
  // Create query
  $query = 'SELECT * FROM ' . $this->table . ' 
    WHERE offerId = offerId AND name != "" '; 
    //Prepare statement
    $stmt = $this->conn->prepare($query);

    // Bind id
    $stmt->bindParam(':offerId', $this->offerId);
    
    // Execute query
   

    $stmt = $this->conn->prepare($query);

    // Execute query
    $stmt->execute();

    return $stmt;
    
}


  // Create Category
  public function create() {
    // Create Query
    $query = 'INSERT INTO ' . $this->table . '
    SET
    name = :name ,email = :email, phone = :phone, offerId = :offerId';
      
  // Prepare Statement
  $stmt = $this->conn->prepare($query);

  // Clean data
  $this->name = htmlspecialchars(strip_tags($this->name));
  $this->email = htmlspecialchars(strip_tags($this->email));
  $this->phone = htmlspecialchars(strip_tags($this->phone));
  $this->offerId = htmlspecialchars(strip_tags($this->offerId));
   

  // Bind data
  $stmt-> bindParam(':name', $this->name);
  $stmt-> bindParam(':email', $this->email);
  $stmt-> bindParam(':phone', $this->phone);
  $stmt-> bindParam(':offerId', $this->offerId);
 

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
     name = :name , 
     email = :email,
     phone = :phone,
     offerId = :offerId  
     WHERE
     id = :id';

  // Prepare Statement
   $stmt = $this->conn->prepare($query);

  // Clean data
   $this->id = htmlspecialchars(strip_tags($this->id));
   $this->name = htmlspecialchars(strip_tags($this->name));
   $this->email = htmlspecialchars(strip_tags($this->email));
   $this->phone = htmlspecialchars(strip_tags($this->phone));
   $this->offerId = htmlspecialchars(strip_tags($this->offerId));
  
  

  // Bind data
   $stmt-> bindParam(':id', $this->id); 
   $stmt-> bindParam(':name', $this->name);
   $stmt-> bindParam(':email', $this->email);
   $stmt-> bindParam(':phone', $this->phone);
   $stmt-> bindParam(':offerId', $this->offerId);
   

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
