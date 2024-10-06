<?php
  class  Accounts {
    // DB Stuff
    private $conn;
    private $table = 'accounts';
    
    
  
    
    
    // Properties 
    public $ac_name;
    public $ac_id;
    public $actype_id;
    public $ac_code;
    public $eng_name; 
    public $ac_balance; 
     
     
    public $ac_type; 
  
         
         
    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }


//for balance sheet

public function readBalancesSub() {
  // Create query
  $query = 'SELECT
    sub_accounts.id,
    sub_accounts.sub_name,
    sub_accounts.ac_id,
    sub_accounts.sub_type,
    sub_accounts.sub_code,
    sub_accounts.sub_balance,
    sub_accounts.store_id,
    accounts.actype_id,
    accounts.ac_name,
    accounts.eng_name,
    IFNULL((SELECT SUM(jdetails_from.debit) FROM jdetails_from  WHERE  jdetails_from.ac_id = sub_accounts.id AND jdetails_from.store_id = :store_id ), 0) AS fromDebitTot ,
    IFNULL((SELECT SUM(jdetails_from.credit) FROM jdetails_from  WHERE  jdetails_from.ac_id = sub_accounts.id AND jdetails_from.store_id = :store_id ), 0) AS fromCreditTot,
    IFNULL((SELECT SUM(jdetails_to.debit) FROM jdetails_to  WHERE  jdetails_to.ac_id = sub_accounts.id AND jdetails_to.store_id = :store_id ), 0) AS toDebitTot,
    IFNULL((SELECT SUM(jdetails_to.credit) FROM jdetails_to  WHERE  jdetails_to.ac_id = sub_accounts.id AND jdetails_to.store_id = :store_id ), 0) AS toCreditTot
    FROM
    ' . $this->table . '
    INNER JOIN accounts ON sub_accounts.ac_id = accounts.ac_id
     WHERE
     sub_accounts.sub_name != "" AND sub_accounts.store_id = :store_id  
    '; 
        //Prepare statement
        $stmt = $this->conn->prepare($query); 
        // Bind pay_id
        $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT); 
        // Execute query
        $stmt->execute();
    
        return $stmt ;
}

    // Get doctors
    public function read() {
      // Create query
      $query = 'SELECT
        id,
        sub_name,
        ac_id, 
        sub_code,
        sub_balance,
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
        accounts.ac_name,
        accounts.ac_id, 
        accounts.actype_id,
        accounts.ac_balance,
        accounts.eng_name ,
        account_type.ac_type 
          FROM
           ' . $this->table . ' 
           INNER JOIN account_type ON accounts.actype_id = account_type.id
          ORDER BY
          ac_id ASC
          ';
    
        //Prepare statement
        $stmt = $this->conn->prepare($query);
    
   
        // Execute query
        $stmt->execute();
    
        return $stmt ;
       
    }


    public function readAllStore(){
      // readAllStore excep purch and sales
      $query = 'SELECT 
             id,
        sub_name,
        ac_id,
        sub_type,
        sub_code,
        sub_balance,
        store_id ,
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
          sub_name,
        ac_id,
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
      $this->sub_name = $row['ac_id'];
      $this->sub_type = $row['sub_type'];
     
  }



  //login
  public function login(){
    // Create query
    $query = 'SELECT
          id,
          sub_name,
        ac_id,
        sub_type ,
        store_id 
        FROM
          ' . $this->table . '
      WHERE sub_name=:sub_name AND ac_id=:ac_id AND store_id=:store_id';

      //Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind id
      $stmt->bindParam(':sub_name', $this->sub_name);
      $stmt->bindParam(':ac_id', $this->ac_id);
      $stmt->bindParam(':store_id', $this->store_id);

      // Execute query
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // set properties
      $this->id = $row['id'];
      $this->sub_name = $row['sub_name'];
      $this->ac_id = $row['ac_id'];
      $this->sub_type = $row['sub_type'];
      $this->store_id = $row['store_id'];
     
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

  // Create Category
  public function create() {
    // Create Query
    $query = 'INSERT INTO ' .
      $this->table . '
    SET
    ac_id = :ac_id ,sub_name = :sub_name ,sub_type = :sub_type,sub_balance = :sub_balance ,sub_code = :sub_code ,store_id = :store_id';
      
  // Prepare Statement
  $stmt = $this->conn->prepare($query);

  // Clean data
  $this->sub_name = htmlspecialchars(strip_tags($this->sub_name));
  $this->ac_id = htmlspecialchars(strip_tags($this->ac_id));
  $this->sub_type = htmlspecialchars(strip_tags($this->sub_type));
  $this->sub_balance = htmlspecialchars(strip_tags($this->sub_balance));
  $this->sub_code = htmlspecialchars(strip_tags($this->sub_code));
  $this->store_id = htmlspecialchars(strip_tags($this->store_id));
  

  // Bind data
  $stmt-> bindParam(':sub_name', $this->sub_name);
  $stmt-> bindParam(':ac_id', $this->ac_id);
  $stmt-> bindParam(':sub_type', $this->sub_type);
  $stmt-> bindParam(':sub_balance', $this->sub_balance);
  $stmt-> bindParam(':sub_code', $this->sub_code);
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
     sub_name = :sub_name , 
     ac_id = :ac_id , 
     sub_type = :sub_type ,
      sub_code = :sub_code ,
       sub_balance = :sub_balance ,
        store_id = :store_id   
       WHERE
     id = :id';

  // Prepare Statement
   $stmt = $this->conn->prepare($query);

  // Clean data
   $this->id = htmlspecialchars(strip_tags($this->id));
  $this->sub_name = htmlspecialchars(strip_tags($this->sub_name));
  $this->ac_id = htmlspecialchars(strip_tags($this->ac_id));
  $this->sub_type = htmlspecialchars(strip_tags($this->sub_type));
  $this->sub_balance = htmlspecialchars(strip_tags($this->sub_balance));
  $this->sub_code = htmlspecialchars(strip_tags($this->sub_code));
  $this->store_id = htmlspecialchars(strip_tags($this->store_id));
   
  

  // Bind data
   $stmt-> bindParam(':id', $this->id); 
 $stmt-> bindParam(':sub_name', $this->sub_name);
  $stmt-> bindParam(':ac_id', $this->ac_id);
  $stmt-> bindParam(':sub_type', $this->sub_type);
  $stmt-> bindParam(':sub_balance', $this->sub_balance);
  $stmt-> bindParam(':sub_code', $this->sub_code);
  $stmt-> bindParam(':store_id', $this->store_id);
 

 

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
