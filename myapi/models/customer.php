<?php
  class Customer {
    // DB Stuff
    private $conn;
    private $table = 'customer';
    
    // Properties
    public $id;
    public $cust_name;
    public $phone;
    public $cust_type;
    public $cust_ref;
    public $cust_ident; 
    public $email; 
    public $eng_name;
    public $company_name;
    public $company_ident;
    public $company_regno;
    public $company_phone;
    public $company_represent;
    public $company_email; 
    public $status;

 
    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }



    public function readByStore(){
      // Create query
      $query = 'SELECT 
        id,
        cust_name , 
         phone , 
         cust_type , 
         cust_ident  ,
         cust_ref ,
         email   ,
         company_name ,
         company_phone  ,
         company_email  ,
         company_regno ,
         company_ident ,
        status ,
        company_represent 
          FROM
           ' . $this->table . '
           WHERE  
          cust_name != "" OR company_name != ""
          ORDER BY
          id DESC
          ';
    
        //Prepare statement
        $stmt = $this->conn->prepare($query);
    
        // Bind pay_id
        // $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT); 
        // $stmt->bindParam(':phone', $this->phone, PDO::PARAM_INT); 
        //  $stmt->bindParam(':yearId', $this->yearId, PDO::PARAM_INT); 
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
    phone = :phone ,cust_name = :cust_name ,cust_type = :cust_type,cust_ref = :cust_ref ,cust_ident = :cust_ident ,email = :email,company_phone = :company_phone, company_name = :company_name, company_ident = :company_ident, company_regno = :company_regno, company_email = :company_email,company_represent = :company_represent, status = :status';
      
  // Prepare Statement
  $stmt = $this->conn->prepare($query);

  // Clean data
  $this->cust_name = htmlspecialchars(strip_tags($this->cust_name));
  $this->phone = htmlspecialchars(strip_tags($this->phone));
  $this->email = htmlspecialchars(strip_tags($this->email));
  $this->cust_type = htmlspecialchars(strip_tags($this->cust_type));
  $this->cust_ref = htmlspecialchars(strip_tags($this->cust_ref));
  $this->cust_ident = htmlspecialchars(strip_tags($this->cust_ident));
  $this->company_name = htmlspecialchars(strip_tags($this->company_name));
  $this->company_phone = htmlspecialchars(strip_tags($this->company_phone));
  $this->company_ident = htmlspecialchars(strip_tags($this->company_ident));
    $this->company_regno = htmlspecialchars(strip_tags($this->company_regno));
    $this->company_email = htmlspecialchars(strip_tags($this->company_email));
    $this->company_represent = htmlspecialchars(strip_tags($this->company_represent));
    $this->status = htmlspecialchars(strip_tags($this->status));
        

  // Bind data
  $stmt-> bindParam(':cust_name', $this->cust_name);
  $stmt-> bindParam(':phone', $this->phone);
  $stmt-> bindParam(':email', $this->email);
  $stmt-> bindParam(':cust_type', $this->cust_type);
  $stmt-> bindParam(':cust_ref', $this->cust_ref);
  $stmt-> bindParam(':cust_ident', $this->cust_ident);
  $stmt-> bindParam(':company_name', $this->company_name);
  $stmt-> bindParam(':company_ident', $this->company_ident);
  $stmt-> bindParam(':company_regno', $this->company_regno);
    $stmt-> bindParam(':company_phone', $this->company_phone);
    $stmt-> bindParam(':company_email', $this->company_email);
    $stmt-> bindParam(':company_represent', $this->company_represent);
    $stmt-> bindParam(':status', $this->status);
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
     cust_name = :cust_name , 
     phone = :phone , 
     cust_type = :cust_type , 
      cust_ident = :cust_ident ,
       cust_ref = :cust_ref ,
       email = :email ,
       company_name = :company_name,
       company_phone = :company_phone ,
        company_email = :company_email ,
        company_regno = :company_regno,
        company_ident = :company_ident,
        status = :status,
        company_represent = :company_represent
       WHERE
     id = :id';

  // Prepare Statement
   $stmt = $this->conn->prepare($query);

  // Clean data
   $this->id = htmlspecialchars(strip_tags($this->id));
   $this->cust_name = htmlspecialchars(strip_tags($this->cust_name));
  $this->phone = htmlspecialchars(strip_tags($this->phone));
  $this->email = htmlspecialchars(strip_tags($this->email));
  $this->cust_type = htmlspecialchars(strip_tags($this->cust_type));
  $this->cust_ref = htmlspecialchars(strip_tags($this->cust_ref));
  $this->cust_ident = htmlspecialchars(strip_tags($this->cust_ident));
  $this->company_name = htmlspecialchars(strip_tags($this->company_name));
  $this->company_phone = htmlspecialchars(strip_tags($this->company_phone));
  $this->company_ident = htmlspecialchars(strip_tags($this->company_ident));
    $this->company_regno = htmlspecialchars(strip_tags($this->company_regno));
    $this->company_email = htmlspecialchars(strip_tags($this->company_email));
    $this->company_represent = htmlspecialchars(strip_tags($this->company_represent));
    $this->status = htmlspecialchars(strip_tags($this->status));
  

  // Bind data
   $stmt-> bindParam(':id', $this->id); 
   $stmt-> bindParam(':cust_name', $this->cust_name);
   $stmt-> bindParam(':phone', $this->phone);
   $stmt-> bindParam(':email', $this->email);
   $stmt-> bindParam(':cust_type', $this->cust_type);
   $stmt-> bindParam(':cust_ref', $this->cust_ref);
   $stmt-> bindParam(':cust_ident', $this->cust_ident);
   $stmt-> bindParam(':company_name', $this->company_name);
   $stmt-> bindParam(':company_ident', $this->company_ident);
   $stmt-> bindParam(':company_regno', $this->company_regno);
     $stmt-> bindParam(':company_phone', $this->company_phone);
     $stmt-> bindParam(':company_email', $this->company_email);
     $stmt-> bindParam(':company_represent', $this->company_represent);
     $stmt-> bindParam(':status', $this->status);

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
  }
