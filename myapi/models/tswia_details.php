<?php
  class Tswia_details {
    // DB Stuff
    private $conn;
    private $table = 'tswia_details';
  
    // Properties
    public $id;
    public $pay_ref;
    public $item_name;
    public $pay_price;
    public $qtyReal;
    public $tot;
    public $store_id;
    public $item_id;
    public $dateCreated;
    public $perch_price; 
    public $pay_date; 
    public $cust_id; 
     public $yearId; 
      public $availQty;
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
         qtyReal,
        tot,
        store_id,
        item_id,
        dateCreated ,
        perch_price,
        yearId,
        availQty
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
        qtyReal,
        tot,
        store_id,
        dateCreated,
        yearId,
        availQty
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
      $this->qtyReal = $row['qtyReal'];
      $this->tot = $row['tot']; 
      $this->store_id = $row['store_id']; 
      $this->dateCreated = $row['dateCreated']; 
    $this->yearId = $row['yearId'];
     $this->availQty = $row['availQty'];
  }

  /// read for spacific branch store
public function readByStoreByRef(){
  // Create query
  $query = 'SELECT 
        id,
        pay_ref,
        item_name,
        pay_price,
        qtyReal,
        tot,
        store_id,
        item_id,
        dateCreated ,
        perch_price,
        yearId ,
        availQty

      FROM
       ' . $this->table . ' 
      WHERE 
      store_id = :store_id AND yearId = :yearId AND pay_ref = :pay_ref 
      ORDER BY
      id ASC
      ';

    //Prepare statement
    $stmt = $this->conn->prepare($query);

    // Bind pay_id
    $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT); 
    $stmt->bindParam(':pay_ref', $this->pay_ref, PDO::PARAM_STR); 
     $stmt->bindParam(':yearId', $this->yearId, PDO::PARAM_INT); 
    

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
          qtyReal,
          tot,
          store_id,
          item_id,
          dateCreated ,
          perch_price ,
          yearId,
          availQty
        FROM
         ' . $this->table . ' 
        WHERE 
        store_id = :store_id AND yearId = :yearId AND yearId = :yearId AND item_name != ""
        ORDER BY
        id ASC
        ';
  
      //Prepare statement
      $stmt = $this->conn->prepare($query);
  
      // Bind pay_id
      $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT);
        $stmt->bindParam(':yearId', $this->yearId, PDO::PARAM_INT); 
      $stmt->bindParam(':yearId', $this->yearId, PDO::PARAM_INT); 
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
    pay_ref = :pay_ref ,item_name = :item_name, pay_price = :pay_price, qtyReal = :qtyReal, tot = :tot, store_id = :store_id, dateCreated = :dateCreated, yearId = :yearId, availQty = :availQty';
//    VALUES (NULL,:pay_ref,:item_name,:pay_price,:quantity,:tot,:store_id,:dateCreated)';
  // Prepare Statement
  $stmt = $this->conn->prepare($query);

  // Clean data
  $this->pay_ref = htmlspecialchars(strip_tags($this->pay_ref));
  $this->item_name = htmlspecialchars(strip_tags($this->item_name));
  $this->pay_price = htmlspecialchars(strip_tags($this->pay_price));
  $this->qtyReal = htmlspecialchars(strip_tags($this->qtyReal));
  $this->tot = htmlspecialchars(strip_tags($this->tot));
  $this->store_id = htmlspecialchars(strip_tags($this->store_id));
  $this->dateCreated = htmlspecialchars(strip_tags($this->dateCreated));
  $this->perch_price = htmlspecialchars(strip_tags($this->perch_price));
  $this->yearId = htmlspecialchars(strip_tags($this->yearId));
  $this->availQty = htmlspecialchars(strip_tags($this->availQty));

  // Bind data
  $stmt-> bindParam(':pay_ref', $this->pay_ref);
  $stmt-> bindParam(':item_name', $this->item_name);
  $stmt-> bindParam(':pay_price', $this->pay_price);
  $stmt-> bindParam(':qtyReal', $this->qtyReal);
  $stmt-> bindParam(':tot', $this->tot);
  $stmt-> bindParam(':store_id', $this->store_id);
  $stmt-> bindParam(':dateCreated', $this->dateCreated);
  $stmt-> bindParam(':perch_price', $this->perch_price);
  $stmt-> bindParam(':yearId', $this->yearId);
    $stmt-> bindParam(':availQty', $this->availQty);

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
          tswia_details.id,
          tswia_details.pay_ref,
          tswia_details.item_name,
          tswia_details.pay_price,
          tswia_details.qtyReal,
          tswia_details.tot,
          tswia_details.store_id,
          tswia_details.item_id,
          tswia_details.dateCreated ,
          tswia_details.perch_price , 
          tswia.pay_date ,
          tswia.tot_pr, 
           tswia.pay_time,  
          tswia.user_id,   
          tswia_details.yearId,
          tswia_details.availQty
        FROM
         ' . $this->table . '  INNER JOIN tswia ON tswia_details.pay_ref = tswia.pay_ref
        WHERE 
        tswia_details.store_id = :store_id AND tswia_details.yearId = :yearId AND tswia_details.item_id= :item_id 
        ORDER BY
          tswia.pay_date DESC
        ';
  
      //Prepare statement
      $stmt = $this->conn->prepare($query);
  
      // Bind pay_id
      
      $stmt->bindParam(':item_id', $this->item_id, PDO::PARAM_INT); 
      $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT); 
       $stmt->bindParam(':yearId', $this->yearId, PDO::PARAM_INT); 
  
      // Execute query
      $stmt->execute();
  
      return $stmt ;
     
  }


  public function readAllByItemIdDate(){
    // Create query
    $query = 'SELECT 
           tswia_details.id,
          tswia_details.pay_ref,
          tswia_details.item_name,
          tswia_details.pay_price,
          tswia_details.qtyReal,
          tswia_details.tot,
          tswia_details.store_id,
          tswia_details.item_id,
          tswia_details.dateCreated ,
          tswia_details.perch_price , 
          tswia.pay_date ,
          tswia.tot_pr, 
           tswia.pay_time,  
          tswia.user_id,   
          tswia_details.yearId,
          tswia_details.availQty 
        FROM
         ' . $this->table . '  INNER JOIN tswia ON tswia_details.pay_ref = tswia.pay_ref
        WHERE 
       tswia_details.store_id = :store_id AND tswia_details.yearId = :yearId AND tswia_details.item_id= :item_id AND tswia.pay_date = :from 
        ORDER BY
          tswia.pay_date DESC
        ';
  
      //Prepare statement
      $stmt = $this->conn->prepare($query);
  
      // Bind pay_id
      $stmt->bindParam(':from', $this->pay_date, PDO::PARAM_STR); 
      $stmt->bindParam(':item_id', $this->item_id, PDO::PARAM_INT); 
      $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT); 
      $stmt->bindParam(':yearId', $this->yearId, PDO::PARAM_INT); 
  
      // Execute query
      $stmt->execute();
  
      return $stmt ;
     
  }



 public function readAllByDate(){
    // Create query
    $query = 'SELECT 
           tswia_details.id,
          tswia_details.pay_ref,
          tswia_details.item_name,
          tswia_details.pay_price,
          tswia_details.qtyReal,
          tswia_details.tot,
          tswia_details.store_id,
          tswia_details.item_id,
          tswia_details.dateCreated ,
          tswia_details.perch_price , 
          tswia.pay_date ,
          tswia.tot_pr, 
           tswia.pay_time,  
          tswia.user_id,   
          tswia_details.yearId,
          tswia_details.availQty 
        FROM
         ' . $this->table . '  INNER JOIN tswia ON tswia_details.pay_ref = tswia.pay_ref
        WHERE 
       tswia_details.store_id = :store_id AND tswia_details.yearId = :yearId AND  tswia.pay_date = :from 
        ORDER BY
          tswia.pay_date DESC
        ';
  
      //Prepare statement
      $stmt = $this->conn->prepare($query);
  
      // Bind pay_id
      $stmt->bindParam(':from', $this->pay_date, PDO::PARAM_STR); 
      
      $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT); 
      $stmt->bindParam(':yearId', $this->yearId, PDO::PARAM_INT); 
  
      // Execute query
      $stmt->execute();
  
      return $stmt ;
     
  }
  
  
  public function readAllByItemId2Date(){
    // Create query
    $query = 'SELECT 
           tswia_details.id,
          tswia_details.pay_ref,
          tswia_details.item_name,
          tswia_details.pay_price,
          tswia_details.qtyReal,
          tswia_details.tot,
          tswia_details.store_id,
          tswia_details.item_id,
          tswia_details.dateCreated ,
          tswia_details.perch_price , 
          tswia.pay_date ,
          tswia.tot_pr, 
           tswia.pay_time,  
          tswia.user_id,   
          tswia_details.yearId,
          tswia_details.availQty 
        FROM
         ' . $this->table . '  INNER JOIN tswia ON tswia_details.pay_ref = tswia.pay_ref
        WHERE 
        tswia_details.store_id = :store_id AND tswia_details.yearId = :yearId  AND tswia_details.item_id= :item_id AND (tswia.pay_date BETWEEN :from AND :to)
        ORDER BY
          tswia.pay_date DESC
        ';
  
      //Prepare statement
      $stmt = $this->conn->prepare($query);
  
      // Bind pay_id
      $stmt->bindParam(':from', $this->pay_date, PDO::PARAM_STR); 
      $stmt->bindParam(':to', $this->pay_date2, PDO::PARAM_STR); 
      $stmt->bindParam(':item_id', $this->item_id, PDO::PARAM_INT); 
      $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT); 
       $stmt->bindParam(':yearId', $this->yearId, PDO::PARAM_INT); 
      
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
     qtyReal = :qtyReal,
     tot = :tot,
     store_id = :store_id,
     dateCreated = :dateCreated,
     yearId = :yearId ,
     availQty
     WHERE
     id = :id';

  // Prepare Statement
   $stmt = $this->conn->prepare($query);

  // Clean data
   $this->id = htmlspecialchars(strip_tags($this->id));
   $this->pay_ref = htmlspecialchars(strip_tags($this->pay_ref));
   $this->item_name = htmlspecialchars(strip_tags($this->item_name));
   $this->pay_price = htmlspecialchars(strip_tags($this->pay_price));
   $this->qtyReal = htmlspecialchars(strip_tags($this->qtyReal));
   $this->tot = htmlspecialchars(strip_tags($this->tot));
   $this->store_id = htmlspecialchars(strip_tags($this->store_id));
   $this->dateCreated = htmlspecialchars(strip_tags($this->dateCreated));
   $this->yearId = htmlspecialchars(strip_tags($this->yearId));
   $this->availQty = htmlspecialchars(strip_tags($this->availQty));

  // Bind data
   $stmt-> bindParam(':id', $this->id); 
   $stmt-> bindParam(':pay_ref', $this->pay_ref);
   $stmt-> bindParam(':item_name', $this->item_name);
   $stmt-> bindParam(':pay_price', $this->pay_price);
   $stmt-> bindParam(':qtyReal', $this->qtyReal);
   $stmt-> bindParam(':tot', $this->tot);
   $stmt-> bindParam(':store_id', $this->store_id);
   $stmt-> bindParam(':dateCreated', $this->dateCreated);
    $stmt-> bindParam(':yearId', $this->yearId);
     $stmt-> bindParam(':availQty', $this->availQty);

 

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
