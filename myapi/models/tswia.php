<?php
  class Tswia {
    // DB Stuff
    private $conn;
    private $table = 'tswia';

    // Properties
    public $pay_id;
    public $pay_ref;
    public $tot_pr; 
    public $pay_date; 
    public $pay_time;
    public $cust_id;
    public $discount;
    public $changee;
    public $user_id; 
    public $pay;
    public $store_id;
    public $pay_method;
    public $payComment;
    public $nextPay;
       public $yearId;

    public $pay_date2; 

    public $sub_name;
    public $user_name;
    
    
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
    
    
    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get all record //for admin app
    public function read() {
      // Create query
      $query = 'SELECT
        pay_id,
        pay_ref,
        tot_pr, 
        pay_date,
        pay_time,
        cust_id,
        discount,
        changee,
        user_id,
        pay,
        store_id,
        pay_method,
        payComment,
        nextPay,
        yearId
      FROM
        ' . $this->table . '
      ORDER BY
        pay_id DESC';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }


/// read for spacific branch store
public function readByStore(){
  // Create query
  $query = 'SELECT 
        pay_id,
        pay_ref,
        tot_pr, 
        pay_date,
        pay_time, 
        user_id, 
        store_id, 
        payComment, 
        yearId

      FROM
       ' . $this->table . ' 
      WHERE 
      store_id = :store_id  AND yearId = :yearId
      ORDER BY
      pay_id ASC
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


public function readNotifByStore(){
  // Create query
  $query = 'SELECT 
        tswia.pay_id,
        tswia.pay_ref,
        tswia.tot_pr, 
        tswia.pay_date, 
        tswia.changee,
        tswia.user_id, 
        tswia.store_id, 
        tswia.payComment, 
         tswia.yearId
      FROM
       ' . $this->table . ' 
      WHERE 
      tswia.store_id = :store_id  AND tswia.yearId = :yearId
      ORDER BY
      tswia.pay_id ASC
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



public function getTopSales(){
  // Create query
  $query = 'SELECT 
        tswia.pay_id,
        tswia.pay_ref,
        tswia.tot_pr, 
        tswia.pay_date,
        tswia.pay_time, 
        tswia.user_id,
        tswia.store_id,
        tswia.payComment,
        tswia.yearId,  
        IFNULL((SELECT full_name FROM users  WHERE  users.id = tswia.user_id ), 0) AS user_name

      FROM
       ' . $this->table . ' 
      
      WHERE 
      tswia.store_id = :store_id  AND tswia.yearId = :yearId 
      ORDER BY
      tswia.pay_date DESC
      ';
 // LIMIT 40
    //Prepare statement
    $stmt = $this->conn->prepare($query);

    // Bind pay_id
    $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT); 
    $stmt->bindParam(':yearId', $this->yearId, PDO::PARAM_INT); 

    // Execute query
    $stmt->execute();

    return $stmt ;
   
}

public function getSalesByDate(){
  // Create query
  $query = 'SELECT 
        tswia.pay_id,
        tswia.pay_ref,
        tswia.tot_pr, 
        tswia.pay_date,
        tswia.pay_time, 
        tswia.user_id, 
        tswia.store_id, 
        tswia.payComment, 
        tswia.yearId,
        IFNULL((SELECT full_name FROM users  WHERE  users.id = tswia.user_id ), 0) AS user_name

      FROM
       ' . $this->table . ' 
      
      WHERE 
      tswia.store_id = :store_id  AND  tswia.pay_date = :from AND tswia.yearId = :yearId
      ORDER BY
      tswia.pay_date DESC
      ';

    //Prepare statement
    $stmt = $this->conn->prepare($query);

    // Bind pay_id
    $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT); 
    $stmt->bindParam(':from', $this->pay_date, PDO::PARAM_STR); 
     $stmt->bindParam(':yearId', $this->yearId, PDO::PARAM_INT); 

    // Execute query
    $stmt->execute();

    return $stmt ;
   
}

public function getSales2Date(){
  // Create query
  $query = 'SELECT 
        tswia.pay_id,
        tswia.pay_ref,
        tswia.tot_pr, 
        tswia.pay_date,
        tswia.pay_time, 
        tswia.user_id, 
        tswia.store_id, 
        tswia.payComment, 
        tswia.yearId ,
        IFNULL((SELECT full_name FROM users  WHERE  users.id = tswia.user_id ), 0) AS user_name 
      FROM
       ' . $this->table . ' 
       
      WHERE 
      tswia.store_id = :store_id  AND  tswia.yearId = :yearId  AND  tswia.pay_date >= :from AND  tswia.pay_date <= :to 
      ORDER BY
      tswia.pay_date DESC
      ';

    //Prepare statement
    $stmt = $this->conn->prepare($query);

    // Bind pay_id
    $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT); 
    $stmt->bindParam(':from', $this->pay_date, PDO::PARAM_STR); 
    $stmt->bindParam(':to', $this->pay_date2, PDO::PARAM_STR); 
     $stmt->bindParam(':yearId', $this->yearId, PDO::PARAM_INT); 

    // Execute query
    $stmt->execute();

    return $stmt ;
   
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

public function create() {
  // Create Query
  $query = 'INSERT INTO ' .
  $this->table . '
  SET   
   pay_ref = :pay_ref ,
   store_id = :store_id,
   tot_pr = :tot_pr, 
   
   pay_date = :pay_date, 
   pay_time = :pay_time,
  payComment = :payComment, 
  user_id = :user_id ,
  yearId = :yearId 
   ';
    
   // Prepare Statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->pay_ref = htmlspecialchars(strip_tags($this->pay_ref));
    $this->tot_pr = htmlspecialchars(strip_tags($this->tot_pr));
    $this->pay_date = htmlspecialchars(strip_tags($this->pay_date));
    $this->pay_time = htmlspecialchars(strip_tags($this->pay_time));
 
    $this->user_id = htmlspecialchars(strip_tags($this->user_id)); 
    $this->store_id = htmlspecialchars(strip_tags($this->store_id));
    
  $this->payComment = htmlspecialchars(strip_tags($this->payComment));
  
  $this->yearId = htmlspecialchars(strip_tags($this->yearId));
  
    // Bind data
    $stmt-> bindParam(':pay_ref', $this->pay_ref);
    $stmt-> bindParam(':tot_pr', $this->tot_pr);
    $stmt-> bindParam(':pay_date', $this->pay_date);
    $stmt-> bindParam(':pay_time', $this->pay_time);
 
    $stmt-> bindParam(':user_id', $this->user_id);
    
    $stmt-> bindParam(':store_id', $this->store_id);
  
     $stmt-> bindParam(':payComment', $this->payComment);
   
     $stmt-> bindParam(':yearId', $this->yearId);

    // Execute query
   if($this->pay_ref == '') {
    return true;
  }else{
      if($stmt->execute()) {
    return true;
  }

  // Print error if something goes wrong
  printf("Error: $s.\n", $stmt->error);

  return false; 
  }

    }

 


public function update() {
  // Create Query
   $query = 'UPDATE ' .
    $this->table . '
   SET
   pay_ref = :pay_ref ,
   store_id = :store_id,
   tot_pr = :tot_pr, 
   pay_date = :pay_date, 
   pay_time = :pay_time,
   payComment = :payComment, 
   user_id = :user_id ,
    yearId = :yearId 
   WHERE
   pay_id = :pay_id';

// Prepare Statement
 $stmt = $this->conn->prepare($query);

// Clean data
 $this->pay_id = htmlspecialchars(strip_tags($this->pay_id));
 $this->pay_ref = htmlspecialchars(strip_tags($this->pay_ref));
 $this->tot_pr = htmlspecialchars(strip_tags($this->tot_pr));
 $this->pay_date = htmlspecialchars(strip_tags($this->pay_date));
 $this->pay_time = htmlspecialchars(strip_tags($this->pay_time));
 
 $this->user_id = htmlspecialchars(strip_tags($this->user_id));
 
 $this->store_id = htmlspecialchars(strip_tags($this->store_id));
 
$this->payComment = htmlspecialchars(strip_tags($this->payComment)); 
  $this->yearId = htmlspecialchars(strip_tags($this->yearId));
  // Bind data
 $stmt-> bindParam(':pay_id', $this->pay_id); 
 $stmt-> bindParam(':pay_ref', $this->pay_ref);
 $stmt-> bindParam(':tot_pr', $this->tot_pr);
 $stmt-> bindParam(':pay_date', $this->pay_date);
 $stmt-> bindParam(':pay_time', $this->pay_time); 
 $stmt-> bindParam(':user_id', $this->user_id); 
 $stmt-> bindParam(':store_id', $this->store_id); 
 $stmt-> bindParam(':payComment', $this->payComment); 
  
 $stmt-> bindParam(':yearId', $this->yearId);

  // Execute query
 if($stmt->execute()) {
  return true;
 }   // Print error if something goes wrong
  printf("Error: $s.\n", $stmt->error);

 return false;
}

public function delete() {
  // Create query
  $query = 'DELETE FROM ' . $this->table . ' WHERE pay_id = :pay_id';

  // Prepare Statement
  $stmt = $this->conn->prepare($query);

  // clean data
  $this->pay_id = htmlspecialchars(strip_tags($this->pay_id));

  // Bind Data
  $stmt-> bindParam(':pay_id', $this->pay_id);

  // Execute query
  if($stmt->execute()) {
    return true;
  }

  // Print error if something goes wrong
  printf("Error: $s.\n", $stmt->error);

  return false;
  }


}

