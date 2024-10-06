<?php
  class Jdetails_to {
    // DB Stuff
    private $conn;
    private $table = 'jdetails_to';
     
    // Properties
    public $id;
    public $j_id;
    public $j_ref;
    public $ac_id; 
    public $credit;
    public $debit; 
    public $j_type;
    public $store_id;
   public $yearId;
   
    public $j_date;
     public $j_desc;
      public $j_dateails;
       public $standard_details;
        public $j_details;
          public $invo_ref;
           
          
         public $j_date2; 
    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get doctors
    public function read() {
      // Create query
      $query = 'SELECT
        id,
        j_id,
        j_ref,
        ac_id,
        j_type,
        credit,
        store_id,
        debit ,
        yearId
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
        j_id,
        j_ref,
        j_date,
        ac_id,
        j_type,
        credit,
        store_id,
        debit ,
        yearId
        FROM
           ' . $this->table . ' 
          WHERE 
          store_id = :store_id  AND yearId = :yearId
          ORDER BY
          j_id ASC
          ';
    
        //Prepare statement
        $stmt = $this->conn->prepare($query);
    
        // Bind pay_id
        $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT); 
     $stmt->bindParam(':yearId', $this->yearId, PDO::PARAM_INT);  
        // Execute query
        $stmt->execute();
    
        return $stmt ;
       
    }



 
    
    public function readTop(){
      // Create query
      $query = 'SELECT 
       jdetails_to.id,
        jdetails_to.j_id,
        jdetails_to.j_ref, 
        jdetails_to.ac_id,
        jdetails_to.j_type,
        jdetails_to.credit,
        jdetails_to.store_id,
        jdetails_to.debit,
        journal.j_date,
        journal.j_desc,
         journal.standard_details,
         journal.j_details,
          journal.invo_ref,
        journal.yearId
          FROM
           ' . $this->table . ' 
           
          INNER JOIN journal ON jdetails_to.j_ref = journal.j_ref AND jdetails_to.yearId = :yearId
          WHERE 
          jdetails_to.store_id = :store_id  
          ORDER BY
          journal.j_date  DESC
          ';
    
        //Prepare statement
        $stmt = $this->conn->prepare($query);
    
        // Bind pay_id
        $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT); 
     $stmt->bindParam(':yearId', $this->yearId, PDO::PARAM_INT);  
        // Execute query
        $stmt->execute();
    
        return $stmt ;
       
    }
    
      public function readByDate(){
      // Create query
      $query = 'SELECT 
       jdetails_to.id,
        jdetails_to.j_id,
        jdetails_to.j_ref, 
        jdetails_to.ac_id,
        jdetails_to.j_type,
        jdetails_to.credit,
        jdetails_to.store_id,
        jdetails_to.debit,
        journal.j_date,
        journal.j_desc,
         journal.standard_details,
         journal.j_details,
          journal.invo_ref,
          journal.yearId
    
          FROM
           ' . $this->table . ' 
           
          INNER JOIN journal ON jdetails_to.j_ref = journal.j_ref
          WHERE 
         journal.j_date = :from AND jdetails_to.store_id = :store_id  AND jdetails_to.yearId = :yearId
          ORDER BY
         journal.j_date  DESC
          ';
    
        //Prepare statement
        $stmt = $this->conn->prepare($query);
    
        // Bind pay_id
        $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT); 
           $stmt->bindParam(':from', $this->j_date, PDO::PARAM_STR); 
     $stmt->bindParam(':yearId', $this->yearId, PDO::PARAM_INT);  
        // Execute query
        $stmt->execute();
    
        return $stmt ;
       
    }
    
    
    
   public function readBy2Date(){
      // Create query
      $query = 'SELECT  
       jdetails_to.id,
        jdetails_to.j_id,
        jdetails_to.j_ref, 
        jdetails_to.ac_id,
        jdetails_to.j_type,
        jdetails_to.credit,
        jdetails_to.store_id,
        jdetails_to.debit,
        journal.j_date,
        journal.j_desc,
         journal.standard_details,
         journal.j_details,
           journal.invo_ref,
            journal.yearId
           
          FROM
           ' . $this->table . ' 
           
          INNER JOIN journal ON jdetails_to.j_ref = journal.j_ref
          WHERE 
          journal.j_date >= :from AND journal.j_date <= :to AND jdetails_to.store_id = :store_id   AND jdetails_to.yearId = :yearId
          ORDER BY
          journal.j_date  DESC
          ';
    
        //Prepare statement
        $stmt = $this->conn->prepare($query);
    
        // Bind pay_id
        $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT); 
           $stmt->bindParam(':from', $this->j_date, PDO::PARAM_STR); 
             $stmt->bindParam(':to', $this->j_date2, PDO::PARAM_STR); 
       $stmt->bindParam(':yearId', $this->yearId, PDO::PARAM_INT);  
        // Execute query
        $stmt->execute();
    
        return $stmt ;
       
    }
    



    public function readAllStore(){
      // readAllStore excep purch and sales
      $query = 'SELECT 
        id,
        sub_name,
        j_date,
        sub_type,
        sub_code,
        sub_balance,
        store_id 
          FROM
           ' . $this->table . ' 
          WHERE 
          store_id = :store_id  AND yearId = :yearId AND j_date != 1  AND j_date != 2 
          ORDER BY
          id ASC
          ';
    
        //Prepare statement
        $stmt = $this->conn->prepare($query);
    
        // Bind pay_id
        $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT);  
         $stmt->bindParam(':yearId', $this->yearId, PDO::PARAM_INT);  
        // Execute query
        $stmt->execute();
    
        return $stmt ;
       
    }

    // Get Single Category
  public function read_single(){
    // Create query
    $query = 'SELECT
          id,
          sub_name,
        j_date,
        sub_type  
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
      $this->sub_name = $row['sub_name'];
      $this->sub_name = $row['j_date'];
      $this->sub_type = $row['sub_type'];
     
  }



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
  

  // Create Category
  public function create() {
    // Create Query
    $query = 'INSERT INTO ' .
      $this->table . '
      SET 
      j_id = :j_id ,j_ref = :j_ref ,ac_id = :ac_id,j_type = :j_type ,credit = :credit ,debit = :debit ,user_id = :user_id ,store_id = :store_id,yearId = :yearId';
      
  // Prepare Statement
  $stmt = $this->conn->prepare($query);

   
   


  // Clean data
  $this->j_id = htmlspecialchars(strip_tags($this->j_id));
  $this->j_ref = htmlspecialchars(strip_tags($this->j_ref));
  $this->ac_id = htmlspecialchars(strip_tags($this->ac_id));
  $this->j_type = htmlspecialchars(strip_tags($this->j_type));
  $this->credit = htmlspecialchars(strip_tags($this->credit));
  $this->debit = htmlspecialchars(strip_tags($this->debit)); 
  $this->store_id = htmlspecialchars(strip_tags($this->store_id));
  $this->yearId = htmlspecialchars(strip_tags($this->yearId));

  // Bind data
  $stmt-> bindParam(':j_id', $this->j_id);
  $stmt-> bindParam(':j_ref', $this->j_ref);
  $stmt-> bindParam(':ac_id', $this->ac_id);
  $stmt-> bindParam(':j_type', $this->j_type);
  $stmt-> bindParam(':credit', $this->credit);
  $stmt-> bindParam(':debit', $this->debit);
  $stmt-> bindParam(':user_id', $this->user_id); 
  $stmt-> bindParam(':store_id', $this->store_id);
   $stmt-> bindParam(':yearId', $this->yearId);
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
     SET 
     j_id = :j_id , j_ref = :j_ref ,ac_id = :ac_id,j_type = :j_type ,credit = :credit ,debit = :debit ,user_id = :user_id ,store_id = :store_id,yearId = :yearId
     WHERE
    id = :id';

  // Prepare Statement
   $stmt = $this->conn->prepare($query);

  // Clean data
  $this->id = htmlspecialchars(strip_tags($this->id));
  $this->j_id = htmlspecialchars(strip_tags($this->j_id));
   $this->j_ref = htmlspecialchars(strip_tags($this->j_ref));
  $this->ac_id = htmlspecialchars(strip_tags($this->ac_id));
  $this->j_type = htmlspecialchars(strip_tags($this->j_type));
  $this->credit = htmlspecialchars(strip_tags($this->credit));
  $this->debit = htmlspecialchars(strip_tags($this->debit));
  $this->user_id = htmlspecialchars(strip_tags($this->user_id)); 
  $this->store_id = htmlspecialchars(strip_tags($this->store_id));
   $this->yearId = htmlspecialchars(strip_tags($this->yearId)); 
  

  // Bind data
  $stmt-> bindParam(':id', $this->id);
  $stmt-> bindParam(':j_id', $this->j_id); 
  $stmt-> bindParam(':j_ref', $this->j_ref);
  $stmt-> bindParam(':ac_id', $this->ac_id);
  $stmt-> bindParam(':j_type', $this->j_type);
  $stmt-> bindParam(':credit', $this->credit);
  $stmt-> bindParam(':debit', $this->debit);
  $stmt-> bindParam(':user_id', $this->user_id); 
  $stmt-> bindParam(':store_id', $this->store_id);
 $stmt-> bindParam(':yearId', $this->yearId);

 

   // Execute query
   if($stmt->execute()) {
    return true;
   }

  // Print error if something goes wrong
    printf("Error: $s.\n", $stmt->error);

   return false;
  }


  public function deleteMultiServices() {
    // Create query
    $query = 'DELETE FROM ' . $this->table . ' WHERE j_ref = :j_ref';
  
    // Prepare Statement
    $stmt = $this->conn->prepare($query);
  
    // clean data
    $this->pay_ref = htmlspecialchars(strip_tags($this->j_ref));
  
    // Bind Data
    $stmt-> bindParam(':j_ref', $this->j_ref);
  
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
