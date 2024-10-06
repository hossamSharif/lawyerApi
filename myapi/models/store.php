<?php
  class Store {
    // DB Stuff
    private $conn;
    private $table = 'store';
  
    
    // Properties
    public $id;
    public $store_name;
    public $store_ref;
    public $location;
  

    

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get doctors
    public function read() {
      // Create query
      $query = 'SELECT
        id,
        store_name,
        store_ref,
        location 
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
        store_name,
        store_ref,
        location 
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
      $this->store_name = $row['store_name'];
      $this->store_ref = $row['store_ref'];
      $this->location = $row['location'];
      $this->perch_price = $row['perch_price'];
      $this->item_desc = $row['item_desc']; 
      $this->item_parcode = $row['item_parcode'];
     
  }

///get group invoice with services only
  
  public function gorupServicesOnly(){
    // Create query
    $query = 'SELECT 
        invoice.invo_id,
        invoice.store_name,
        invoice.store_ref,
        invoice.location,
        invoice.perch_price,
        invoice.total,
        invoice.item_desc,
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

      // Get group invoices of spacific doctor at date
      public function gorupDoctors(){
        // Create query
        $query = 'SELECT
            invoice.invo_id,
            invoice.store_name,
            invoice.store_ref,
            invoice.location,
            invoice.perch_price,
            invoice.total,
            invoice.item_desc,
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
      invoice.store_name,
      invoice.store_ref,
      invoice.location,
      invoice.perch_price,
      invoice.total,
      invoice.item_desc,
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
        invoice.store_name,
        invoice.store_ref,
        invoice.location,
        invoice.perch_price,
        invoice.total,
        invoice.item_desc,
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
            invoice.store_name,
            invoice.store_ref,
            invoice.location,
            invoice.perch_price,
            invoice.total,
            invoice.item_desc,
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
     store_name = :store_name ,
     store_ref = :store_ref,
     location = :location, 
     perch_price = :perch_price,
     total = :total, 
     item_desc = :item_desc,
     item_parcode = :item_parcode,
     expireDate = :expireDate,
     status = :status,
     user_id = :user_id,
     device_id = :device_id,
     user_name = :user_name,
     invo_type = :invo_type,
     pt_adress = :pt_adress
     ';
      
  // Prepare Statement
  $stmt = $this->conn->prepare($query);

  // Clean data
  $this->store_name = htmlspecialchars(strip_tags($this->store_name));
  $this->store_ref = htmlspecialchars(strip_tags($this->store_ref));
  $this->location = htmlspecialchars(strip_tags($this->location));
  $this->perch_price = htmlspecialchars(strip_tags($this->perch_price));
  $this->total = htmlspecialchars(strip_tags($this->total));
  $this->item_desc = htmlspecialchars(strip_tags($this->item_desc));
  $this->item_parcode = htmlspecialchars(strip_tags($this->item_parcode));
  $this->expireDate = htmlspecialchars(strip_tags($this->expireDate));
  $this->status = htmlspecialchars(strip_tags($this->status));
  $this->user_id = htmlspecialchars(strip_tags($this->user_id));
  $this->device_id = htmlspecialchars(strip_tags($this->device_id));
  $this->user_name = htmlspecialchars(strip_tags($this->user_name));
  $this->invo_type = htmlspecialchars(strip_tags($this->invo_type));
  $this->pt_adress = htmlspecialchars(strip_tags($this->pt_adress));


   

  // Bind data
  $stmt-> bindParam(':store_name', $this->store_name);
  $stmt-> bindParam(':store_ref', $this->store_ref);
  $stmt-> bindParam(':location', $this->location);
  $stmt-> bindParam(':perch_price', $this->perch_price);
  $stmt-> bindParam(':total', $this->total);
  $stmt-> bindParam(':item_desc', $this->item_desc);
  $stmt-> bindParam(':item_parcode', $this->item_parcode);
  $stmt-> bindParam(':expireDate', $this->expireDate); 
  $stmt-> bindParam(':status', $this->status);
  $stmt-> bindParam(':user_id', $this->user_id);
  $stmt-> bindParam(':device_id', $this->device_id);
  $stmt-> bindParam(':user_name', $this->user_name);
  $stmt-> bindParam(':invo_type', $this->invo_type);
  $stmt-> bindParam(':pt_adress', $this->invo_type);

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
     store_name = :store_name , 
     store_ref = :store_ref,
     location = :location,
     perch_price = :perch_price,
     total = :total,
     item_desc = :item_desc,
     item_parcode = :item_parcode,
     expireDate = :expireDate,
     status = :status,
     user_id = :user_id,
     device_id = :device_id,
     user_name = :user_name,
     invo_type = :invo_type ,
     pt_adress = :pt_adress 
     WHERE
     invo_id = :invo_id';

  // Prepare Statement
   $stmt = $this->conn->prepare($query);

  // Clean data
   $this->invo_id = htmlspecialchars(strip_tags($this->invo_id));
   $this->store_name = htmlspecialchars(strip_tags($this->store_name));
   $this->store_ref = htmlspecialchars(strip_tags($this->store_ref));
   $this->location = htmlspecialchars(strip_tags($this->location));
   $this->perch_price = htmlspecialchars(strip_tags($this->perch_price));
   $this->total = htmlspecialchars(strip_tags($this->total));
   $this->item_desc = htmlspecialchars(strip_tags($this->item_desc));
   $this->item_parcode = htmlspecialchars(strip_tags($this->item_parcode));
   $this->expireDate = htmlspecialchars(strip_tags($this->expireDate));
   $this->status = htmlspecialchars(strip_tags($this->status));
   $this->user_id = htmlspecialchars(strip_tags($this->user_id));
   $this->device_id = htmlspecialchars(strip_tags($this->device_id));
   $this->user_name = htmlspecialchars(strip_tags($this->user_name));
   $this->invo_type = htmlspecialchars(strip_tags($this->invo_type));
   $this->pt_adress = htmlspecialchars(strip_tags($this->pt_adress));

  // Bind data
   $stmt-> bindParam(':invo_id', $this->invo_id); 
   $stmt-> bindParam(':store_name', $this->store_name);
   $stmt-> bindParam(':store_ref', $this->store_ref);
   $stmt-> bindParam(':location', $this->location);
   $stmt-> bindParam(':perch_price', $this->perch_price);
   $stmt-> bindParam(':total', $this->total);
   $stmt-> bindParam(':item_desc', $this->item_desc);
   $stmt-> bindParam(':item_parcode', $this->item_parcode);
   $stmt-> bindParam(':expireDate', $this->expireDate); 
   $stmt-> bindParam(':status', $this->status);
   $stmt-> bindParam(':user_id', $this->user_id);
   $stmt-> bindParam(':device_id', $this->device_id);
   $stmt-> bindParam(':user_name', $this->user_name);
   $stmt-> bindParam(':invo_type', $this->invo_type);
   $stmt-> bindParam(':pt_adress', $this->pt_adress);
 

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
    $query = 'DELETE FROM ' . $this->table . ' WHERE invo_id = :invo_id';

    // Prepare Statement
    $stmt = $this->conn->prepare($query);

    // clean data
    $this->invo_id = htmlspecialchars(strip_tags($this->invo_id));

    // Bind Data
    $stmt-> bindParam(':invo_id', $this->invo_id);

    // Execute query
    if($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: $s.\n", $stmt->error);

    return false;
    }
  }
