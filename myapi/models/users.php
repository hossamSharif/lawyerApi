<?php
  class Users {
    // DB Stuff
    private $conn;
    private $table = 'users';
    
    // Properties
    public $id;
    public $user_name;
    public $password;
    public $full_name;
    public $job_title;
    public $email;
    public $phone;
    public $level;
   

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get doctors
    public function read() {
      // Create query
      $query = 'SELECT
        id,
        user_name,
        password,
        full_name,
        job_title ,
        phone ,
        level , 
        email 
        
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
          user_name,
         password,
         full_name ,
         job_title ,
         phone ,
         email   
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
      $this->user_name = $row['user_name'];
      $this->user_name = $row['password'];
      $this->full_name = $row['full_name'];
      $this->email = $row['email'];
      $this->phone = $row['phone'];
      $this->level = $row['level'];
      $this->job_title = $row['job_title'];
     
  }



  //login
  public function login(){
    // Create query
    $query = 'SELECT
          id,
          user_name,
        password,
        full_name ,
        job_title ,
        phone ,
        level ,
        email 
        FROM
          ' . $this->table . '
      WHERE user_name=:user_name AND password=:password ';

      //Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind id
      $stmt->bindParam(':user_name', $this->user_name);
      $stmt->bindParam(':password', $this->password);

      // Execute query
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // set properties
      $this->id = $row['id'];
      $this->user_name = $row['user_name'];
      $this->password = $row['password'];
      $this->full_name = $row['full_name'];
      $this->email = $row['email'];
      $this->phone = $row['phone'];
      $this->level = $row['level'];
      $this->job_title = $row['job_title'];
     
  }

  // Create Category
  public function create() {
    // Create Query
    $query = 'INSERT INTO ' .
      $this->table . '
    SET
    user_name = :user_name ,password = :password ,full_name = :full_name,job_title = :job_title, email = :email ,phone = :phone,level = :level';
      
  // Prepare Statement
  $stmt = $this->conn->prepare($query);

  // Clean data
  $this->user_name = htmlspecialchars(strip_tags($this->user_name));
  $this->password = htmlspecialchars(strip_tags($this->password));
  $this->full_name = htmlspecialchars(strip_tags($this->full_name));
  $this->job_title = htmlspecialchars(strip_tags($this->job_title));
  $this->phone = htmlspecialchars(strip_tags($this->phone));
  $this->email = htmlspecialchars(strip_tags($this->email));
  $this->level = htmlspecialchars(strip_tags($this->level));
  

  // Bind data
  $stmt-> bindParam(':user_name', $this->user_name);
  $stmt-> bindParam(':password', $this->password);
  $stmt-> bindParam(':full_name', $this->full_name);
  $stmt-> bindParam(':job_title', $this->job_title);
  $stmt-> bindParam(':email', $this->email);
  $stmt-> bindParam(':phone', $this->phone);
  $stmt-> bindParam(':level', $this->level);
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
     user_name = :user_name , 
     password = :password , 
     full_name = :full_name ,
     phone = :phone ,
     email = :email ,
     job_title = :job_title ,
     level = :level 
     WHERE
     id = :id';

  // Prepare Statement
   $stmt = $this->conn->prepare($query);

  // Clean data
   $this->id = htmlspecialchars(strip_tags($this->id));
   $this->user_name = htmlspecialchars(strip_tags($this->user_name));
   $this->password = htmlspecialchars(strip_tags($this->password));
   $this->full_name = htmlspecialchars(strip_tags($this->full_name));
   $this->email = htmlspecialchars(strip_tags($this->email));
   $this->phone = htmlspecialchars(strip_tags($this->phone));
   $this->level = htmlspecialchars(strip_tags($this->level));
   
  // Bind data
   $stmt-> bindParam(':id', $this->id); 
   $stmt-> bindParam(':user_name', $this->user_name);
   $stmt-> bindParam(':password', $this->user_name);
   $stmt-> bindParam(':full_name', $this->full_name);
   $stmt-> bindParam(':phone', $this->phone);
   $stmt-> bindParam(':email', $this->email);
   $stmt-> bindParam(':job_title', $this->job_title);
   $stmt-> bindParam(':level', $this->level);
   
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
