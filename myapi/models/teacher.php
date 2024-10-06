<?php
  class Teacher {
    // DB Stuff
    private $conn;
    private $table = 'teacher';

    // Properties
    public $id;
    public $shortDescr;
    public $name;
    public $imgUrl;  

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get doctors
    public function read() {
      // Create query
      $query = 'SELECT
        id,
        shortDescr,
        name,
        imgUrl
      FROM
        ' . $this->table . '
        WHERE
        shortDescr !=""
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
        shortDescr,
        name,
        imgUrl
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
      $this->shortDescr = $row['shortDescr'];
      $this->name = $row['name'];
      $this->imgUrl = $row['imgUrl']; 
  }

  // Create Category
  public function create() {
    // Create Query
    $query = 'INSERT INTO ' .
      $this->table . '
    SET
    shortDescr = :shortDescr ,name = :name, imgUrl = :imgUrl';
      
  // Prepare Statement
  $stmt = $this->conn->prepare($query);

  // Clean data
  $this->shortDescr = htmlspecialchars(strip_tags($this->shortDescr));
  $this->name = htmlspecialchars(strip_tags($this->name));
  $this->imgUrl = htmlspecialchars(strip_tags($this->imgUrl));
   

  // Bind data
  $stmt-> bindParam(':shortDescr', $this->shortDescr);
  $stmt-> bindParam(':name', $this->name);
  $stmt-> bindParam(':imgUrl', $this->imgUrl);
 

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
     shortDescr = :shortDescr , 
     name = :name,
     imgUrl = :imgUrl
     WHERE
     id = :id';

  // Prepare Statement
   $stmt = $this->conn->prepare($query);

  // Clean data
   $this->id = htmlspecialchars(strip_tags($this->id));
   $this->shortDescr = htmlspecialchars(strip_tags($this->shortDescr));
   $this->name = htmlspecialchars(strip_tags($this->name));
   $this->imgUrl = htmlspecialchars(strip_tags($this->imgUrl));
  
  

  // Bind data
   $stmt-> bindParam(':id', $this->id); 
   $stmt-> bindParam(':shortDescr', $this->shortDescr);
   $stmt-> bindParam(':name', $this->name);
   $stmt-> bindParam(':imgUrl', $this->imgUrl);
   

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
