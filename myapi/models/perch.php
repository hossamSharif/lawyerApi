<?php
  class Perch {
    // DB Stuff
    private $conn;
    private $table = 'perch';

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
             public $companyId;
             public $arName;
             public $engName;
             public $address; 
             public $phone;
             public $phone2 ;
             public $vatNo ;
             public $tradNo;
             public $logoUrl ;
             
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
        yearId,
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
        pay_id DESC';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }




public function readNotifByStore(){
  // Create query
  $query = 'SELECT 
        perch.pay_id,
        perch.pay_ref,
        perch.tot_pr, 
        perch.pay_date,
        perch.pay_time,
        perch.cust_id,
        perch.discount,
        perch.changee,
        perch.user_id,
        perch.pay,
        perch.store_id,
        perch.pay_method,
        perch.payComment,
        perch.nextPay,
        perch.yearId 
      FROM
       ' . $this->table . ' 
      WHERE 
      perch.store_id = :store_id  AND yearId = :yearId
      ORDER BY
      perch.pay_id ASC
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
        nextPay,
        yearId ,
        companyId
            
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

public function getTopSales(){
  // Create query
  $query = 'SELECT 
        perch.pay_id,
        perch.pay_ref,
        perch.tot_pr, 
        perch.pay_date,
        perch.pay_time,
        perch.cust_id,
        perch.discount,
        perch.changee,
        perch.user_id,
        perch.pay,
        perch.store_id,
        perch.pay_method ,
        sub_accounts.sub_name,
         perch.payComment,
         perch.nextPay,
         perch.yearId ,
         perch.companyId,
                  IFNULL((SELECT full_name FROM users  WHERE  users.id = perch.user_id ), 0) AS user_name ,
        IFNULL((SELECT companyId FROM company  WHERE  company.id = perch.companyId ), 0) AS  companyId,
        IFNULL((SELECT arName FROM company  WHERE  company.id = perch.companyId ), 0) AS     arName,
        IFNULL((SELECT engName FROM company  WHERE  company.id = perch.companyId ), 0) AS    engName,
        IFNULL((SELECT address FROM company  WHERE  company.id = perch.companyId ), 0) AS    address, 
        IFNULL((SELECT phone FROM company  WHERE  company.id = perch.companyId ), 0) AS   phone,
        IFNULL((SELECT phone2 FROM company  WHERE  company.id = perch.companyId ), 0) AS    phone2 ,
        IFNULL((SELECT vatNo FROM company  WHERE  company.id = perch.companyId ), 0) AS    vatNo ,
        IFNULL((SELECT tradNo FROM company  WHERE  company.id = perch.companyId ), 0) AS   tradNo,
        IFNULL((SELECT logoUrl FROM company  WHERE  company.id = perch.companyId ), 0) AS    logoUrl

      FROM
       ' . $this->table . ' 
      INNER JOIN  
      sub_accounts ON perch.cust_id = sub_accounts.id
      WHERE 
      perch.store_id = :store_id  AND sub_accounts.store_id = :store_id  AND perch.yearId = :yearId
      ORDER BY
      perch.pay_date DESC
      
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


public function getSalesByDate(){
  // Create query
  $query = 'SELECT 
         perch.pay_id,
        perch.pay_ref,
        perch.tot_pr, 
        perch.pay_date,
        perch.pay_time,
        perch.cust_id,
        perch.discount,
        perch.changee,
        perch.user_id,
        perch.pay,
        perch.store_id,
        perch.pay_method ,
        perch.payComment,
        sub_accounts.sub_name,
        perch.nextPay,
        perch.yearId ,
        IFNULL((SELECT full_name FROM users  WHERE  users.id = perch.user_id ), 0) AS user_name,
        IFNULL((SELECT companyId FROM company  WHERE  company.id = perch.companyId ), 0) AS  companyId,
        IFNULL((SELECT arName FROM company  WHERE  company.id = perch.companyId ), 0) AS     arName,
        IFNULL((SELECT engName FROM company  WHERE  company.id = perch.companyId ), 0) AS    engName,
        IFNULL((SELECT address FROM company  WHERE  company.id = perch.companyId ), 0) AS    address, 
        IFNULL((SELECT phone FROM company  WHERE  company.id = perch.companyId ), 0) AS   phone,
        IFNULL((SELECT phone2 FROM company  WHERE  company.id = perch.companyId ), 0) AS    phone2 ,
        IFNULL((SELECT vatNo FROM company  WHERE  company.id = perch.companyId ), 0) AS    vatNo ,
        IFNULL((SELECT tradNo FROM company  WHERE  company.id = perch.companyId ), 0) AS   tradNo,
        IFNULL((SELECT logoUrl FROM company  WHERE  company.id = perch.companyId ), 0) AS    logoUrl


      FROM
       ' . $this->table . ' 
      INNER JOIN  
      sub_accounts ON perch.cust_id = sub_accounts.id
      WHERE 
      perch.store_id = :store_id  AND sub_accounts.store_id = :store_id AND  perch.pay_date = :from AND perch.yearId = :yearId
      ORDER BY
      perch.pay_date DESC
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
         perch.pay_id,
        perch.pay_ref,
        perch.tot_pr, 
        perch.pay_date,
        perch.pay_time,
        perch.cust_id,
        perch.discount,
        perch.changee,
        perch.user_id,
        perch.pay,
        perch.store_id,
         perch.yearId,
        perch.pay_method ,
        perch.payComment,
        sub_accounts.sub_name ,
        IFNULL((SELECT full_name FROM users  WHERE  users.id = perch.user_id ), 0) AS user_name,
        IFNULL((SELECT companyId FROM company  WHERE  company.id = perch.companyId ), 0) AS  companyId,
        IFNULL((SELECT arName FROM company  WHERE  company.id = perch.companyId ), 0) AS     arName,
        IFNULL((SELECT engName FROM company  WHERE  company.id = perch.companyId ), 0) AS    engName,
        IFNULL((SELECT address FROM company  WHERE  company.id = perch.companyId ), 0) AS    address, 
        IFNULL((SELECT phone FROM company  WHERE  company.id = perch.companyId ), 0) AS   phone,
        IFNULL((SELECT phone2 FROM company  WHERE  company.id = perch.companyId ), 0) AS    phone2 ,
        IFNULL((SELECT vatNo FROM company  WHERE  company.id = perch.companyId ), 0) AS    vatNo ,
        IFNULL((SELECT tradNo FROM company  WHERE  company.id = perch.companyId ), 0) AS   tradNo,
        IFNULL((SELECT logoUrl FROM company  WHERE  company.id = perch.companyId ), 0) AS    logoUrl
      FROM
       ' . $this->table . ' 
      INNER JOIN  
      sub_accounts ON perch.cust_id = sub_accounts.id
      WHERE 
      perch.store_id = :store_id  AND sub_accounts.store_id = :store_id AND perch.yearId = :yearId  AND  perch.pay_date >= :from AND  perch.pay_date <= :to 
      ORDER BY
      perch.pay_date DESC
      LIMIT 40
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
   pay = :pay,
   changee = :changee,
   pay_date = :pay_date,
   pay_method = :pay_method,
   cust_id = :cust_id,
   discount = :discount,
   pay_time = :pay_time,
   user_id = :user_id ,
    payComment = :payComment ,
    nextPay = :nextPay ,
    yearId = :yearId ,
    companyId = :companyId 
    
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
      $this->yearId = htmlspecialchars(strip_tags($this->yearId));
      $this->companyId = htmlspecialchars(strip_tags($this->companyId));

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
     $stmt-> bindParam(':yearId', $this->yearId);
     $stmt-> bindParam(':companyId', $this->companyId);

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
   user_id = :user_id  ,
    payComment = :payComment ,
     nextPay = :nextPay ,
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
 $this->cust_id = htmlspecialchars(strip_tags($this->cust_id));
 $this->discount = htmlspecialchars(strip_tags($this->discount));
 $this->changee = htmlspecialchars(strip_tags($this->changee));
 $this->user_id = htmlspecialchars(strip_tags($this->user_id));
 $this->pay = htmlspecialchars(strip_tags($this->pay));
 $this->store_id = htmlspecialchars(strip_tags($this->store_id));
 $this->pay_method = htmlspecialchars(strip_tags($this->pay_method));
$this->payComment = htmlspecialchars(strip_tags($this->payComment));
$this->nextPay = htmlspecialchars(strip_tags($this->nextPay));
 $this->yearId = htmlspecialchars(strip_tags($this->yearId));
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
   $stmt-> bindParam(':yearId', $this->yearId);
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

