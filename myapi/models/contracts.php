<?php
  class Contracts {
     
      // DB Stuff
      private $conn;
      private $table = 'cases'; 
      // Unique identifier for the case
      public $id;
      public $contract_title;
      public $contract_date;
      public $end_date; 
      public $client_id; 
      public $draft;
      public $amount;
      public $payment_method;
      public $payment_system;
      public $due_date; 
      // start range
      public  $startrange ; 
      //end range
      public  $endrange ;  
      // Constructor with DB 
      public $searchTerm ;

    public function __construct($db) {
      $this->conn = $db;
    }


/// get contract by id
public function getContractById() {
  // Create query
  $query = 'SELECT 
      contracts.id, 
      contracts.contract_title,
      contracts.client_id,
      contracts.contract_date,
      contracts.end_date,
      contracts.draft,
      contracts.amount,
      contracts.due_date,
      IFNULL((SELECT cust_name FROM customer WHERE customer.id = contracts.client_id), 0) AS client_name,
      (SELECT GROUP_CONCAT(JSON_OBJECT("service_id", legal_services.service_id, "service_type", legal_services.service_type, "service_title", legal_services.service_title)) 
       FROM legal_services 
       WHERE legal_services.contract_id = contracts.id) AS legal_services,
      (SELECT GROUP_CONCAT(JSON_OBJECT("id", payments.id, "amount", payments.amount, "payment_date", payments.payment_date, "due_date", payments.due_date)) 
       FROM payments 
       WHERE payments.contract_id = contracts.id) AS payments
    FROM
     ' . $this->table . ' 
    WHERE 
    contracts.id = :id
    ORDER BY
    contracts.contract_date DESC';

  // Prepare statement
  $stmt = $this->conn->prepare($query);
  // Bind id
  $stmt->bindParam(':id', $this->id, PDO::PARAM_INT); 
  // Execute query
  $stmt->execute();
  return $stmt;
}


/// get contract by search term
public function getContractBySearchTerm() {
  // Create query
  $query = 'SELECT 
      contracts.id, 
      contracts.contract_title,
      contracts.client_id,
      contracts.contract_date,
      contracts.end_date,
      contracts.draft,
      contracts.amount,
      contracts.due_date,
      IFNULL((SELECT cust_name FROM customer WHERE customer.id = contracts.client_id), 0) AS client_name,
      (SELECT GROUP_CONCAT(JSON_OBJECT("service_id", legal_services.service_id, "service_type", legal_services.service_type, "service_title", legal_services.service_title)) 
       FROM legal_services 
       WHERE legal_services.contract_id = contracts.id) AS legal_services,
      (SELECT GROUP_CONCAT(JSON_OBJECT("id", payments.id, "amount", payments.amount, "payment_date", payments.payment_date, "due_date", payments.due_date)) 
       FROM payments 
       WHERE payments.contract_id = contracts.id) AS payments
    FROM
     ' . $this->table . ' 
    WHERE 
    contracts.contract_title LIKE :searchTerm AND contracts.contract_title != ""
    ORDER BY
    contracts.contract_date DESC';

  // Prepare statement
  $stmt = $this->conn->prepare($query);
  // Bind search term
  $stmt->bindParam(':searchTerm', $this->searchTerm, PDO::PARAM_STR); 
  // Execute query
  $stmt->execute();
  return $stmt;
}


// get contracts in the range
public function getContractsInRange() {
  // Create query
  $query = 'SELECT 
      contracts.id, 
      contracts.contract_title,
      contracts.client_id,
      contracts.contract_date,
      contracts.end_date,
      contracts.draft,
      contracts.amount,
      contracts.due_date,
      IFNULL((SELECT cust_name FROM customer WHERE customer.id = contracts.client_id), 0) AS client_name,
      (SELECT GROUP_CONCAT(JSON_OBJECT("service_id", legal_services.service_id, "service_type", legal_services.service_type, "service_title", legal_services.service_title)) 
       FROM legal_services 
       WHERE legal_services.contract_id = contracts.id) AS legal_services,
      (SELECT GROUP_CONCAT(JSON_OBJECT("id", payments.id, "amount", payments.amount, "payment_date", payments.payment_date, "due_date", payments.due_date)) 
       FROM payments 
       WHERE payments.contract_id = contracts.id) AS payments
    FROM
     ' . $this->table . '  
    WHERE 
    contracts.contract_title != ""
    ORDER BY
    contracts.id DESC
    LIMIT :startrange, :endrange';

  // Prepare statement
  $stmt = $this->conn->prepare($query);
  // Bind start range and end range
  $stmt->bindParam(':startrange', $this->startrange, PDO::PARAM_INT); 
  $stmt->bindParam(':endrange', $this->endrange, PDO::PARAM_INT); 
  // Execute query
  $stmt->execute();
  return $stmt;
}


public function read(){
  // Create query
  $query = 'SELECT 
  contracts.id, 
  contracts.contract_title,
  contracts.client_id,
  contracts.contract_date,
  contracts.end_date,
  contracts.draft,
  contracts.amount,
  contracts.due_date,
  IFNULL((SELECT cust_name FROM customer WHERE customer.id = contracts.client_id), 0) AS client_name,
  (SELECT GROUP_CONCAT(JSON_OBJECT("service_id", legal_services.service_id, "service_type", legal_services.service_type, "service_title", legal_services.service_title)) 
   FROM legal_services 
   WHERE legal_services.contract_id = contracts.id) AS legal_services,
  (SELECT GROUP_CONCAT(JSON_OBJECT("id", payments.id, "amount", payments.amount, "payment_date", payments.payment_date, "due_date", payments.due_date)) 
   FROM payments 
   WHERE payments.contract_id = contracts.id) AS payments
   FROM
 ' . $this->table . '
   WHERE 
  contracts.contract_title != ""
  ORDER BY
  contracts.id DESC  
      ';
    //Prepare statement
    $stmt = $this->conn->prepare($query);
    // Execute query
    $stmt->execute();

    return $stmt ;
}


 // Create contract
public function create() {
  // Create Query
  $query = 'INSERT INTO contracts
  SET
  contract_title = :contract_title,
  client_id = :client_id,
  contract_date = :contract_date,
  end_date = :end_date,
  draft = :draft,
  amount = :amount,
  due_date = :due_date';

  // Prepare Statement
  $stmt = $this->conn->prepare($query);

  // Clean data
  $this->contract_title = htmlspecialchars(strip_tags($this->contract_title));
  $this->client_id = htmlspecialchars(strip_tags($this->client_id));
  $this->contract_date = htmlspecialchars(strip_tags($this->contract_date));
  $this->end_date = htmlspecialchars(strip_tags($this->end_date));
  $this->draft = htmlspecialchars(strip_tags($this->draft));
  $this->amount = htmlspecialchars(strip_tags($this->amount));
  $this->due_date = htmlspecialchars(strip_tags($this->due_date));

  // Bind data
  $stmt->bindParam(':contract_title', $this->contract_title);
  $stmt->bindParam(':client_id', $this->client_id);
  $stmt->bindParam(':contract_date', $this->contract_date);
  $stmt->bindParam(':end_date', $this->end_date);
  $stmt->bindParam(':draft', $this->draft);
  $stmt->bindParam(':amount', $this->amount);
  $stmt->bindParam(':due_date', $this->due_date);

  // Execute query
  if($stmt->execute()) {
      return true;
  }

  // Print error if something goes wrong
  printf("Error: %s.\n", $stmt->error);

  return false;
}

 // Update contract
public function update() {
  // Create Query
  $query = 'UPDATE ' . $this->table . '
  SET
  contract_title = :contract_title,
  client_id = :client_id,
  contract_date = :contract_date,
  end_date = :end_date,
  draft = :draft,
  amount = :amount,
  due_date = :due_date
  WHERE id = :id';

  // Prepare Statement
  $stmt = $this->conn->prepare($query);

  // Clean data
  $this->id = htmlspecialchars(strip_tags($this->id));
  $this->contract_title = htmlspecialchars(strip_tags($this->contract_title));
  $this->client_id = htmlspecialchars(strip_tags($this->client_id));
  $this->contract_date = htmlspecialchars(strip_tags($this->contract_date));
  $this->end_date = htmlspecialchars(strip_tags($this->end_date));
  $this->draft = htmlspecialchars(strip_tags($this->draft));
  $this->amount = htmlspecialchars(strip_tags($this->amount));
  $this->due_date = htmlspecialchars(strip_tags($this->due_date));

  // Bind data
  $stmt->bindParam(':id', $this->id);
  $stmt->bindParam(':contract_title', $this->contract_title);
  $stmt->bindParam(':client_id', $this->client_id);
  $stmt->bindParam(':contract_date', $this->contract_date);
  $stmt->bindParam(':end_date', $this->end_date);
  $stmt->bindParam(':draft', $this->draft);
  $stmt->bindParam(':amount', $this->amount);
  $stmt->bindParam(':due_date', $this->due_date);

  // Execute query
  if($stmt->execute()) {
      return true;
  }

  // Print error if something goes wrong
  printf("Error: %s.\n", $stmt->error);

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

   
 