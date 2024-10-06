<?php
  class Discount {
    // DB Stuff
    private $conn;
    private $table = 'discount';

    // Properties
    public $id;  
    public $from_date; 
    public $to_date;
    public $perc; 
    public $descr;
    public $user_id;  
    public $store_id; 
    public $yearId;
    public $user_name;
    public $status; 
    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get all record //for admin app
    public function read() {
      // Create query
      $query = 'SELECT
        id,
        pay_ref,  
        from_date,
        to_date,
        perc, 
        descr,
        user_id,
        pay,
        store_id,
        pay_method,
        payComment,
        nextPay,
        yearId ,
        companyId,
             arName,
             engName,
             address, 
             phone,
             phone2 ,
             vatNo ,
             tradNo,
             logoUrl 
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


/// read for spacific branch store
public function readByStore(){
  // Create query
  $query = 'SELECT 
        id,  
        from_date,
        to_date,
        perc,
        discount,
        descr,
        user_id, 
        store_id, 
        yearId ,
        status
      FROM
       ' . $this->table . ' 
      WHERE 
      store_id = :store_id  AND yearId = :yearId
      ORDER BY
      id ASC
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
        discount.id,  
        discount.from_date,
        discount.to_date,
        discount.perc, 
        discount.descr,
        discount.user_id, 
        discount.store_id, 
        discount.yearId, 
        discount.status,  
        IFNULL((SELECT full_name FROM users  WHERE  users.id = discount.user_id ), 0) AS user_name  

      FROM
       ' . $this->table . '  
      WHERE 
      discount.store_id = :store_id   AND discount.yearId = :yearId 
      ORDER BY
      discount.id DESC
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


public function getSalesById(){
  // Create query
  $query = 'SELECT 
        discount.id, 
        discount.from_date,
        discount.to_date,
        discount.perc,
        discount.discount,
        discount.descr,
        discount.user_id,
        discount.store_id,
        discount.yearId,
        discount.status,
        IFNULL((SELECT full_name FROM users  WHERE  users.id = discount.user_id ), 0) AS user_name 

      FROM
       ' . $this->table . ' 
      
      WHERE 
      discount.store_id = :store_id  AND discount.yearId = :yearId AND discount.id = :id
      ORDER BY
      discount.from_date DESC
      ';

    //Prepare statement
    $stmt = $this->conn->prepare($query);
    // Bind id
    $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT);  
    $stmt->bindParam(':yearId', $this->yearId, PDO::PARAM_INT); 
    $stmt->bindParam(':id', $this->id, PDO::PARAM_INT); 
    // Execute query
    $stmt->execute();
    return $stmt ;
   
}

public function getSalesByDate(){
  // Create query
  $query = 'SELECT 
  discount.id, 
        discount.from_date,
        discount.to_date,
        discount.perc,
        discount.discount,
        discount.descr,
        discount.user_id,
        discount.store_id,
        discount.yearId,
         discount.status,
        IFNULL((SELECT full_name FROM users  WHERE  users.id = discount.user_id ), 0) AS user_name 


      FROM
       ' . $this->table . ' 
      INNER JOIN  
      sub_accounts ON discount.perc = sub_accounts.id
      WHERE 
      discount.store_id = :store_id  AND sub_accounts.store_id = :store_id AND  discount.from_date = :from AND discount.yearId = :yearId
      ORDER BY
      discount.from_date DESC
      ';

    //Prepare statement
    $stmt = $this->conn->prepare($query);

    // Bind id
    $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT); 
    $stmt->bindParam(':from', $this->from_date, PDO::PARAM_STR); 
     $stmt->bindParam(':yearId', $this->yearId, PDO::PARAM_INT); 

    // Execute query
    $stmt->execute();

    return $stmt ;
   
}

public function getSales2Date(){
  // Create query
  $query = 'SELECT 
  discount.id, 
        discount.from_date,
        discount.to_date,
        discount.perc,
        discount.discount,
        discount.descr,
        discount.user_id,
        discount.store_id,
        discount.yearId,
         discount.status,
        IFNULL((SELECT full_name FROM users  WHERE  users.id = discount.user_id ), 0) AS user_name 


      FROM
       ' . $this->table . ' 
      INNER JOIN  
      sub_accounts ON discount.perc = sub_accounts.id
      WHERE 
      discount.store_id = :store_id  AND sub_accounts.store_id = :store_id AND discount.yearId = :yearId  AND  discount.from_date >= :from AND  discount.from_date <= :to 
      ORDER BY
      discount.from_date DESC
      ';

    //Prepare statement
    $stmt = $this->conn->prepare($query);

    // Bind id
    $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT); 
    $stmt->bindParam(':from', $this->from_date, PDO::PARAM_STR); 
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
   store_id = :store_id,  
   descr = :descr,
   from_date = :from_date,
   perc = :perc,
   to_date = :to_date,
   
  user_id = :user_id ,
  yearId = :yearId  ,
   status = :status  
   
   ';
    
   // Prepare Statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    
   
    $this->from_date = htmlspecialchars(strip_tags($this->from_date));
    $this->to_date = htmlspecialchars(strip_tags($this->to_date));
    $this->perc = htmlspecialchars(strip_tags($this->perc));
    
    $this->descr = htmlspecialchars(strip_tags($this->descr));
    $this->user_id = htmlspecialchars(strip_tags($this->user_id));
    
    $this->store_id = htmlspecialchars(strip_tags($this->store_id));
    
    $this->yearId = htmlspecialchars(strip_tags($this->yearId));
    $this->status = htmlspecialchars(strip_tags($this->status));
  
  
    // Bind data
  
    $stmt-> bindParam(':from_date', $this->from_date);
    $stmt-> bindParam(':to_date', $this->to_date);
    $stmt-> bindParam(':perc', $this->perc);
    $stmt-> bindParam(':descr', $this->descr);
    $stmt-> bindParam(':user_id', $this->user_id); 
    $stmt-> bindParam(':store_id', $this->store_id); 
    $stmt-> bindParam(':yearId', $this->yearId); 
    $stmt-> bindParam(':status', $this->status); 

    // Execute query
   
    if($stmt->execute()) {
      return true;
     }   // Print error if something goes wrong
      printf("Error: $s.\n", $stmt->error);
    
     return false; 
  }

    

 


public function update() {
  // Create Query
   $query = 'UPDATE ' .
    $this->table . '
   SET
   
   store_id = :store_id,
   
   pay = :pay,
   descr = :descr,
   from_date = :from_date,
   pay_method = :pay_method,
   perc = :perc,
   discount = :discount,
   to_date = :to_date,
   
   user_id = :user_id ,
   yearId = :yearId ,
   status = :status

   
   WHERE
   id = :id';

// Prepare Statement
 $stmt = $this->conn->prepare($query);

// Clean data
 $this->id = htmlspecialchars(strip_tags($this->id)); 
 $this->from_date = htmlspecialchars(strip_tags($this->from_date));
 $this->to_date = htmlspecialchars(strip_tags($this->to_date));
 $this->perc = htmlspecialchars(strip_tags($this->perc));
 $this->discount = htmlspecialchars(strip_tags($this->discount));
 $this->descr = htmlspecialchars(strip_tags($this->descr));
 $this->user_id = htmlspecialchars(strip_tags($this->user_id)); 
 $this->store_id = htmlspecialchars(strip_tags($this->store_id)); 
 $this->yearId = htmlspecialchars(strip_tags($this->yearId));
 $this->status = htmlspecialchars(strip_tags($this->status));
  
  // Bind data
 $stmt-> bindParam(':id', $this->id); 
  
 $stmt-> bindParam(':tot_pr', $this->tot_pr);
 $stmt-> bindParam(':from_date', $this->from_date);
 $stmt-> bindParam(':to_date', $this->to_date);
 $stmt-> bindParam(':perc', $this->perc);
 $stmt-> bindParam(':discount', $this->discount); 
 $stmt-> bindParam(':descr', $this->descr);
 $stmt-> bindParam(':user_id', $this->user_id); 
 $stmt-> bindParam(':store_id', $this->store_id); 
 $stmt-> bindParam(':yearId', $this->yearId); 
 $stmt-> bindParam(':status', $this->status); 
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

