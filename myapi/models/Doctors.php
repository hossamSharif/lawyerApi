<?php
  class Doctors {
    // DB Stuff
    private $conn;
    private $table = 'doctors';

    // Properties
    public $dr_id;
    public $dr_name;
    public $dr_phone;
    public $dr_spec;
    public $dr_type;
    public $teckit_price;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get doctors
    public function read() {
      // Create query
      $query = 'SELECT
        dr_id,
        dr_name,
        dr_phone,
        dr_spec,
        dr_type,
        teckit_price
      FROM
        ' . $this->table . '
      ORDER BY
        dr_id DESC';

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
          dr_id,
        dr_name,
        dr_phone,
        dr_spec,
        dr_type,
        teckit_price
        FROM
          ' . $this->table . '
      WHERE dr_id = ?
      LIMIT 0,1'; 
      //Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind dr_id
      $stmt->bindParam(1, $this->dr_id);

      // Execute query
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // set properties
      $this->dr_id = $row['dr_id'];
      $this->dr_name = $row['dr_name'];
      $this->dr_phone = $row['dr_phone'];
      $this->dr_spec = $row['dr_spec'];
      $this->dr_type = $row['dr_type'];
      $this->dr_type = $row['teckit_price']; 
  }

  // Create Category
  public function create() {
    // Create Query
    $query = 'INSERT INTO ' .
      $this->table . '
    SET
    dr_name = :dr_name ,dr_phone = :dr_phone, dr_spec = :dr_spec, dr_type = :dr_type, teckit_price = :teckit_price';
      
  // Prepare Statement
  $stmt = $this->conn->prepare($query);

  // Clean data
  $this->dr_name = htmlspecialchars(strip_tags($this->dr_name));
  $this->dr_phone = htmlspecialchars(strip_tags($this->dr_phone));
  $this->dr_spec = htmlspecialchars(strip_tags($this->dr_spec));
  $this->dr_type = htmlspecialchars(strip_tags($this->dr_type));
  $this->teckit_price = htmlspecialchars(strip_tags($this->teckit_price));

  // Bind data
  $stmt-> bindParam(':dr_name', $this->dr_name);
  $stmt-> bindParam(':dr_phone', $this->dr_phone);
  $stmt-> bindParam(':dr_spec', $this->dr_spec);
  $stmt-> bindParam(':dr_type', $this->dr_type);
  $stmt-> bindParam(':teckit_price', $this->teckit_price);

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
     dr_name = :dr_name , 
     dr_phone = :dr_phone,
     dr_spec = :dr_spec,
     dr_type = :dr_type,
     teckit_price = :teckit_price
     WHERE
     dr_id = :dr_id';

  // Prepare Statement
   $stmt = $this->conn->prepare($query);

  // Clean data
   $this->dr_id = htmlspecialchars(strip_tags($this->dr_id));
   $this->dr_name = htmlspecialchars(strip_tags($this->dr_name));
   $this->dr_phone = htmlspecialchars(strip_tags($this->dr_phone));
   $this->dr_spec = htmlspecialchars(strip_tags($this->dr_spec));
   $this->dr_type = htmlspecialchars(strip_tags($this->dr_type));
   $this->teckit_price = htmlspecialchars(strip_tags($this->teckit_price));
  

  // Bind data
   $stmt-> bindParam(':dr_id', $this->dr_id); 
   $stmt-> bindParam(':dr_name', $this->dr_name);
   $stmt-> bindParam(':dr_phone', $this->dr_phone);
   $stmt-> bindParam(':dr_spec', $this->dr_spec);
   $stmt-> bindParam(':dr_type', $this->dr_type);
   $stmt-> bindParam(':teckit_price', $this->teckit_price);

 

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
    $query = 'DELETE FROM ' . $this->table . ' WHERE dr_id = :dr_id';

    // Prepare Statement
    $stmt = $this->conn->prepare($query);

    // clean data
    $this->dr_id = htmlspecialchars(strip_tags($this->dr_id));

    // Bind Data
    $stmt-> bindParam(':dr_id', $this->dr_id);

    // Execute query
    if($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: $s.\n", $stmt->error);

    return false;
    }
  }
