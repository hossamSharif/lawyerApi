<?php
  class J_type {
    // DB Stuff
    private $conn;
    private $table = 'j_type';
    
    // Properties
    public $id;
    public $type_name;
    public $type_desc; 
     public $default_details;
    public $store_id;
       public $from_count;
    public $to_count;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get doctors
    public function read() {
      // Create query
      $query = 'SELECT
        id,
        type_name,
        ac_id,
        type_desc,
        creditac_id,
        debitac_id,
        default_details
        store_id
        
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

    public function readByStore(){
      // Create query
      $query = 'SELECT 
             id,
        type_name, 
        type_desc, 
        default_details, 
        store_id,
        from_count ,
        to_count 
          FROM
           ' . $this->table . ' 
          WHERE 
          store_id = :store_id 
          ORDER BY
          id ASC
          ';
    
        //Prepare statement
        $stmt = $this->conn->prepare($query);
    
        // Bind pay_id
        $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT);  
        
    
        // Execute query
        $stmt->execute();
    
        return $stmt ;
       
    }


    public function readAllStore(){
      // readAllStore excep purch and sales
      $query = 'SELECT 
             id,
        type_name,
        ac_id,
        type_desc,
        creditac_id,
        debitac_id,
        store_id ,
        from_count ,
        to_count ,
        IFNULL((SELECT SUM(jdetails_from.debit) FROM jdetails_from WHERE  jdetails_from.ac_id = sub_accounts.ac_id AND jdetails_from.store_id = :store_id ), 0) AS debitTot ,
        IFNULL((SELECT SUM(jdetails_to.credit) FROM jdetails_to WHERE  jdetails_to.ac_id = sub_accounts.ac_id AND jdetails_to.store_id = :store_id ), 0) AS creditTot 

          FROM
           ' . $this->table . ' 
          WHERE 
          store_id = :store_id
          ORDER BY
          id ASC
          '; 
        //Prepare statement
        $stmt = $this->conn->prepare($query);
    
        // Bind pay_id
        $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT);  
        // Execute query
        $stmt->execute();
    
        return $stmt ;
       
    }

    // Get Single Category
  public function read_single(){
    // Create query
    $query = 'SELECT
          id,
          type_name,
        ac_id,
        type_desc  
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
      $this->type_name = $row['type_name'];
      $this->type_name = $row['ac_id'];
      $this->type_desc = $row['type_desc'];
     
  }



  //login
  public function login(){
    // Create query
    $query = 'SELECT
          id,
          type_name,
        ac_id,
        type_desc ,
        store_id 
        FROM
          ' . $this->table . '
      WHERE type_name=:type_name AND ac_id=:ac_id AND store_id=:store_id';

      //Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind id
      $stmt->bindParam(':type_name', $this->type_name);
      $stmt->bindParam(':ac_id', $this->ac_id);
      $stmt->bindParam(':store_id', $this->store_id);

      // Execute query
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // set properties
      $this->id = $row['id'];
      $this->type_name = $row['type_name'];
      $this->ac_id = $row['ac_id'];
      $this->type_desc = $row['type_desc'];
      $this->store_id = $row['store_id'];
     
  }

  // Create Category
  public function create() {
    // Create Query
    $query = 'INSERT INTO ' .
      $this->table . '
    SET
    ac_id = :ac_id ,type_name = :type_name ,type_desc = :type_desc,debitac_id = :debitac_id ,creditac_id = :creditac_id ,store_id = :store_id';
      
  // Prepare Statement
  $stmt = $this->conn->prepare($query);

  // Clean data
  $this->type_name = htmlspecialchars(strip_tags($this->type_name));
  $this->ac_id = htmlspecialchars(strip_tags($this->ac_id));
  $this->type_desc = htmlspecialchars(strip_tags($this->type_desc));
  $this->debitac_id = htmlspecialchars(strip_tags($this->debitac_id));
  $this->creditac_id = htmlspecialchars(strip_tags($this->creditac_id));
  $this->store_id = htmlspecialchars(strip_tags($this->store_id));
  

  // Bind data
  $stmt-> bindParam(':type_name', $this->type_name);
  $stmt-> bindParam(':ac_id', $this->ac_id);
  $stmt-> bindParam(':type_desc', $this->type_desc);
  $stmt-> bindParam(':debitac_id', $this->debitac_id);
  $stmt-> bindParam(':creditac_id', $this->creditac_id);
  $stmt-> bindParam(':store_id', $this->store_id);
  
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
     type_name = :type_name , 
     ac_id = :ac_id , 
     type_desc = :type_desc
     WHERE
     id = :id';

  // Prepare Statement
   $stmt = $this->conn->prepare($query);

  // Clean data
   $this->id = htmlspecialchars(strip_tags($this->id));
   $this->type_name = htmlspecialchars(strip_tags($this->type_name));
   $this->ac_id = htmlspecialchars(strip_tags($this->ac_id));
   $this->type_desc = htmlspecialchars(strip_tags($this->type_desc));
   
  

  // Bind data
   $stmt-> bindParam(':id', $this->id); 
   $stmt-> bindParam(':type_name', $this->type_name);
   $stmt-> bindParam(':ac_id', $this->type_name);
   $stmt-> bindParam(':type_desc', $this->type_desc);
 

 

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
