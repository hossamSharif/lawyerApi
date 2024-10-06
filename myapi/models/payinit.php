<?php
  class Pay {
    // DB Stuff
    private $conn;
    private $table = 'payinit';

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
      

    public $pay_date2; 

    public $sub_name;
    public $user_name;
    
    
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
        nextPay
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
        cust_id,
        discount,
        changee,
        user_id,
        pay,
        store_id,
        pay_method,
        payComment,
        nextPay

      FROM
       ' . $this->table . ' 
      WHERE 
      store_id = :store_id  
      ORDER BY
      pay_id ASC
      ';

    //Prepare statement
    $stmt = $this->conn->prepare($query);

    // Bind pay_id
    $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT); 
    

    // Execute query
    $stmt->execute();

    return $stmt ;
   
}

public function getTopSales(){
  // Create query
  $query = 'SELECT 
        payinit.pay_id,
        payinit.pay_ref,
        payinit.tot_pr, 
        payinit.pay_date,
        payinit.pay_time,
        payinit.cust_id,
        payinit.discount,
        payinit.changee,
        payinit.user_id,
        payinit.pay,
        payinit.store_id,
        payinit.pay_method ,
        payinit.payComment,
        payinit.nextPay,
        sub_accounts.sub_name,
        IFNULL((SELECT full_name FROM users  WHERE  users.id = payinit.user_id ), 0) AS user_name 
      FROM
       ' . $this->table . ' 
      INNER JOIN  
      sub_accounts ON payinit.cust_id = sub_accounts.id
      WHERE 
      payinit.store_id = :store_id  AND sub_accounts.store_id = :store_id 
      ORDER BY
      payinit.pay_date DESC
      ';
 // LIMIT 40
    //Prepare statement
    $stmt = $this->conn->prepare($query);

    // Bind pay_id
    $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT); 
    

    // Execute query
    $stmt->execute();

    return $stmt ;
   
}

public function getSalesByDate(){
  // Create query
  $query = 'SELECT 
        payinit.pay_id,
        payinit.pay_ref,
        payinit.tot_pr, 
        payinit.pay_date,
        payinit.pay_time,
        payinit.cust_id,
        payinit.discount,
        payinit.changee,
        payinit.user_id,
        payinit.pay,
        payinit.store_id,
        payinit.pay_method ,
        payinit.payComment,
          payinit.nextPay,
        sub_accounts.sub_name,
        IFNULL((SELECT full_name FROM users  WHERE  users.id = payinit.user_id ), 0) AS user_name

      FROM
       ' . $this->table . ' 
      INNER JOIN  
      sub_accounts ON payinit.cust_id = sub_accounts.id
      WHERE 
      payinit.store_id = :store_id  AND sub_accounts.store_id = :store_id AND  payinit.pay_date = :from
      ORDER BY
      payinit.pay_date DESC
      ';

    //Prepare statement
    $stmt = $this->conn->prepare($query);

    // Bind pay_id
    $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT); 
    $stmt->bindParam(':from', $this->pay_date, PDO::PARAM_STR); 
    

    // Execute query
    $stmt->execute();

    return $stmt ;
   
}

public function getSales2Date(){
  // Create query
  $query = 'SELECT 
        payinit.pay_id,
        payinit.pay_ref,
        payinit.tot_pr, 
        payinit.pay_date,
        payinit.pay_time,
        payinit.cust_id,
        payinit.discount,
        payinit.changee,
        payinit.user_id,
        payinit.pay,
        payinit.store_id,
        payinit.pay_method ,
        payinit.payComment,
         payinit.nextPay,
        sub_accounts.sub_name,
        IFNULL((SELECT full_name FROM users  WHERE  users.id = payinit.user_id ), 0) AS user_name

      FROM
       ' . $this->table . ' 
      INNER JOIN  
      sub_accounts ON payinit.cust_id = sub_accounts.id
      WHERE 
      payinit.store_id = :store_id  AND sub_accounts.store_id = :store_id  AND  payinit.pay_date >= :from AND  payinit.pay_date <= :to 
      ORDER BY
      payinit.pay_date DESC
      ';

    //Prepare statement
    $stmt = $this->conn->prepare($query);

    // Bind pay_id
    $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT); 
    $stmt->bindParam(':from', $this->pay_date, PDO::PARAM_STR); 
    $stmt->bindParam(':to', $this->pay_date2, PDO::PARAM_STR); 
    

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
   pay = :pay,
   changee = :changee,
   pay_date = :pay_date,
   pay_method = :pay_method,
   cust_id = :cust_id,
   discount = :discount,
   pay_time = :pay_time,
  payComment = :payComment,
  nextPay = :nextPay,
  user_id = :user_id 
   ';
    
   // Prepare Statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->pay_ref = htmlspecialchars(strip_tags($this->pay_ref));
    $this->tot_pr = htmlspecialchars(strip_tags($this->tot_pr));
    $this->pay_date = htmlspecialchars(strip_tags($this->pay_date));
    $this->pay_time = htmlspecialchars(strip_tags($this->pay_time));
    $this->cust_id = htmlspecialchars(strip_tags($this->cust_id));
    $this->discount = htmlspecialchars(strip_tags($this->discount));
    $this->changee = htmlspecialchars(strip_tags($this->changee));
    $this->user_id = htmlspecialchars(strip_tags($this->user_id));
    $this->pay = htmlspecialchars(strip_tags($this->pay));
    $this->store_id = htmlspecialchars(strip_tags($this->store_id));
    $this->pay_method = htmlspecialchars(strip_tags($this->pay_method));
  $this->payComment = htmlspecialchars(strip_tags($this->payComment));
  $this->nextPay = htmlspecialchars(strip_tags($this->nextPay));
    // Bind data
    $stmt-> bindParam(':pay_ref', $this->pay_ref);
    $stmt-> bindParam(':tot_pr', $this->tot_pr);
    $stmt-> bindParam(':pay_date', $this->pay_date);
    $stmt-> bindParam(':pay_time', $this->pay_time);
    $stmt-> bindParam(':cust_id', $this->cust_id);
    $stmt-> bindParam(':discount', $this->discount); 
    $stmt-> bindParam(':changee', $this->changee);
    $stmt-> bindParam(':user_id', $this->user_id);
    $stmt-> bindParam(':pay', $this->pay);
    $stmt-> bindParam(':store_id', $this->store_id);
    $stmt-> bindParam(':pay_method', $this->pay_method);
     $stmt-> bindParam(':payComment', $this->payComment);
    $stmt-> bindParam(':nextPay', $this->nextPay);

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
   pay = :pay,
   changee = :changee,
   pay_date = :pay_date,
   pay_method = :pay_method,
   cust_id = :cust_id,
   discount = :discount,
   pay_time = :pay_time,
   payComment = :payComment,
   nextPay = :nextPay,
   user_id = :user_id  
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
 $this->cust_id = htmlspecialchars(strip_tags($this->cust_id));
 $this->discount = htmlspecialchars(strip_tags($this->discount));
 $this->changee = htmlspecialchars(strip_tags($this->changee));
 $this->user_id = htmlspecialchars(strip_tags($this->user_id));
 $this->pay = htmlspecialchars(strip_tags($this->pay));
 $this->store_id = htmlspecialchars(strip_tags($this->store_id));
 $this->pay_method = htmlspecialchars(strip_tags($this->pay_method));
$this->payComment = htmlspecialchars(strip_tags($this->payComment));
 $this->nextPay = htmlspecialchars(strip_tags($this->nextPay));
 
  // Bind data
 $stmt-> bindParam(':pay_id', $this->pay_id); 
 $stmt-> bindParam(':pay_ref', $this->pay_ref);
 $stmt-> bindParam(':tot_pr', $this->tot_pr);
 $stmt-> bindParam(':pay_date', $this->pay_date);
 $stmt-> bindParam(':pay_time', $this->pay_time);
 $stmt-> bindParam(':cust_id', $this->cust_id);
 $stmt-> bindParam(':discount', $this->discount); 
 $stmt-> bindParam(':changee', $this->changee);
 $stmt-> bindParam(':user_id', $this->user_id);
 $stmt-> bindParam(':pay', $this->pay);
 $stmt-> bindParam(':store_id', $this->store_id);
 $stmt-> bindParam(':pay_method', $this->pay_method); 
 $stmt-> bindParam(':payComment', $this->payComment); 
 $stmt-> bindParam(':nextPay', $this->nextPay); 


  // Execute query
 if($stmt->execute()) {
  return true;
 }

  // Print error if something goes wrong
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

