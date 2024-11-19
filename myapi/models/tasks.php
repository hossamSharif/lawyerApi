<?php
  class Tasks { 
      // DB stuff
      private $conn;
      private $table = 'tasks';
    
      // Task Properties
      public $id;
      public $title;
      public $description;
      public $status;
      public $due_date;
      public $created_at;
      public $category;
    
      // Constructor with DB
      public function __construct($db) {
        $this->conn = $db;
      }
     
          // Get task by ID
          public function getTaskById() {
            // Create query
            $query = 'SELECT 
                tasks.id, 
                tasks.title,
                tasks.description,
                tasks.status,
                tasks.due_date,
                tasks.created_at,
                tasks.category,
                (SELECT GROUP_CONCAT(JSON_OBJECT("name", users.full_name, "id", users.id)) 
                 FROM task_team 
                 JOIN users ON users.id = task_team.user_id 
                 WHERE task_team.task_id = tasks.id) AS team
              FROM
               ' . $this->table . ' 
              WHERE 
              tasks.id = :id  AND tasks.title != ""
              ORDER BY
              tasks.due_date DESC';
            // Prepare statement
            $stmt = $this->conn->prepare($query);
            // Bind id
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT); 
            // Execute query
            $stmt->execute();
            return $stmt;
          }
    
          // Get task by search term
          public function getTaskBySearchTerm() {
            // Create query
            $query = 'SELECT 
                tasks.id, 
                tasks.title,
                tasks.description,
                tasks.status,
                tasks.due_date,
                tasks.created_at,
                tasks.category,
                (SELECT GROUP_CONCAT(JSON_OBJECT("name", users.full_name, "id", users.id)) 
                 FROM task_team 
                 JOIN users ON users.id = task_team.user_id 
                 WHERE task_team.task_id = tasks.id) AS team
              FROM
               ' . $this->table . ' 
              WHERE 
              tasks.title LIKE :searchTerm  AND tasks.title != ""
              ORDER BY
              tasks.due_date DESC';
            // Prepare statement
            $stmt = $this->conn->prepare($query);
            // Bind searchTerm
            $stmt->bindParam(':searchTerm', $this->searchTerm, PDO::PARAM_STR); 
            // Execute query
            $stmt->execute();
            return $stmt;
          }
    
          // Get tasks in range
          public function getTasksInRange() {
            // Create query
            $query = 'SELECT 
                tasks.id, 
                tasks.title,
                tasks.description,
                tasks.status,
                tasks.due_date,
                tasks.created_at,
                tasks.category,
                (SELECT GROUP_CONCAT(JSON_OBJECT("name", users.full_name, "id", users.id)) 
                 FROM task_team 
                 JOIN users ON users.id = task_team.user_id 
                 WHERE task_team.task_id = tasks.id) AS team
              FROM
               ' . $this->table . '  
                WHERE 
                tasks.title != ""
              ORDER BY
              tasks.id DESC
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
    
          // Read all tasks
          public function read(){
            // Create query
            $query = 'SELECT 
            tasks.id, 
            tasks.title,
            tasks.description,
            tasks.status,
            tasks.due_date,
            tasks.created_at,
            tasks.category,
            (SELECT GROUP_CONCAT(JSON_OBJECT("name", users.full_name, "id", users.id)) 
             FROM task_team 
             JOIN users ON users.id = task_team.user_id 
             WHERE task_team.task_id = tasks.id) AS team
             FROM
           ' . $this->table . '
             WHERE 
            tasks.title != ""
            ORDER BY
            tasks.id DESC  
                ';
              //Prepare statement
              $stmt = $this->conn->prepare($query);
              // Execute query
              $stmt->execute();
          
              return $stmt ;
          }
  
      // Create task
      public function create() {
        // Create query
        $query = 'INSERT INTO ' . $this->table . '
        SET
          title = :title,
          description = :description,
          status = :status,
          due_date = :due_date,
          created_at = :created_at,
          category = :category';
    
        // Prepare statement
        $stmt = $this->conn->prepare($query);
    
        // Clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->due_date = htmlspecialchars(strip_tags($this->due_date));
        $this->created_at = htmlspecialchars(strip_tags($this->created_at));
        $this->category = htmlspecialchars(strip_tags($this->category));
    
        // Bind data
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':due_date', $this->due_date);
        $stmt->bindParam(':created_at', $this->created_at);
        $stmt->bindParam(':category', $this->category);
    
        // Execute query
        if($stmt->execute()) {
          return true;
        }
    
        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);
    
        return false;
      }
    
      // Update task
      public function update() {
        // Create query
        $query = 'UPDATE ' . $this->table . '
        SET
          title = :title,
          description = :description,
          status = :status,
          due_date = :due_date,
          created_at = :created_at,
          category = :category
          WHERE
          id = :id';
    
        // Prepare statement
        $stmt = $this->conn->prepare($query);
    
        // Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->due_date = htmlspecialchars(strip_tags($this->due_date));
        $this->created_at = htmlspecialchars(strip_tags($this->created_at));
        $this->category = htmlspecialchars(strip_tags($this->category));
    
        // Bind data
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':due_date', $this->due_date);
        $stmt->bindParam(':created_at', $this->created_at);
        $stmt->bindParam(':category', $this->category);
    
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

    }
?>
