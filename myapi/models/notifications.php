<?php
  class Notifications { 
      // DB stuff
      private $conn;
      private $table = 'notifications';
    
      // Task Properties
      public $id; 
      public $user_id;
      public $notification_type;
      public $notification_message;
      public $notification_date;
      public $is_read;
      public $section_name;
      public $section_parameter;

      public $user_name;
    
      // Constructor with DB
      public function __construct($db) {
        $this->conn = $db;
      }
     
          // Get task by ID
          public function getNotificationById() {
            // Create query
            $query = 'SELECT 
                notifications.id, 
                notifications.user_id,
                notifications.notification_type,
                notifications.notification_message,
                notifications.notification_date,
                notifications.is_read,
                notifications.section_name,
                notifications.section_parameter,
                IFNULL((SELECT user_name FROM users WHERE users.id = tasks.user_id), 0) AS user_name
              WHERE 
              notifications.id = :id
              ORDER BY
              notifications.notification_date DESC';
            // Prepare statement
            $stmt = $this->conn->prepare($query);
            // Bind id
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT); 
            // Execute query
            $stmt->execute();
            return $stmt;
        }
        
    
          // Get task by search term
          public function getNotificationBySearchTerm() {
            // Create query
            $query = 'SELECT 
                notifications.id, 
                notifications.user_id,
                notifications.notification_type,
                notifications.notification_message,
                notifications.notification_date,
                notifications.is_read,
                notifications.section_name,
                notifications.section_parameter,
               IFNULL((SELECT full_name FROM users WHERE users.id = tasks.user_id), 0) AS user_name 
              WHERE 
              notifications.notification_message LIKE :searchTerm
              ORDER BY
              notifications.notification_date DESC';
            // Prepare statement
            $stmt = $this->conn->prepare($query);
            // Bind searchTerm
            $stmt->bindParam(':searchTerm', $this->searchTerm, PDO::PARAM_STR); 
            // Execute query
            $stmt->execute();
            return $stmt;
        }
        
    
          // Get tasks in range
          public function getNotificationsInRange() {
            // Create query
            $query = 'SELECT 
                notifications.id, 
                notifications.user_id,
                notifications.notification_type,
                notifications.notification_message,
                notifications.notification_date,
                notifications.is_read,
                notifications.section_name,
                notifications.section_parameter,
                 IFNULL((SELECT full_name FROM users WHERE users.id = tasks.user_id), 0) AS user_name
              WHERE 
              notifications.notification_message != ""
              ORDER BY
              notifications.id DESC
              LIMIT :startrange, :endrange';
            // Prepare statement
            $stmt = $this->conn->prepare($query);
            // Bind startId and endId
            $stmt->bindParam(':startrange', $this->startrange, PDO::PARAM_INT); 
            $stmt->bindParam(':endrange', $this->endrange, PDO::PARAM_INT); 
            // Execute query
            $stmt->execute();
            return $stmt;
        }
        
    
        public function read(){
          // Create query
          $query = 'SELECT 
          notifications.id, 
          notifications.user_id,
          notifications.notification_type,
          notifications.notification_message,
          notifications.notification_date,
          notifications.is_read,
          notifications.section_name,
          notifications.section_parameter,
          IFNULL((SELECT full_name FROM users WHERE users.id = tasks.user_id), 0) AS user_name
           WHERE 
          notifications.notification_message != ""
          ORDER BY
          notifications.id DESC';
          // Prepare statement
          $stmt = $this->conn->prepare($query);
          // Execute query
          $stmt->execute();
      
          return $stmt;
      }
      
  
      public function create() {
        // Create query
        $query = 'INSERT INTO ' . $this->table . '
        SET
          user_id = :user_id,
          notification_type = :notification_type,
          notification_message = :notification_message,
          notification_date = :notification_date,
          is_read = :is_read,
          section_name = :section_name,
          section_parameter = :section_parameter';
    
        // Prepare statement
        $stmt = $this->conn->prepare($query);
    
        // Clean data
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->notification_type = htmlspecialchars(strip_tags($this->notification_type));
        $this->notification_message = htmlspecialchars(strip_tags($this->notification_message));
        $this->notification_date = htmlspecialchars(strip_tags($this->notification_date));
        $this->is_read = htmlspecialchars(strip_tags($this->is_read));
        $this->section_name = htmlspecialchars(strip_tags($this->section_name));
        $this->section_parameter = htmlspecialchars(strip_tags($this->section_parameter));
    
        // Bind data
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':notification_type', $this->notification_type);
        $stmt->bindParam(':notification_message', $this->notification_message);
        $stmt->bindParam(':notification_date', $this->notification_date);
        $stmt->bindParam(':is_read', $this->is_read);
        $stmt->bindParam(':section_name', $this->section_name);
        $stmt->bindParam(':section_parameter', $this->section_parameter);
    
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
        user_id = :user_id,
        notification_type = :notification_type,
        notification_message = :notification_message,
        notification_date = :notification_date,
        is_read = :is_read,
        section_name = :section_name,
        section_parameter = :section_parameter
        WHERE
        id = :id';
  
      // Prepare statement
      $stmt = $this->conn->prepare($query);
  
      // Clean data
      $this->id = htmlspecialchars(strip_tags($this->id));
      $this->user_id = htmlspecialchars(strip_tags($this->user_id));
      $this->notification_type = htmlspecialchars(strip_tags($this->notification_type));
      $this->notification_message = htmlspecialchars(strip_tags($this->notification_message));
      $this->notification_date = htmlspecialchars(strip_tags($this->notification_date));
      $this->is_read = htmlspecialchars(strip_tags($this->is_read));
      $this->section_name = htmlspecialchars(strip_tags($this->section_name));
      $this->section_parameter = htmlspecialchars(strip_tags($this->section_parameter));
  
      // Bind data
      $stmt->bindParam(':id', $this->id);
      $stmt->bindParam(':user_id', $this->user_id);
      $stmt->bindParam(':notification_type', $this->notification_type);
      $stmt->bindParam(':notification_message', $this->notification_message);
      $stmt->bindParam(':notification_date', $this->notification_date);
      $stmt->bindParam(':is_read', $this->is_read);
      $stmt->bindParam(':section_name', $this->section_name);
      $stmt->bindParam(':section_parameter', $this->section_parameter);
  
      // Execute query
      if($stmt->execute()) {
        return true;
      }
  
      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);
  
      return false;
  }
  
    
      // Delete task
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
