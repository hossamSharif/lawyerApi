<?php
  class LogHistory {
    // DB Stuff
    private $conn;
    private $table = 'logHistory';

    // Properties
    public $id;
    public $logRef;  
    public $datee;   
    public $userId; 
    public $logStatus;
    public $store_id;
    public $typee;
    public $logToken; 
    public $yearId;   
    public $full_name;
    
    
     
    
    
    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }
 
/// read for spacific branch store
public function readByStore(){
  // Create query
  $query = 'SELECT 
  logHistory.id,
  logHistory.logRef, 
  logHistory.datee,  
  logHistory.userId,
  logHistory.logStatus,
  logHistory.store_id,
  logHistory.typee,
  logHistory.logToken, 
  logHistory.yearId,
  IFNULL((SELECT full_name FROM users  WHERE  users.id = logHistory.userId ), 0) AS full_name 
      FROM
       ' . $this->table . ' 
      WHERE 
      logHistory.store_id = :store_id  AND logHistory.yearId = :yearId AND logHistory.datee >= :from
      ORDER BY
      id DESC
      ';

    //Prepare statement
    $stmt = $this->conn->prepare($query);

    // Bind id
    $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT); 
    $stmt->bindParam(':yearId', $this->yearId, PDO::PARAM_INT); 
    $stmt->bindParam(':from', $this->datee, PDO::PARAM_STR); 
    // Execute query
    $stmt->execute();

    return $stmt ;
   
}


 
 
 public function readAllByStore(){
  // Create query
  $query = 'SELECT 
  logHistory.id,
  logHistory.logRef, 
  logHistory.datee,  
  logHistory.userId,
  logHistory.logStatus,
  logHistory.store_id,
  logHistory.typee,
  logHistory.logToken, 
  logHistory.yearId,
  IFNULL((SELECT full_name FROM users  WHERE  users.id = logHistory.userId ), 0) AS full_name 
      FROM
       ' . $this->table . ' 
      WHERE 
      logHistory.store_id = :store_id  AND logHistory.yearId = :yearId 
      ORDER BY
      id DESC
      ';

    //Prepare statement
    $stmt = $this->conn->prepare($query);

    // Bind id
    $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT); 
    $stmt->bindParam(':yearId', $this->yearId, PDO::PARAM_INT); 
    // Execute query
    $stmt->execute();

    return $stmt ;
   
}

 


public function getTopSales(){
  // Create query
  $query = 'SELECT 
        pay.id,
        pay.logRef,
        pay.tot_pr, 
        pay.datee,
        pay.pay_time,
        pay.cust_id,
        pay.discount,
        pay.changee,
        pay.userId,
        pay.pay,
        pay.store_id,
        pay.typee ,
        pay.logToken,
        pay.nextPay,
         pay.yearId,
        sub_accounts.sub_name, 
        IFNULL((SELECT full_name FROM users  WHERE  users.id = pay.userId ), 0) AS user_name

      FROM
       ' . $this->table . ' 
      INNER JOIN  
      sub_accounts ON pay.cust_id = sub_accounts.id
      WHERE 
      pay.store_id = :store_id  AND sub_accounts.store_id = :store_id AND pay.yearId = :yearId 
      ORDER BY
      pay.datee DESC
      ';
 // LIMIT 40
    //Prepare statement
    $stmt = $this->conn->prepare($query);

    // Bind id
    $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT); 
    $stmt->bindParam(':yearId', $this->yearId, PDO::PARAM_INT); 

    // Execute query
    $stmt->execute();

    return $stmt ;
   
}

public function getSalesByDate(){
  // Create query
  $query = 'SELECT 
        pay.id,
        pay.logRef,
        pay.tot_pr, 
        pay.datee,
        pay.pay_time,
        pay.cust_id,
        pay.discount,
        pay.changee,
        pay.userId,
        pay.pay,
        pay.store_id,
        pay.typee ,
        pay.logToken,
         pay.nextPay,
        pay.yearId,
        sub_accounts.sub_name,
        IFNULL((SELECT full_name FROM users  WHERE  users.id = pay.userId ), 0) AS user_name

      FROM
       ' . $this->table . ' 
      INNER JOIN  
      sub_accounts ON pay.cust_id = sub_accounts.id
      WHERE 
      pay.store_id = :store_id  AND sub_accounts.store_id = :store_id AND  pay.datee = :from AND pay.yearId = :yearId
      ORDER BY
      pay.datee DESC
      ';

    //Prepare statement
    $stmt = $this->conn->prepare($query);

    // Bind id
    $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT); 
    $stmt->bindParam(':from', $this->datee, PDO::PARAM_STR); 
     $stmt->bindParam(':yearId', $this->yearId, PDO::PARAM_INT); 

    // Execute query
    $stmt->execute();

    return $stmt ;
   
}

public function getSales2Date(){
  // Create query
  $query = 'SELECT 
        pay.id,
        pay.logRef,
        pay.tot_pr, 
        pay.datee,
        pay.pay_time,
        pay.cust_id,
        pay.discount,
        pay.changee,
        pay.userId,
        pay.pay,
        pay.store_id,
        pay.typee ,
        pay.logToken,
         pay.nextPay,
         pay.yearId,
        sub_accounts.sub_name,
        IFNULL((SELECT full_name FROM users  WHERE  users.id = pay.userId ), 0) AS user_name

      FROM
       ' . $this->table . ' 
      INNER JOIN  
      sub_accounts ON pay.cust_id = sub_accounts.id
      WHERE 
      pay.store_id = :store_id  AND sub_accounts.store_id = :store_id AND pay.yearId = :yearId  AND  pay.datee >= :from AND  pay.datee <= :to 
      ORDER BY
      pay.datee DESC
      ';

    //Prepare statement
    $stmt = $this->conn->prepare($query);

    // Bind id
    $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT); 
    $stmt->bindParam(':from', $this->datee, PDO::PARAM_STR); 
    $stmt->bindParam(':to', $this->datee2, PDO::PARAM_STR); 
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
   logRef = :logRef ,
   store_id = :store_id,  
   datee = :datee,
   typee = :typee, 
  logToken = :logToken,
  logStatus = :logStatus,
  userId = :userId ,
  yearId = :yearId 
   ';
    
   // Prepare Statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->logRef = htmlspecialchars(strip_tags($this->logRef));
    $this->tot_pr = htmlspecialchars(strip_tags($this->tot_pr));
    $this->datee = htmlspecialchars(strip_tags($this->datee));
    $this->userId = htmlspecialchars(strip_tags($this->userId));
    $this->store_id = htmlspecialchars(strip_tags($this->store_id));
    $this->typee = htmlspecialchars(strip_tags($this->typee));
    $this->logToken = htmlspecialchars(strip_tags($this->logToken));
    $this->logStatus = htmlspecialchars(strip_tags($this->logStatus));
    $this->yearId = htmlspecialchars(strip_tags($this->yearId));
  
    // Bind data
    $stmt-> bindParam(':logRef', $this->logRef); 
    $stmt-> bindParam(':datee', $this->datee);   
    $stmt-> bindParam(':userId', $this->userId); 
    $stmt-> bindParam(':store_id', $this->store_id);
    $stmt-> bindParam(':typee', $this->typee);
     $stmt-> bindParam(':logToken', $this->logToken);
    $stmt-> bindParam(':logStatus', $this->logStatus);
     $stmt-> bindParam(':yearId', $this->yearId);

    // Execute query
   if($this->logRef == '') {
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
   logRef = :logRef ,
   store_id = :store_id, 
   changee = :changee,
   datee = :datee,
   typee = :typee,  
   logToken = :logToken,
   logStatus = :logStatus,
   userId = :userId ,
    yearId = :yearId 
   WHERE
   id = :id';

// Prepare Statement
 $stmt = $this->conn->prepare($query);

// Clean data
 $this->id = htmlspecialchars(strip_tags($this->id));
 $this->logRef = htmlspecialchars(strip_tags($this->logRef)); 
 $this->datee = htmlspecialchars(strip_tags($this->datee)); 
 $this->discount = htmlspecialchars(strip_tags($this->discount));
 $this->changee = htmlspecialchars(strip_tags($this->changee));
 $this->userId = htmlspecialchars(strip_tags($this->userId)); 
 $this->store_id = htmlspecialchars(strip_tags($this->store_id));
 $this->typee = htmlspecialchars(strip_tags($this->typee));
 $this->logToken = htmlspecialchars(strip_tags($this->logToken));
 $this->logStatus = htmlspecialchars(strip_tags($this->logStatus));
  $this->yearId = htmlspecialchars(strip_tags($this->yearId));
  // Bind data
 $stmt-> bindParam(':id', $this->id); 
 $stmt-> bindParam(':logRef', $this->logRef);
 $stmt-> bindParam(':tot_pr', $this->tot_pr);
 $stmt-> bindParam(':datee', $this->datee); 
 $stmt-> bindParam(':userId', $this->userId); 
 $stmt-> bindParam(':store_id', $this->store_id);
 $stmt-> bindParam(':typee', $this->typee); 
 $stmt-> bindParam(':logToken', $this->logToken); 
 $stmt-> bindParam(':logStatus', $this->logStatus); 
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

