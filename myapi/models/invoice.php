<?php
  class Invoice {
    // DB Stuff
    private $conn;
    private $table = 'invoice';

    // Properties
    public $invo_id;
    public $pt_name;
    public $pt_age;
    public $pt_phone;
    public $datee;
    public $total;
    public $net_total;
    public $insurans;
    public $insur_price;
    public $status;
    public $user_id;
    public $device_id;
    public $user_name;
    public $invo_type;
    public $pt_adress;

    
    public $serviceId;
    
    public $id;
    public $ptinvo_id;
    public $serv_desc;
    public $serv_price;
    public $serv_type;
    public $list_ordering;
    public $serv_status;
    public $serv_id;
   

    public $datee2;
    public $datee1;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get doctors
    public function read() {
      // Create query
      $query = 'SELECT
        invo_id,
        pt_name,
        pt_age,
        pt_phone,
        datee,
        total,
        net_total,
        insurans,
        insur_price,
        status,
        user_id,
        device_id,
        user_name,
        invo_type,
        pt_adress
      FROM
        ' . $this->table . '
      ORDER BY
        invo_id DESC';

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
          invo_id,
        pt_name,
        pt_age,
        pt_phone,
        datee,
        total,
        net_total,
        insurans,
        insur_price,
        status,
        user_id,
        device_id,
        user_name,
        invo_type,
        pt_adress
        FROM
          ' . $this->table . '
      WHERE invo_id = ?
      LIMIT 0,1';

      //Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind invo_id
      $stmt->bindParam(1, $this->invo_id);

      // Execute query
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // set properties
      $this->invo_id = $row['invo_id'];
      $this->pt_name = $row['pt_name'];
      $this->pt_age = $row['pt_age'];
      $this->pt_phone = $row['pt_phone'];
      $this->datee = $row['datee'];
      $this->datee = $row['total']; 
      $this->net_total = $row['net_total']; 
      $this->insurans = $row['insurans']; 
      $this->insur_price = $row['insur_price']; 
      $this->status = $row['status']; 
      $this->user_id = $row['user_id']; 
      $this->device_id = $row['device_id']; 
      $this->user_name = $row['user_name']; 
      $this->invo_type = $row['invo_type']; 
      $this->pt_adress = $row['pt_adress']; 
     
  }

///get group invoice with services only
  
  public function gorupServicesOnly(){
    // Create query
    $query = 'SELECT 
        invoice.invo_id,
        invoice.pt_name,
        invoice.pt_age,
        invoice.pt_phone,
        invoice.datee,
        invoice.total,
        invoice.net_total,
        invoice.insurans,
        invoice.insur_price,
        invoice.status,
        invoice.user_id,
        invoice.device_id,
        invoice.user_name,
        invoice.invo_type

        FROM
         ' . $this->table . ' 
        WHERE 
        invoice.invo_type = :invo_type AND invoice.datee = :datee 
        ORDER BY
        invoice.invo_id ASC
        ';

      //Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind invo_id
     
      $stmt->bindParam(':datee',  $this->datee, PDO::PARAM_STR);
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
            invoice.pt_name,
            invoice.pt_age,
            invoice.pt_phone,
            invoice.datee,
            invoice.total,
            invoice.net_total,
            invoice.insurans,
            invoice.insur_price,
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
            invoice.datee = :datee AND services.serv_type = :serv_type AND services.serv_id = :serv_id
            ORDER BY
            invoice.invo_id ASC
            ';
     
          //Prepare statement
          $stmt = $this->conn->prepare($query); 
          // Bind invo_id 
          $stmt->bindParam(':datee',  $this->datee, PDO::PARAM_STR);
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
      invoice.pt_name,
      invoice.pt_age,
      invoice.pt_phone,
      invoice.datee,
      invoice.total,
      invoice.net_total,
      invoice.insurans,
      invoice.insur_price,
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
        invoice.pt_name,
        invoice.pt_age,
        invoice.pt_phone,
        invoice.datee,
        invoice.total,
        invoice.net_total,
        invoice.insurans,
        invoice.insur_price,
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
        invoice.datee = :datee AND services.serv_type = :serv_type
        ORDER BY
        invoice.invo_id ASC
        '; 
      //Prepare statement
      $stmt = $this->conn->prepare($query); 
      // Bind invo_id 
      $stmt->bindParam(':datee',  $this->datee, PDO::PARAM_STR); 
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
            invoice.pt_name,
            invoice.pt_age,
            invoice.pt_phone,
            invoice.datee,
            invoice.total,
            invoice.net_total,
            invoice.insurans,
            invoice.insur_price,
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
            invoice.datee >= :datee1 AND invoice.datee <= :datee2 AND services.serv_type = :serv_type
            ORDER BY
            invoice.invo_id ASC
            ';
    
          //Prepare statement
          $stmt = $this->conn->prepare($query);
    
          // Bind invo_id
         
          $stmt->bindParam(':datee1',  $this->datee1, PDO::PARAM_STR);
          $stmt->bindParam(':datee2', $this->datee2, PDO::PARAM_STR); 
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
     pt_name = :pt_name ,
     pt_age = :pt_age,
     pt_phone = :pt_phone, 
     datee = :datee,
     total = :total, 
     net_total = :net_total,
     insurans = :insurans,
     insur_price = :insur_price,
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
  $this->pt_name = htmlspecialchars(strip_tags($this->pt_name));
  $this->pt_age = htmlspecialchars(strip_tags($this->pt_age));
  $this->pt_phone = htmlspecialchars(strip_tags($this->pt_phone));
  $this->datee = htmlspecialchars(strip_tags($this->datee));
  $this->total = htmlspecialchars(strip_tags($this->total));
  $this->net_total = htmlspecialchars(strip_tags($this->net_total));
  $this->insurans = htmlspecialchars(strip_tags($this->insurans));
  $this->insur_price = htmlspecialchars(strip_tags($this->insur_price));
  $this->status = htmlspecialchars(strip_tags($this->status));
  $this->user_id = htmlspecialchars(strip_tags($this->user_id));
  $this->device_id = htmlspecialchars(strip_tags($this->device_id));
  $this->user_name = htmlspecialchars(strip_tags($this->user_name));
  $this->invo_type = htmlspecialchars(strip_tags($this->invo_type));
  $this->pt_adress = htmlspecialchars(strip_tags($this->pt_adress));


   

  // Bind data
  $stmt-> bindParam(':pt_name', $this->pt_name);
  $stmt-> bindParam(':pt_age', $this->pt_age);
  $stmt-> bindParam(':pt_phone', $this->pt_phone);
  $stmt-> bindParam(':datee', $this->datee);
  $stmt-> bindParam(':total', $this->total);
  $stmt-> bindParam(':net_total', $this->net_total);
  $stmt-> bindParam(':insurans', $this->insurans);
  $stmt-> bindParam(':insur_price', $this->insur_price); 
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
     pt_name = :pt_name , 
     pt_age = :pt_age,
     pt_phone = :pt_phone,
     datee = :datee,
     total = :total,
     net_total = :net_total,
     insurans = :insurans,
     insur_price = :insur_price,
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
   $this->pt_name = htmlspecialchars(strip_tags($this->pt_name));
   $this->pt_age = htmlspecialchars(strip_tags($this->pt_age));
   $this->pt_phone = htmlspecialchars(strip_tags($this->pt_phone));
   $this->datee = htmlspecialchars(strip_tags($this->datee));
   $this->total = htmlspecialchars(strip_tags($this->total));
   $this->net_total = htmlspecialchars(strip_tags($this->net_total));
   $this->insurans = htmlspecialchars(strip_tags($this->insurans));
   $this->insur_price = htmlspecialchars(strip_tags($this->insur_price));
   $this->status = htmlspecialchars(strip_tags($this->status));
   $this->user_id = htmlspecialchars(strip_tags($this->user_id));
   $this->device_id = htmlspecialchars(strip_tags($this->device_id));
   $this->user_name = htmlspecialchars(strip_tags($this->user_name));
   $this->invo_type = htmlspecialchars(strip_tags($this->invo_type));
   $this->pt_adress = htmlspecialchars(strip_tags($this->pt_adress));

  // Bind data
   $stmt-> bindParam(':invo_id', $this->invo_id); 
   $stmt-> bindParam(':pt_name', $this->pt_name);
   $stmt-> bindParam(':pt_age', $this->pt_age);
   $stmt-> bindParam(':pt_phone', $this->pt_phone);
   $stmt-> bindParam(':datee', $this->datee);
   $stmt-> bindParam(':total', $this->total);
   $stmt-> bindParam(':net_total', $this->net_total);
   $stmt-> bindParam(':insurans', $this->insurans);
   $stmt-> bindParam(':insur_price', $this->insur_price); 
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
