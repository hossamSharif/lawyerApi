<?php
  class Payments {
        // DB Stuff
        private $conn;
        private $table = 'payments'; 
      
      public $id;
      public $case_id;
      public $amount;
      public $payment_date;  
      public $notification_date; 
      public $notification_daysBefor; 
      public $notification_type; 
      public $notification_id;
      public $client_id; 
      public $status; 
      public $description ;

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




    public function getPaymentsByCaseId() {
        // Create query
        $query = 'SELECT 
            payments.id, 
            payments.case_id,
            payments.amount,
            payments.payment_date,
            payments.notification_date,
            payments.notification_type ,
            payments.notification_daysBefor ,
            payments.notification_id ,
            payments.client_id ,
            payments.status ,
            payments.description
            FROM
           ' . $this->table . '
            WHERE
            payments.case_id = :case_id 
           ';
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        // Bind case_id
        $stmt->bindParam(':case_id', $this->case_id, PDO::PARAM_INT); 
        // Execute query
        $stmt->execute();
        return $stmt;
      }




      public function deleteMulti() {
        // Create query
        $query = 'DELETE FROM ' . $this->table . ' WHERE case_id = :case_id';
      
        // Prepare Statement
        $stmt = $this->conn->prepare($query);
      
        // clean data
        $this->case_id = htmlspecialchars(strip_tags($this->case_id));
      
        // Bind Data
        $stmt-> bindParam(':case_id', $this->case_id);
      
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
