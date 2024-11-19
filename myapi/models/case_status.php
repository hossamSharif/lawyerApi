<?php
  class caseStatus { 
      // DB stuff
      private $conn;
      private $table = 'case_status';
    
      // Court Properties
      public $id;
      public $status_name;
      public $status_color;
      public $status;
    
      // Constructor with DB
      public function __construct($db) {
        $this->conn = $db;
      }
    

      // read

      public function read() {
        // Create query
        $query = 'SELECT 
          case_status.id, 
          case_status.status_name,
          case_status.status_color, 
          case_status.status 
          FROM ' . $this->table . '
          WHERE 
          case_status.status_name != ""
          ORDER BY
          case_status.id DESC';
      
        // Prepare statement
        $stmt = $this->conn->prepare($query);
      
        // Execute query
        $stmt->execute();
      
        return $stmt;
      }
      

      public function getCaseStatusById() {
        // Create query
        $query = 'SELECT 
            case_status.id, 
            case_status.status_color,
            case_status.status_name,
            case_status.status 
          FROM
           ' . $this->table . ' 
          WHERE 
          case_status.id = :id AND case_status.cour_name != ""
          ORDER BY
          case_status.status_name DESC';
      
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
          status_name = :status_name,
          status_color = :status_color,
          status = :status';
    
        // Prepare statement
        $stmt = $this->conn->prepare($query);
    
        // Clean data
        $this->status_name = htmlspecialchars(strip_tags($this->status_name));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->status_color = htmlspecialchars(strip_tags($this->status_color));
    
        // Bind data
        $stmt->bindParam(':status_name', $this->status_name);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':status_color', $this->status_color);
    
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
          status_name = :status_name,
          status_color = :status_color,
          status = :status
          WHERE
          id = :id';
    
        // Prepare statement
        $stmt = $this->conn->prepare($query);
    
        // Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->status_name = htmlspecialchars(strip_tags($this->status_name));
        $this->status_color = htmlspecialchars(strip_tags($this->status_color));
        $this->status = htmlspecialchars(strip_tags($this->status));
    
        // Bind data
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':status_name', $this->status_name);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':status_color', $this->status_color);
    
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
