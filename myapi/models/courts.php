<?php
  class Courts { 
      // DB stuff
      private $conn;
      private $table = 'courts';
    
      // Court Properties
      public $id;
      public $court_name;
      public $status;
    
      // Constructor with DB
      public function __construct($db) {
        $this->conn = $db;
      }
    

      // read

      public function read() {
        // Create query
        $query = 'SELECT 
          courts.id, 
          courts.court_name,
          courts.status 
          FROM ' . $this->table . '
          WHERE 
          courts.court_name != ""
          ORDER BY
          courts.id DESC';
      
        // Prepare statement
        $stmt = $this->conn->prepare($query);
      
        // Execute query
        $stmt->execute();
      
        return $stmt;
      }
      

      public function getCourtById() {
        // Create query
        $query = 'SELECT 
            courts.id, 
            courts.court_name,
            courts.status 
          FROM
           ' . $this->table . ' 
          WHERE 
          courts.id = :id AND courts.court_name != ""
          ORDER BY
          courts.court_name DESC';
      
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        // Bind id
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT); 
        // Execute query
        $stmt->execute();
        return $stmt;
      }
      
      // Create Court
      public function create() {
        // Create query
        $query = 'INSERT INTO ' . $this->table . '
        SET
          court_name = :court_name,
          status = :status';
    
        // Prepare statement
        $stmt = $this->conn->prepare($query);
    
        // Clean data
        $this->court_name = htmlspecialchars(strip_tags($this->court_name));
        $this->status = htmlspecialchars(strip_tags($this->status));
    
        // Bind data
        $stmt->bindParam(':court_name', $this->court_name);
        $stmt->bindParam(':status', $this->status);
    
        // Execute query
        if($stmt->execute()) {
          return true;
        }
    
        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);
    
        return false;
      }
    
      // Update Court
      public function update() {
        // Create query
        $query = 'UPDATE ' . $this->table . '
        SET
          court_name = :court_name,
          status = :status
          WHERE
          id = :id';
    
        // Prepare statement
        $stmt = $this->conn->prepare($query);
    
        // Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->court_name = htmlspecialchars(strip_tags($this->court_name));
        $this->status = htmlspecialchars(strip_tags($this->status));
    
        // Bind data
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':court_name', $this->court_name);
        $stmt->bindParam(':status', $this->status);
    
        // Execute query
        if($stmt->execute()) {
          return true;
        }
    
        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);
    
        return false;
      }
    
      // Delete Court
      public function delete() {
        // Create query
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
    
        // Prepare statement
        $stmt = $this->conn->prepare($query);
    
        // Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));
    
        // Bind data
        $stmt->bindParam(':id', $this->id);
    
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
