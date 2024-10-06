<?php
  class Caselawyers {
        // DB Stuff
        private $conn;
        private $table = 'caselawyers'; 
      
      public $case_id;
      public $user_id;
      public $full_name;
  

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




    public function getCaseLaywers() {
        // Create query
        $query = 'SELECT 
            users.full_name, 
            caselawyers.case_id,
            caselawyers.user_id
            FROM
           ' . $this->table . '
            INNER JOIN 
            users ON caselawyers.user_id = users.id 
            WHERE
            caselawyers.case_id = :case_id 
           ';
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        // Bind startId and endId
        
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