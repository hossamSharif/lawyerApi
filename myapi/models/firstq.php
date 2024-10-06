<?php
  class Firstq {
    // DB Stuff
    private $conn;
    private $table = 'firstq';
    private $table2 = 'stock';
    private $table3 = 'esesr';
    
    
    // Properties
    public $id;
    public $item_id;
    public $quantity;
    public $pay_price;
    public $perch_price; 
    public $store_id;
    public $fq_year;
 

    public $item_name; 
   




    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get doctors
    public function read(){
      // Create query
      $query = 'SELECT
        id,
        item_id,
        quantity,
        pay_price,
        perch_price, 
        store_id,
        item_parcode 
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

// read from stock


// select count(o.id) as tot_order ,
// sum(o.total) as total_amount,
// (select sum(p.qty) from orders o join order_product p on o.id=p.order) as prd_qty     
// from orders o;
public function readStock() {
  // Create query
  $query = 'SELECT
    items.id,
    items.item_id,
    items.quantity,
    items.pay_price,
    items.perch_price, 
    items.store_id,
    items.item_parcode,
    IFNULL((SELECT SUM(pay_details.quantity) FROM pay_details WHERE  pay_details.item_id = items.id AND pay_details.store_id = :store_id ), 0) AS salesQuantity ,
    IFNULL((SELECT SUM(perch_details.quantity) FROM perch_details WHERE  perch_details.item_id = items.id AND perch_details.store_id = :store_id ), 0) AS perchQuantity,
    IFNULL((SELECT SUM(firstq.quantity) FROM firstq WHERE  firstq.item_id = items.id AND firstq.store_id = :store_id ), 0) AS firstQuantity
  FROM
    ' . $this->table . '
     WHERE
     items.item_id != "" 
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
        item_id,
        quantity,
        pay_price,
        perch_price, 
        store_id,
        item_parcode
        FROM
          ' . $this->table . '
      WHERE id = ?
      LIMIT 0,1';

      //Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind invo_id
      $stmt->bindParam(1, $this->invo_id);

      // Execute query
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // set properties
      $this->id = $row['id'];
      $this->item_id = $row['item_id'];
      $this->quantity = $row['quantity'];
      $this->pay_price = $row['pay_price'];
      $this->perch_price = $row['perch_price'];
      $this->store_id = $row['store_id']; 
      $this->item_parcode = $row['item_parcode'];
     
  }

///get group invoice with services only
  
  public function gorupServicesOnly(){
    // Create query
    $query = 'SELECT 
        invoice.invo_id,
        invoice.item_id,
        invoice.quantity,
        invoice.pay_price,
        invoice.perch_price,
        invoice.total,
        invoice.store_id,
        invoice.item_parcode,
        invoice.expireDate,
        invoice.status,
        invoice.user_id,
        invoice.device_id,
        invoice.user_name,
        invoice.invo_type

        FROM
         ' . $this->table . ' 
        WHERE 
        invoice.invo_type = :invo_type AND invoice.perch_price = :perch_price 
        ORDER BY
        invoice.invo_id ASC
        ';

      //Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind invo_id
     
      $stmt->bindParam(':perch_price',  $this->perch_price, PDO::PARAM_STR);
      $stmt->bindParam(':invo_type', $this->invo_type, PDO::PARAM_STR); 

      // Execute query
      $stmt->execute();

      return $stmt ;
     
  }
  
  /// read for spacific branch store
public function readByStore(){
  // Create query
  $query = 'SELECT 
         id,
        item_id,
        quantity,
        pay_price,
        perch_price, 
        store_id 
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

      // Get group invoices of spacific doctor at date
      public function gorupDoctors(){
        // Create query
        $query = 'SELECT
            invoice.invo_id,
            invoice.item_id,
            invoice.quantity,
            invoice.pay_price,
            invoice.perch_price,
            invoice.total,
            invoice.store_id,
            invoice.item_parcode,
            invoice.expireDate,
            invoice.status,
            invoice.user_id,
            invoice.device_id,
            invoice.user_name,
            invoice.invo_type, 
            services.list_ordering,
            services.id

            FROM
             ' . $this->table . ' 
            INNER JOIN  
            services ON invoice.invo_id = services.ptinvo_id
            WHERE 
            invoice.perch_price = :perch_price AND services.serv_type = :serv_type AND services.serv_id = :serv_id
            ORDER BY
            invoice.invo_id ASC
            ';
     
          //Prepare statement
          $stmt = $this->conn->prepare($query); 
          // Bind invo_id 
          $stmt->bindParam(':perch_price',  $this->perch_price, PDO::PARAM_STR);
          $stmt->bindParam(':serv_type', $this->serv_type, PDO::PARAM_STR);
          $stmt->bindParam(':serv_id', $this->serv_id, PDO::PARAM_INT); 
          // Execute query
          $stmt->execute(); 
          return $stmt ; 
      }

      
/// get invoice with detail
public function getInvoiceDetails(){
  // Create query
  $query = 'SELECT
      invoice.invo_id,
      invoice.item_id,
      invoice.quantity,
      invoice.pay_price,
      invoice.perch_price,
      invoice.total,
      invoice.store_id,
      invoice.item_parcode,
      invoice.expireDate,
      invoice.status,
      invoice.user_id,
      invoice.device_id,
      invoice.user_name,
      invoice.invo_type, 
      services.list_ordering,
      services.id ,
      services.ptinvo_id ,
      services.serv_desc ,
      services.serv_type ,
      services.serv_price ,
      services.serv_id ,
      invoice.pt_adress
       
      FROM
       ' . $this->table . ' 
      INNER JOIN  
      services ON invoice.invo_id = services.ptinvo_id
      WHERE 
      invoice.invo_id = :invo_id';

    //Prepare statement
    $stmt = $this->conn->prepare($query);

    // Bind invo_id 
    $stmt->bindParam(':invo_id', $this->invo_id, PDO::PARAM_INT);

    // Execute query
    $stmt->execute();

    return $stmt ;
   
}

  // Get group invoices of spacific doctor at date
  public function invoceInDate(){
    // Create query
    $query = 'SELECT
        invoice.invo_id,
        invoice.item_id,
        invoice.quantity,
        invoice.pay_price,
        invoice.perch_price,
        invoice.total,
        invoice.store_id,
        invoice.item_parcode,
        invoice.expireDate,
        invoice.status,
        invoice.user_id,
        invoice.device_id,
        invoice.user_name,
        invoice.invo_type ,
        services.serv_price ,
        services.serv_id ,
        services.serv_desc

        FROM
         ' . $this->table . ' 
          INNER JOIN  
          services ON invoice.invo_id = services.ptinvo_id 
        WHERE 
        invoice.perch_price = :perch_price AND services.serv_type = :serv_type
        ORDER BY
        invoice.invo_id ASC
        '; 
      //Prepare statement
      $stmt = $this->conn->prepare($query); 
      // Bind invo_id 
      $stmt->bindParam(':perch_price',  $this->perch_price, PDO::PARAM_STR); 
      $stmt->bindParam(':serv_type',  $this->serv_type, PDO::PARAM_STR); 
      // Execute query
      $stmt->execute(); 
      return $stmt ; 
  }


  // Get group invoices  
      public function invoceBetweenDate(){
        // Create query
        $query = 'SELECT
            invoice.invo_id,
            invoice.item_id,
            invoice.quantity,
            invoice.pay_price,
            invoice.perch_price,
            invoice.total,
            invoice.store_id,
            invoice.item_parcode,
            invoice.expireDate,
            invoice.status,
            invoice.user_id,
            invoice.device_id,
            invoice.user_name,
            invoice.invo_type ,
            services.serv_price ,
            services.serv_id ,
            services.serv_desc 
            FROM
             ' . $this->table . '  
             INNER JOIN  
             services ON invoice.invo_id = services.ptinvo_id 
            WHERE 
            invoice.perch_price >= :perch_price1 AND invoice.perch_price <= :perch_price2 AND services.serv_type = :serv_type
            ORDER BY
            invoice.invo_id ASC
            ';
    
          //Prepare statement
          $stmt = $this->conn->prepare($query);
    
          // Bind invo_id
         
          $stmt->bindParam(':perch_price1',  $this->perch_price1, PDO::PARAM_STR);
          $stmt->bindParam(':perch_price2', $this->perch_price2, PDO::PARAM_STR); 
          $stmt->bindParam(':serv_type',  $this->serv_type, PDO::PARAM_STR); 
    
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
     item_id = :item_id ,
     quantity = :quantity,
     pay_price = :pay_price, 
     perch_price = :perch_price,
     store_id = :store_id,
     fq_year = :fq_year 
     ';
      
  // Prepare Statement
  $stmt = $this->conn->prepare($query);

  // Clean data
  $this->item_id = htmlspecialchars(strip_tags($this->item_id));
  $this->quantity = htmlspecialchars(strip_tags($this->quantity));
  $this->pay_price = htmlspecialchars(strip_tags($this->pay_price));
  $this->perch_price = htmlspecialchars(strip_tags($this->perch_price)); 
  $this->store_id = htmlspecialchars(strip_tags($this->store_id));
  $this->fq_year = htmlspecialchars(strip_tags($this->fq_year));
 
  
  // Bind data
  $stmt-> bindParam(':item_id', $this->item_id);
  $stmt-> bindParam(':quantity', $this->quantity);
  $stmt-> bindParam(':pay_price', $this->pay_price);
  $stmt-> bindParam(':perch_price', $this->perch_price);  
  $stmt-> bindParam(':store_id', $this->store_id);
  $stmt-> bindParam(':fq_year', $this->fq_year);
 

  // Execute query
  if($stmt->execute()) {
    return true;
  }

  // Print error if something goes wrong
  printf("Error: $s.\n", $stmt->error); 
  return false;
  }





 public function updateQty() {
    // Create Query
     $query = 'UPDATE ' .
      $this->table . '
     SET 
     quantity = :quantity 
     WHERE
     item_id = :item_id';

  // Prepare Statement
   $stmt = $this->conn->prepare($query);

  // Clean data
   
   $this->item_id = htmlspecialchars(strip_tags($this->item_id));
   $this->quantity = htmlspecialchars(strip_tags($this->quantity));
   
 

  // Bind data
    
   $stmt-> bindParam(':item_id', $this->item_id);
   $stmt-> bindParam(':quantity', $this->quantity);
   
 

   // Execute query
   if($stmt->execute()) {
    return true;
   }
}
  // Update Category
  public function update() {
    // Create Query
     $query = 'UPDATE ' .
      $this->table . '
     SET
     item_id = :item_id , 
     quantity = :quantity,
     pay_price = :pay_price,
     perch_price = :perch_price, 
     store_id = :store_id,
     item_parcode = :item_parcode
     WHERE
     id = :id';

  // Prepare Statement
   $stmt = $this->conn->prepare($query);

  // Clean data
   $this->id = htmlspecialchars(strip_tags($this->id));
   $this->item_id = htmlspecialchars(strip_tags($this->item_id));
   $this->quantity = htmlspecialchars(strip_tags($this->quantity));
   $this->pay_price = htmlspecialchars(strip_tags($this->pay_price));
   $this->perch_price = htmlspecialchars(strip_tags($this->perch_price));
   $this->store_id = htmlspecialchars(strip_tags($this->store_id));
   $this->item_parcode = htmlspecialchars(strip_tags($this->item_parcode));
 

  // Bind data
   $stmt-> bindParam(':id', $this->id); 
   $stmt-> bindParam(':item_id', $this->item_id);
   $stmt-> bindParam(':quantity', $this->quantity);
   $stmt-> bindParam(':pay_price', $this->pay_price);
   $stmt-> bindParam(':perch_price', $this->perch_price); 
   $stmt-> bindParam(':store_id', $this->store_id);
   $stmt-> bindParam(':item_parcode', $this->item_parcode);   
 

   // Execute query
   if($stmt->execute()) {
    return true;
   }

  // Print error if something goes wrong
    printf("Error: $s.\n", $stmt->error); 
   return false;
  }




  public function increasePrice() {
      // Create Query
      $query = 'UPDATE ' .
        $this->table . '
      SET 
      pay_price = pay_price + :payval,
      perch_price = perch_price + :perchval  
      ';

    // Prepare Statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    
    $this->payval = htmlspecialchars(strip_tags($this->payval));
    $this->perchval = htmlspecialchars(strip_tags($this->perchval));
    


      // Bind data
    
  
      $stmt-> bindParam(':perchval', $this->perchval); 
      $stmt-> bindParam(':payval', $this->payval); 
    

      // Execute query
      if($stmt->execute()) {
        return true;
      }

      // Print error if something goes wrong
        printf("Error: $s.\n", $stmt->error); 
      return false;
  }

  public function decreasePrice() {
        // Create Query
        $query = 'UPDATE ' .
          $this->table . '
        SET 
        pay_price = pay_price - :payval,
        perch_price = perch_price - :perchval  
        ';

      // Prepare Statement
      $stmt = $this->conn->prepare($query);

      // Clean data
    
      $this->payval = htmlspecialchars(strip_tags($this->payval));
      $this->perchval = htmlspecialchars(strip_tags($this->perchval));
      


        // Bind data
      
    
        $stmt-> bindParam(':perchval', $this->perchval); 
        $stmt-> bindParam(':payval', $this->payval); 
      

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

    public function deleteByStore() {
      // Create query
      $query = 'DELETE FROM ' . $this->table . ' WHERE store_id = :store_id AND fq_year = :fq_year';
  
      // Prepare Statement
      $stmt = $this->conn->prepare($query);
  
      // clean data
      $this->store_id = htmlspecialchars(strip_tags($this->store_id));
      $this->fq_year = htmlspecialchars(strip_tags($this->fq_year));
  
      // Bind Data
      $stmt-> bindParam(':store_id', $this->store_id);
      $stmt-> bindParam(':fq_year', $this->fq_year);
  
      // Execute query
      if($stmt->execute()) {
        return true;
      }
  
      // Print error if something goes wrong
      printf("Error: $s.\n", $stmt->error);
  
      return false;
      }
  

    public function truncateItems() {
      // Create query
      $query = 'TRUNCATE TABLE ' . $this->table . ' ';
  
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
   

  }

  ///
  
