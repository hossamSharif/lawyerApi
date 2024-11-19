<?php
  class Payments {
        // DB Stuff
        private $conn;
        private $table = 'payments'; 
      
      public $id;
      public $contract_id;
      public $amount;
      public $payment_date;
      public $due_date;
  

        // Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
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




    public function getPaymentsByContractId() {
        // Create query
        $query = 'SELECT 
            payments.id, 
            payments.contract_id,
            payments.amount,
            payments.payment_date,
            payments.due_date
            FROM
           ' . $this->table . '
            WHERE
            payments.contract_id = :contract_id 
           ';
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        // Bind contract_id
        $stmt->bindParam(':contract_id', $this->contract_id, PDO::PARAM_INT); 
        // Execute query
        $stmt->execute();
        return $stmt;
      }




      public function deleteMulti() {
        // Create query
        $query = 'DELETE FROM ' . $this->table . ' WHERE contract_id = :contract_id';
      
        // Prepare Statement
        $stmt = $this->conn->prepare($query);
      
        // clean data
        $this->contract_id = htmlspecialchars(strip_tags($this->contract_id));
      
        // Bind Data
        $stmt-> bindParam(':contract_id', $this->contract_id);
      
        // Execute query
        if($stmt->execute()) {
          return true;
        }
      
        // Print error if something goes wrong
        printf("Error: $s.\n", $stmt->error);
      
        return false;
        }
}
?>
