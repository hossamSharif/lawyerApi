<?php
  class Financial_entitlement { 
      // DB stuff
      private $conn;
      private $table = 'financial_entitlement';
    
    public $id;
    public $case_id;
    public $client_id;
    public $amount;
    public $status; 
    public $description ;
    
      // Constructor with DB
      public function __construct($db) {
        $this->conn = $db;
      }
     
          // Get task by ID
          public function getFinancialEntitlementByCaseId() {
            // Create query
            $query = 'SELECT 
                financial_entitlements.id, 
                financial_entitlements.case_id,
                financial_entitlements.client_id,
                financial_entitlements.amount,
                financial_entitlements.status, 
                financial_entitlements.description
              WHERE 
              financial_entitlements.case_id = :case_id
              ORDER BY
              financial_entitlements.due_date DESC';
            // Prepare statement
            $stmt = $this->conn->prepare($query);
            // Bind case_id
            $stmt->bindParam(':case_id', $this->case_id, PDO::PARAM_INT); 
            // Execute query
            $stmt->execute();
            return $stmt;
           }
        
    
          // Get task by search term
       
  
          public function createMulti($values) {
            // Create Query
            $query = 'INSERT INTO ' .
            $this->table . '
            VALUES ' . $values . '';
            
            // Prepare Statement
            $stmt = $this->conn->prepare($query);
            
            // Execute query
            if($stmt->execute()) {
                return true;
            }
            
            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);
            
            return false;
        }
        
    
    
    public function update() {
      // Create query
      $query = 'UPDATE ' . $this->table . '
      SET
        case_id = :case_id,
        client_id = :client_id,
        amount = :amount,
        status = :status,
        description = :description
        WHERE
        id = :id';
  
      // Prepare statement
      $stmt = $this->conn->prepare($query);
  
      // Clean data
      $this->id = htmlspecialchars(strip_tags($this->id));
      $this->case_id = htmlspecialchars(strip_tags($this->case_id));
      $this->client_id = htmlspecialchars(strip_tags($this->client_id));
      $this->amount = htmlspecialchars(strip_tags($this->amount));
      $this->status = htmlspecialchars(strip_tags($this->status));
      $this->description = htmlspecialchars(strip_tags($this->description));
  
      // Bind data
      $stmt->bindParam(':id', $this->id);
      $stmt->bindParam(':case_id', $this->case_id);
      $stmt->bindParam(':client_id', $this->client_id);
      $stmt->bindParam(':amount', $this->amount);
      $stmt->bindParam(':status', $this->status);
      $stmt->bindParam(':description', $this->description);
  
      // Execute query
      if($stmt->execute()) {
        return true;
      }
  
      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);
  
      return false;
    }
  
  
    
    public function deleteMulti() {
      // Create query
      $query = 'DELETE FROM ' . $this->table . ' WHERE case_id = :case_id';
    
      // Prepare Statement
      $stmt = $this->conn->prepare($query);
    
      // Clean data
      $this->case_id = htmlspecialchars(strip_tags($this->case_id));
    
      // Bind Data
      $stmt->bindParam(':case_id', $this->case_id);
    
      // Execute query
      if($stmt->execute()) {
        return true;
      }
    
      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);
    
      return false;
  }
  
    }
?>
