<?php
  class ContractFiles {
        // DB Stuff
        private $conn;
        private $table = 'contract_files'; 
      
      public $id;
      public $contract_id;
      public $user_id;
      public $file_name;
      public $file_size;
      public $file_url;
      public $file_notes;
      public $uploaded_at;
  

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




    public function getContractFilesByContractId() {
        // Create query
        $query = 'SELECT 
            contract_files.id, 
            contract_files.contract_id,
            contract_files.user_id,
            contract_files.file_name,
            contract_files.file_size,
            contract_files.file_url,
            contract_files.file_notes,
            contract_files.uploaded_at
            FROM
           ' . $this->table . '
            WHERE
            contract_files.contract_id = :contract_id 
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
