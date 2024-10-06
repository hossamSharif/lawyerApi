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
    public $offerName;
    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get doctors
  



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


  // Create
  public function sendSubcMail() {
    // Create Query
    
  // Clean data
  $this->name = htmlspecialchars(strip_tags($this->name));
  $this->email = htmlspecialchars(strip_tags($this->email));
  $this->phone = htmlspecialchars(strip_tags($this->phone));
  $this->offerId = htmlspecialchars(strip_tags($this->offerId));
  $this->offerName = htmlspecialchars(strip_tags($this->offerName));

  // Bind data
  $stmt-> bindParam(':name', $this->name);
  $stmt-> bindParam(':email', $this->email);
  $stmt-> bindParam(':phone', $this->phone);
  $stmt-> bindParam(':offerId', $this->offerId);
  $stmt-> bindParam(':offerName', $this->offerName);

  // Execute query
  if($stmt->execute()) {
    return true;
  }

  // Print error if something goes wrong
  printf("Error: $s.\n", $stmt->error);

  return false;
  }
  
  
   public function sendcourceMail() {
    // Create Query
    
  // Clean data
   
  $this->email = htmlspecialchars(strip_tags($this->email));
 

  // Bind data 
  $stmt-> bindParam(':email', $this->email);
  

  // Execute query
  if($stmt->execute()) {
    return true;
  }

  // Print error if something goes wrong
  printf("Error: $s.\n", $stmt->error);

  return false;
  }

//

 
  }