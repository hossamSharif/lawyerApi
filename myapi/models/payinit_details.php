<?php
  class Pay2_details {
    // DB Stuff
    private $conn;
    private $table = 'payinit_details';
  
    // Properties
    public $id;
    public $pay_ref;
    public $item_name;
    public $pay_price;
    public $quantity;
    public $tot;
    public $store_id;
    public $item_id;
    public $dateCreated;
    public $perch_price; 
    public $pay_date; 
    public $cust_id; 
    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get doctors
    public function read() {
      // Create query
      $query = 'SELECT
        id,
        pay_ref,
        item_name,
        pay_price,
        quantity,
        tot,
        store_id,
        item_id,
        dateCreated ,
        perch_price
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
        pay_ref,
        item_name,
        pay_price,
        quantity,
        tot,
        store_id,
        dateCreated
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
      $this->pay_ref = $row['pay_ref'];
      $this->item_name = $row['item_name'];
      $this->pay_price = $row['pay_price'];
      $this->quantity = $row['quantity'];
      $this->quantity = $row['tot']; 
      $this->store_id = $row['store_id']; 
      $this->dateCreated = $row['dateCreated']; 
  }

  /// read for spacific branch store
public function readByStoreByRef(){
  // Create query
  $query = 'SELECT 
        id,
        pay_ref,
        item_name,
        pay_price,
        quantity,
        tot,
        store_id,
        item_id,
        dateCreated ,
        perch_price

      FROM
       ' . $this->table . ' 
      WHERE 
      store_id = :store_id  AND pay_ref = :pay_ref 
      ORDER BY
      id ASC
      ';

    //Prepare statement
    $stmt = $this->conn->prepare($query);

    // Bind pay_id
    $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT); 
    $stmt->bindParam(':pay_ref', $this->pay_ref, PDO::PARAM_STR); 
    

    // Execute query
    $stmt->execute();

    return $stmt ;
   
}




  public function readAllByStore(){
    // Create query
    $query = 'SELECT 
          id,
          pay_ref,
          item_name,
          pay_price,
          quantity,
          tot,
          store_id,
          item_id,
          dateCreated ,
          perch_price
        FROM
         ' . $this->table . ' 
        WHERE 
        store_id = :store_id AND item_name != ""
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

  // Create Category
  public function create() {
    // Create Query
    $query = 'INSERT INTO ' .
      $this->table . '
    SET
    pay_ref = :pay_ref ,item_name = :item_name, pay_price = :pay_price, quantity = :quantity, tot = :tot, store_id = :store_id, dateCreated = :dateCreated';
//    VALUES (NULL,:pay_ref,:item_name,:pay_price,:quantity,:tot,:store_id,:dateCreated)';
  // Prepare Statement
  $stmt = $this->conn->prepare($query);

  // Clean data
  $this->pay_ref = htmlspecialchars(strip_tags($this->pay_ref));
  $this->item_name = htmlspecialchars(strip_tags($this->item_name));
  $this->pay_price = htmlspecialchars(strip_tags($this->pay_price));
  $this->quantity = htmlspecialchars(strip_tags($this->quantity));
  $this->tot = htmlspecialchars(strip_tags($this->tot));
  $this->store_id = htmlspecialchars(strip_tags($this->store_id));
  $this->dateCreated = htmlspecialchars(strip_tags($this->dateCreated));
  $this->perch_price = htmlspecialchars(strip_tags($this->perch_price));

  // Bind data
  $stmt-> bindParam(':pay_ref', $this->pay_ref);
  $stmt-> bindParam(':item_name', $this->item_name);
  $stmt-> bindParam(':pay_price', $this->pay_price);
  $stmt-> bindParam(':quantity', $this->quantity);
  $stmt-> bindParam(':tot', $this->tot);
  $stmt-> bindParam(':store_id', $this->store_id);
  $stmt-> bindParam(':dateCreated', $this->dateCreated);
  $stmt-> bindParam(':perch_price', $this->perch_price);

  // Execute query
  if($stmt->execute()) {
    return true;
  }

  // Print error if something goes wrong
  printf("Error: $s.\n", $stmt->error);

  return false;
  }




   public function readAllByItemId(){
    // Create query
    $query = 'SELECT 
          pay_details.id,
          pay_details.pay_ref,
          pay_details.item_name,
          pay_details.pay_price,
          pay_details.quantity,
          pay_details.tot,
          pay_details.store_id,
          pay_details.item_id,
          pay_details.dateCreated ,
          pay_details.perch_price ,
          pay.cust_id ,
          pay.pay_date ,
          pay.tot_pr, 
           pay.pay_time, 
          pay.discount,
          pay.changee,
          pay.user_id, 
          pay.pay, 
          pay.pay_method,
          IFNULL((SELECT sub_name FROM sub_accounts WHERE  sub_accounts.id =  pay.cust_id), 0) AS sub_name 
        FROM
         ' . $this->table . '  INNER JOIN pay ON pay_details.pay_ref = pay.pay_ref
        WHERE 
        pay_details.store_id = :store_id  AND pay_details.item_id= :item_id 
        ORDER BY
          pay.pay_date DESC
        ';
  
      //Prepare statement
      $stmt = $this->conn->prepare($query);
  
      // Bind pay_id
      
      $stmt->bindParam(':item_id', $this->item_id, PDO::PARAM_INT); 
      $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT); 
      
  
      // Execute query
      $stmt->execute();
  
      return $stmt ;
     
  }


  public function readAllByItemIdDate(){
    // Create query
    $query = 'SELECT 
          pay_details.id,
          pay_details.pay_ref,
          pay_details.item_name,
          pay_details.pay_price,
          pay_details.quantity,
          pay_details.tot,
          pay_details.store_id,
          pay_details.item_id,
          pay_details.dateCreated ,
          pay_details.perch_price ,
          pay.cust_id ,
          pay.pay_date ,
           pay.tot_pr, 
          pay.pay_time, 
          pay.discount,
          pay.changee,
          pay.user_id, 
          pay.pay, 
          pay.pay_method,
         IFNULL((SELECT sub_name FROM sub_accounts WHERE  sub_accounts.id =  pay.cust_id), 0) AS sub_name 
        FROM
         ' . $this->table . '  INNER JOIN pay ON pay_details.pay_ref = pay.pay_ref
        WHERE 
        pay_details.store_id = :store_id  AND pay_details.item_id= :item_id AND pay.pay_date = :from 
        ORDER BY
          pay.pay_date DESC
        ';
  
      //Prepare statement
      $stmt = $this->conn->prepare($query);
  
      // Bind pay_id
      $stmt->bindParam(':from', $this->pay_date, PDO::PARAM_STR); 
      $stmt->bindParam(':item_id', $this->item_id, PDO::PARAM_INT); 
      $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT); 
      
  
      // Execute query
      $stmt->execute();
  
      return $stmt ;
     
  }

  public function readAllByItemId2Date(){
    // Create query
    $query = 'SELECT 
          pay_details.id,
          pay_details.pay_ref,
          pay_details.item_name,
          pay_details.pay_price,
          pay_details.quantity,
          pay_details.tot,
          pay_details.store_id,
          pay_details.item_id,
          pay_details.dateCreated ,
          pay_details.perch_price ,
          pay.cust_id ,
          pay.pay_date ,
           pay.tot_pr, 
          pay.pay_time, 
          pay.discount,
          pay.changee,
          pay.user_id, 
          pay.pay, 
          pay.pay_method,
         IFNULL((SELECT sub_name FROM sub_accounts WHERE  sub_accounts.id =  pay.cust_id), 0) AS sub_name 
        FROM
         ' . $this->table . '  INNER JOIN pay ON pay_details.pay_ref = pay.pay_ref
        WHERE 
        pay_details.store_id = :store_id  AND pay_details.item_id= :item_id AND (pay.pay_date BETWEEN :from AND :to)
        ORDER BY
          pay.pay_date DESC
        ';
  
      //Prepare statement
      $stmt = $this->conn->prepare($query);
  
      // Bind pay_id
      $stmt->bindParam(':from', $this->pay_date, PDO::PARAM_STR); 
      $stmt->bindParam(':to', $this->pay_date2, PDO::PARAM_STR); 
      $stmt->bindParam(':item_id', $this->item_id, PDO::PARAM_INT); 
      $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT);  
      
      // Execute query
      $stmt->execute();
  
      return $stmt ;
     
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

  // reordering service 
  public function reorder() {
    // Create Query
     $query = 'UPDATE ' . $this->table . '
     SET 
     tot = :tot 
     WHERE
     id = :id';

  // Prepare Statement
   $stmt = $this->conn->prepare($query);

  // Clean data
   $this->id = htmlspecialchars(strip_tags($this->id));
  
   $this->tot = htmlspecialchars(strip_tags($this->tot));
  
  // Bind data
   $stmt-> bindParam(':id', $this->id);  
   $stmt-> bindParam(':tot', $this->tot);
  

 

   // Execute query
   if($stmt->execute()) {
    return true;
   }

  // Print error if something goes wrong
    printf("Error: $s.\n", $stmt->error);

   return false;
  }

  public function update() {
    // Create Query
     $query = 'UPDATE ' .
      $this->table . '
     SET
     pay_ref = :pay_ref , 
     item_name = :item_name,
     pay_price = :pay_price,
     quantity = :quantity,
     tot = :tot,
     store_id = :store_id,
     dateCreated = :dateCreated
     WHERE
     id = :id';

  // Prepare Statement
   $stmt = $this->conn->prepare($query);

  // Clean data
   $this->id = htmlspecialchars(strip_tags($this->id));
   $this->pay_ref = htmlspecialchars(strip_tags($this->pay_ref));
   $this->item_name = htmlspecialchars(strip_tags($this->item_name));
   $this->pay_price = htmlspecialchars(strip_tags($this->pay_price));
   $this->quantity = htmlspecialchars(strip_tags($this->quantity));
   $this->tot = htmlspecialchars(strip_tags($this->tot));
   $this->store_id = htmlspecialchars(strip_tags($this->store_id));
   $this->dateCreated = htmlspecialchars(strip_tags($this->dateCreated));
  

  // Bind data
   $stmt-> bindParam(':id', $this->id); 
   $stmt-> bindParam(':pay_ref', $this->pay_ref);
   $stmt-> bindParam(':item_name', $this->item_name);
   $stmt-> bindParam(':pay_price', $this->pay_price);
   $stmt-> bindParam(':quantity', $this->quantity);
   $stmt-> bindParam(':tot', $this->tot);
   $stmt-> bindParam(':store_id', $this->store_id);
   $stmt-> bindParam(':dateCreated', $this->dateCreated);

 

   // Execute query
   if($stmt->execute()) {
    return true;
   }

  // Print error if something goes wrong
    printf("Error: $s.\n", $stmt->error);

   return false;
  }

// delete multi services
public function deleteMultiServices() {
  // Create query
  $query = 'DELETE FROM ' . $this->table . ' WHERE pay_ref = :pay_ref';

  // Prepare Statement
  $stmt = $this->conn->prepare($query);

  // clean data
  $this->pay_ref = htmlspecialchars(strip_tags($this->pay_ref));

  // Bind Data
  $stmt-> bindParam(':pay_ref', $this->pay_ref);

  // Execute query
  if($stmt->execute()) {
    return true;
  }

  // Print error if something goes wrong
  printf("Error: $s.\n", $stmt->error);

  return false;
  }
 

 
// Delete services
  public function delete() {
    // Create query
    $query = 'DELETE FROM ' . $this->table . ' WHERE pay_ref = :pay_ref';

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
