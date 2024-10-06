<?php
  class Services {
    // DB Stuff
    private $conn;
    private $table = 'services';

    // Properties
    public $id;
    public $ptinvo_id;
    public $serv_desc;
    public $serv_price;
    public $serv_type;
    public $list_ordering;
    public $status;
    public $serv_id;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get doctors
    public function read() {
      // Create query
      $query = 'SELECT
        id,
        ptinvo_id,
        serv_desc,
        serv_price,
        serv_type,
        list_ordering,
        status,
        serv_id 
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

    // Get Single Category
  public function read_single(){
    // Create query
    $query = 'SELECT
          id,
        ptinvo_id,
        serv_desc,
        serv_price,
        serv_type,
        list_ordering,
        status,
        serv_id
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
      $this->ptinvo_id = $row['ptinvo_id'];
      $this->serv_desc = $row['serv_desc'];
      $this->serv_price = $row['serv_price'];
      $this->serv_type = $row['serv_type'];
      $this->serv_type = $row['list_ordering']; 
      $this->status = $row['status']; 
      $this->serv_id = $row['serv_id']; 
  }

  // Create Category
  public function create() {
    // Create Query
    $query = 'INSERT INTO ' .
      $this->table . '
    SET
    ptinvo_id = :ptinvo_id ,serv_desc = :serv_desc, serv_price = :serv_price, serv_type = :serv_type, list_ordering = :list_ordering, status = :status, serv_id = :serv_id';
//    VALUES (NULL,:ptinvo_id,:serv_desc,:serv_price,:serv_type,:list_ordering,:status,:serv_id)';
  // Prepare Statement
  $stmt = $this->conn->prepare($query);

  // Clean data
  $this->ptinvo_id = htmlspecialchars(strip_tags($this->ptinvo_id));
  $this->serv_desc = htmlspecialchars(strip_tags($this->serv_desc));
  $this->serv_price = htmlspecialchars(strip_tags($this->serv_price));
  $this->serv_type = htmlspecialchars(strip_tags($this->serv_type));
  $this->list_ordering = htmlspecialchars(strip_tags($this->list_ordering));
  $this->status = htmlspecialchars(strip_tags($this->status));
  $this->serv_id = htmlspecialchars(strip_tags($this->serv_id));

  // Bind data
  $stmt-> bindParam(':ptinvo_id', $this->ptinvo_id);
  $stmt-> bindParam(':serv_desc', $this->serv_desc);
  $stmt-> bindParam(':serv_price', $this->serv_price);
  $stmt-> bindParam(':serv_type', $this->serv_type);
  $stmt-> bindParam(':list_ordering', $this->list_ordering);
  $stmt-> bindParam(':status', $this->status);
  $stmt-> bindParam(':serv_id', $this->serv_id);

  // Execute query
  if($stmt->execute()) {
    return true;
  }

  // Print error if something goes wrong
  printf("Error: $s.\n", $stmt->error);

  return false;
  }

//// create multi record 
public function createMulti($values) {
  // Create Query

  $query = 'INSERT INTO ' .
    $this->table . '
    VALUES '. $values .'';
// Prepare Statement
$stmt = $this->conn->prepare($query);


// Execute query
if($stmt->execute()) {
  return true;
}

// Print error if something goes wrong
printf("Error: $s.\n", $stmt->error);

return false;
}


  // reordering service 
  public function reorder() {
    // Create Query
     $query = 'UPDATE ' . $this->table . '
     SET 
     list_ordering = :list_ordering 
     WHERE
     id = :id';

  // Prepare Statement
   $stmt = $this->conn->prepare($query);

  // Clean data
   $this->id = htmlspecialchars(strip_tags($this->id));
  
   $this->list_ordering = htmlspecialchars(strip_tags($this->list_ordering));
  
  // Bind data
   $stmt-> bindParam(':id', $this->id);  
   $stmt-> bindParam(':list_ordering', $this->list_ordering);
  

 

   // Execute query
   if($stmt->execute()) {
    return true;
   }

  // Print error if something goes wrong
    printf("Error: $s.\n", $stmt->error);

   return false;
  }

  public function update() {
    // Create Query
     $query = 'UPDATE ' .
      $this->table . '
     SET
     ptinvo_id = :ptinvo_id , 
     serv_desc = :serv_desc,
     serv_price = :serv_price,
     serv_type = :serv_type,
     list_ordering = :list_ordering,
     status = :status,
     serv_id = :serv_id
     WHERE
     id = :id';

  // Prepare Statement
   $stmt = $this->conn->prepare($query);

  // Clean data
   $this->id = htmlspecialchars(strip_tags($this->id));
   $this->ptinvo_id = htmlspecialchars(strip_tags($this->ptinvo_id));
   $this->serv_desc = htmlspecialchars(strip_tags($this->serv_desc));
   $this->serv_price = htmlspecialchars(strip_tags($this->serv_price));
   $this->serv_type = htmlspecialchars(strip_tags($this->serv_type));
   $this->list_ordering = htmlspecialchars(strip_tags($this->list_ordering));
   $this->status = htmlspecialchars(strip_tags($this->status));
   $this->serv_id = htmlspecialchars(strip_tags($this->serv_id));
  

  // Bind data
   $stmt-> bindParam(':id', $this->id); 
   $stmt-> bindParam(':ptinvo_id', $this->ptinvo_id);
   $stmt-> bindParam(':serv_desc', $this->serv_desc);
   $stmt-> bindParam(':serv_price', $this->serv_price);
   $stmt-> bindParam(':serv_type', $this->serv_type);
   $stmt-> bindParam(':list_ordering', $this->list_ordering);
   $stmt-> bindParam(':status', $this->status);
   $stmt-> bindParam(':serv_id', $this->serv_id);

 

   // Execute query
   if($stmt->execute()) {
    return true;
   }

  // Print error if something goes wrong
    printf("Error: $s.\n", $stmt->error);

   return false;
  }

// delete multi services
public function deleteMultiServices() {
  // Create query
  $query = 'DELETE FROM ' . $this->table . ' WHERE ptinvo_id = :ptinvo_id';

  // Prepare Statement
  $stmt = $this->conn->prepare($query);

  // clean data
  $this->ptinvo_id = htmlspecialchars(strip_tags($this->ptinvo_id));

  // Bind Data
  $stmt-> bindParam(':ptinvo_id', $this->ptinvo_id);

  // Execute query
  if($stmt->execute()) {
    return true;
  }

  // Print error if something goes wrong
  printf("Error: $s.\n", $stmt->error);

  return false;
  }
 

 
// Delete services
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
