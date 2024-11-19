<?php
  class TaskTeam {
        // DB Stuff
        private $conn;
        private $table = 'task_team'; 
      
      public $id;
      public $user_id;
      public $task_id;
  

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
            printf("Error: %s.\n", $stmt->error);
            
            return false;
    }




    public function getTaskTeam() {
        // Create query
        $query = 'SELECT 
            users.full_name, 
            task_team.task_id,
            task_team.user_id
            FROM
           ' . $this->table . '
            INNER JOIN 
            users ON task_team.user_id = users.id 
            WHERE
            task_team.task_id = :task_id 
           ';
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        // Bind task_id
        
        $stmt->bindParam(':task_id', $this->task_id, PDO::PARAM_INT); 
        // Execute query
        $stmt->execute();
        return $stmt;
      }




      public function deleteMulti() {
        // Create query
        $query = 'DELETE FROM ' . $this->table . ' WHERE task_id = :task_id';
      
        // Prepare Statement
        $stmt = $this->conn->prepare($query);
      
        // clean data
        $this->task_id = htmlspecialchars(strip_tags($this->task_id));
      
        // Bind Data
        $stmt-> bindParam(':task_id', $this->task_id);
      
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
