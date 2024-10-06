<?php
  class Sub_accounts {
    // DB Stuff
    private $conn;
    private $table = 'sub_accounts';
    
    // Properties
    public $id;
    public $sub_name;
    public $ac_id;
    public $sub_type;
    public $sub_balance;
    public $sub_code;
    public $store_id;
      public $phone;
        public $address;
    public $actype_id; 
    public $eng_name;
      public $ac_name;
    public $fromDebitTot;
    public $fromCreditTot;
    public $toDebitTot;
    public $toCreditTot;
     public $payTot;
      public $tot_prTot;
       public $changeeTot;
         public $purchPayTot;
           public $purchTot_prTot;
             public $purchChangeeTot;
  
    public $cat_name ;
     public $cat_id ;     
       public $yearId ;     
         
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
    sub_accounts.cat_name,
    sub_accounts.cat_id,
    accounts.actype_id,
    accounts.ac_name,
    accounts.eng_name,
    IFNULL((SELECT SUM(jdetails_from.debit) FROM jdetails_from  WHERE  jdetails_from.ac_id = sub_accounts.id AND jdetails_from.store_id = :store_id AND jdetails_from.yearId = :yearId), 0) AS fromDebitTot ,
    IFNULL((SELECT SUM(jdetails_from.credit) FROM jdetails_from  WHERE  jdetails_from.ac_id = sub_accounts.id AND jdetails_from.store_id = :store_id AND jdetails_from.yearId = :yearId), 0) AS fromCreditTot,
    IFNULL((SELECT SUM(jdetails_to.debit) FROM jdetails_to  WHERE  jdetails_to.ac_id = sub_accounts.id AND jdetails_to.store_id = :store_id AND jdetails_to.yearId = :yearId ), 0) AS toDebitTot,
    IFNULL((SELECT SUM(jdetails_to.credit) FROM jdetails_to  WHERE  jdetails_to.ac_id = sub_accounts.id AND jdetails_to.store_id = :store_id AND jdetails_to.yearId = :yearId), 0) AS toCreditTot
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
        $stmt->bindParam(':yearId', $this->yearId, PDO::PARAM_INT);
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
        sub_type,
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
             id,
        sub_name,
        ac_id,
        sub_type,
        sub_code,
        sub_balance,
        cat_id,
        cat_name,
        store_id,
         phone,
        address,
           IFNULL((SELECT SUM(jdetails_from.debit) FROM jdetails_from  WHERE  jdetails_from.ac_id = sub_accounts.id AND jdetails_from.store_id = :store_id AND jdetails_from.yearId = :yearId), 0) AS fromDebitTot ,
        IFNULL((SELECT SUM(jdetails_from.credit) FROM jdetails_from  WHERE  jdetails_from.ac_id = sub_accounts.id AND jdetails_from.store_id = :store_id AND jdetails_from.yearId = :yearId), 0) AS fromCreditTot,
         IFNULL((SELECT SUM(jdetails_to.debit) FROM jdetails_to  WHERE  jdetails_to.ac_id = sub_accounts.id AND jdetails_to.store_id = :store_id AND jdetails_to.yearId = :yearId), 0) AS toDebitTot,
         IFNULL((SELECT SUM(jdetails_to.credit) FROM jdetails_to  WHERE  jdetails_to.ac_id = sub_accounts.id AND jdetails_to.store_id = :store_id AND jdetails_to.yearId = :yearId ), 0) AS toCreditTot ,
          IFNULL((SELECT SUM(pay.tot_pr) FROM pay  WHERE  pay.cust_id = sub_accounts.id AND pay.store_id = :store_id  AND pay.yearId = :yearId ), 0) AS tot_prTot ,
          IFNULL((SELECT SUM(pay.changee) FROM pay  WHERE  pay.cust_id = sub_accounts.id AND pay.store_id = :store_id AND pay.yearId = :yearId ), 0) AS changeeTot ,
           IFNULL((SELECT SUM(pay.pay) FROM pay  WHERE  pay.cust_id = sub_accounts.id AND pay.store_id = :store_id AND pay.yearId = :yearId ), 0) AS payTot ,
            IFNULL((SELECT SUM(perch.tot_pr) FROM perch  WHERE  perch.cust_id = sub_accounts.id AND perch.store_id = :store_id AND perch.yearId = :yearId ), 0) AS purchTot_prTot ,
          IFNULL((SELECT SUM(perch.changee) FROM perch  WHERE  perch.cust_id = sub_accounts.id AND perch.store_id = :store_id AND perch.yearId = :yearId), 0) AS purchChangeeTot ,
           IFNULL((SELECT SUM(perch.pay) FROM perch  WHERE  perch.cust_id = sub_accounts.id AND perch.store_id = :store_id AND perch.yearId = :yearId), 0) AS purchPayTot 
          FROM
           ' . $this->table . ' 
          WHERE 
          store_id = :store_id  AND ac_id = :ac_id AND (cat_id = 2 OR cat_id = 1)
          ORDER BY
          id ASC
          ';
    
        //Prepare statement
        $stmt = $this->conn->prepare($query);
    
        // Bind pay_id
        $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT); 
        $stmt->bindParam(':ac_id', $this->ac_id, PDO::PARAM_INT); 
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
        ac_id,
        sub_type,
        sub_code,
        sub_balance,
        store_id ,
         cat_id,
        cat_name,
        IFNULL((SELECT SUM(jdetails_from.debit) FROM jdetails_from  WHERE  jdetails_from.ac_id = sub_accounts.id AND jdetails_from.store_id = :store_id AND jdetails_from.yearId = :yearId), 0) AS fromDebitTot ,
        IFNULL((SELECT SUM(jdetails_from.credit) FROM jdetails_from  WHERE  jdetails_from.ac_id = sub_accounts.id AND jdetails_from.store_id = :store_id AND jdetails_from.yearId = :yearId), 0) AS fromCreditTot,
         IFNULL((SELECT SUM(jdetails_to.debit) FROM jdetails_to  WHERE  jdetails_to.ac_id = sub_accounts.id AND jdetails_to.store_id = :store_id  AND jdetails_to.yearId = :yearId ), 0) AS toDebitTot,
         IFNULL((SELECT SUM(jdetails_to.credit) FROM jdetails_to  WHERE  jdetails_to.ac_id = sub_accounts.id AND jdetails_to.store_id = :store_id AND  jdetails_to.yearId = :yearId), 0) AS toCreditTot
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
    ac_id = :ac_id ,sub_name = :sub_name ,sub_type = :sub_type,sub_balance = :sub_balance ,sub_code = :sub_code ,cat_id = :cat_id,cat_name = :cat_name, store_id = :store_id, phone = :phone, address = :address';
      
  // Prepare Statement
  $stmt = $this->conn->prepare($query);

  // Clean data
  $this->sub_name = htmlspecialchars(strip_tags($this->sub_name));
  $this->ac_id = htmlspecialchars(strip_tags($this->ac_id));
  $this->sub_type = htmlspecialchars(strip_tags($this->sub_type));
  $this->sub_balance = htmlspecialchars(strip_tags($this->sub_balance));
  $this->sub_code = htmlspecialchars(strip_tags($this->sub_code));
  $this->store_id = htmlspecialchars(strip_tags($this->store_id));
  $this->cat_name = htmlspecialchars(strip_tags($this->cat_name));
  $this->cat_id = htmlspecialchars(strip_tags($this->cat_id));
    $this->phone = htmlspecialchars(strip_tags($this->phone));
    $this->address = htmlspecialchars(strip_tags($this->address));
        

  // Bind data
  $stmt-> bindParam(':sub_name', $this->sub_name);
  $stmt-> bindParam(':ac_id', $this->ac_id);
  $stmt-> bindParam(':sub_type', $this->sub_type);
  $stmt-> bindParam(':sub_balance', $this->sub_balance);
  $stmt-> bindParam(':sub_code', $this->sub_code);
  $stmt-> bindParam(':store_id', $this->store_id);
  $stmt-> bindParam(':cat_name', $this->cat_name);
  $stmt-> bindParam(':cat_id', $this->cat_id);
    $stmt-> bindParam(':phone', $this->phone);
    $stmt-> bindParam(':address', $this->address);
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
       cat_id = :cat_id,
       cat_name = :cat_name ,
        store_id = :store_id ,
        phone = :phone,
        address = :address  
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
   $this->phone = htmlspecialchars(strip_tags($this->phone));
    $this->address = htmlspecialchars(strip_tags($this->address));
    $this->cat_name = htmlspecialchars(strip_tags($this->cat_name));
  $this->cat_id = htmlspecialchars(strip_tags($this->cat_id));
  

  // Bind data
   $stmt-> bindParam(':id', $this->id); 
 $stmt-> bindParam(':sub_name', $this->sub_name);
  $stmt-> bindParam(':ac_id', $this->ac_id);
  $stmt-> bindParam(':sub_type', $this->sub_type);
  $stmt-> bindParam(':sub_balance', $this->sub_balance);
  $stmt-> bindParam(':sub_code', $this->sub_code);
  $stmt-> bindParam(':store_id', $this->store_id);
   $stmt-> bindParam(':phone', $this->phone);
    $stmt-> bindParam(':address', $this->address);
  $stmt-> bindParam(':cat_name', $this->cat_name);
  $stmt-> bindParam(':cat_id', $this->cat_id);

 

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
