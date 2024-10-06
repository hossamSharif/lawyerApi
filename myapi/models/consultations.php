<?php
  class Consultation  {
    // DB Stuff
    private $conn;
    private $table = 'consultations'; 
      // Unique identifier for the case
      public $id; // Unique identifier for each consultation
      public $title; // Unique identifier for each consultation
      public $client_id; // ID of the client
      public $lawyer_id; // ID of the lawyer
      public $case_id; // ID of the legal case
      public $consultation_date; // Date and time of the consultation
      public $duration; // Duration of the consultation in minutes
      public $consultation_notes; // Notes taken during the consultation
      public $consultation_fee; // Fee charged for the consultation
      public $consultation_type; // Type of consultation (e.g., Initial, Follow-up)
      public $status; // Status of the consultation (e.g., Scheduled, Completed, Cancelled)
      public $created_at; // Timestamp when the record was created
      public $updated_at; 


      public  $startrange ;

      //end range
      public  $endrange ;
    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }


  /// get sessiion by id
  

  public function getConsultationById() {
    // Create query
    $query = 'SELECT 
        consultations.id, 
        consultations.title, 
        consultations.client_id,
        consultations.lawyer_id,
        consultations.case_id,
        consultations.consultation_date,
        consultations.duration,
        consultations.consultation_notes,
        consultations.consultation_fee,
        consultations.consultation_type,
        consultations.status,
        IFNULL((SELECT cust_name FROM customer WHERE customer.id = consultations.client_id), 0) AS customer, 
        IFNULL((SELECT full_name FROM users WHERE users.id = consultations.lawyer_id), 0) AS lawyer_name
      FROM
        ' . $this->table . ' 
      WHERE 
        consultations.id = :id AND consultations.title != ""
      ORDER BY
        consultations.consultation_date DESC';

    // Prepare statement
    $stmt = $this->conn->prepare($query);
    
    // Bind consultation_id
    $stmt->bindParam(':id', $this->id, PDO::PARAM_INT); 
    
    // Execute query
    $stmt->execute();
    
    return $stmt;
}


public function getConsultationsInRange() {
  // Create query
  $query = 'SELECT 
      consultations.id, 
      consultations.title, 
      consultations.client_id,
      consultations.lawyer_id,
      consultations.case_id,
      consultations.consultation_date,
      consultations.duration,
      consultations.consultation_notes,
      consultations.consultation_fee,
      consultations.consultation_type,
      consultations.status,
      IFNULL((SELECT cust_name FROM customer WHERE customer.id = consultations.client_id), 0) AS customer, 
      IFNULL((SELECT full_name FROM users WHERE users.id = consultations.lawyer_id), 0) AS lawyer_name
    FROM
      ' . $this->table . '
    WHERE 
      consultations.title != ""
    ORDER BY
      consultations.id DESC
    LIMIT :startrange, :endrange';

  // Prepare statement
  $stmt = $this->conn->prepare($query);
  
  // Bind start range and end range
  $stmt->bindParam(':startrange', $this->startrange, PDO::PARAM_INT); 
  $stmt->bindParam(':endrange', $this->endrange, PDO::PARAM_INT); 
  
  // Execute query
  $stmt->execute();
  
  return $stmt;
}


public function getConsultationsByCaseId() {
  // Create query
  $query = 'SELECT 
      consultations.id, 
      consultations.title, 
      consultations.client_id,
      consultations.lawyer_id,
      consultations.case_id,
      consultations.consultation_date,
      consultations.duration,
      consultations.consultation_notes,
      consultations.consultation_fee,
      consultations.consultation_type,
      consultations.status,
      IFNULL((SELECT cust_name FROM customer WHERE customer.id = consultations.client_id), 0) AS customer, 
      IFNULL((SELECT full_name FROM users WHERE users.id = consultations.lawyer_id), 0) AS lawyer_name
    FROM
      ' . $this->table . '
    WHERE 
      consultations.case_id = :case_id AND consultations.title != ""
    ORDER BY
      consultations.id DESC';

  // Prepare statement
  $stmt = $this->conn->prepare($query);
  
  // Bind case_id
  $stmt->bindParam(':case_id', $this->case_id, PDO::PARAM_INT);
  
  // Execute query
  $stmt->execute();
  
  return $stmt;
}




  public function read() {
    // Create query
    $query = 'SELECT 
        consultations.id, 
        consultations.title, 
        consultations.client_id,
        consultations.lawyer_id,
        consultations.case_id,
        consultations.consultation_date,
        consultations.duration,
        consultations.consultation_notes,
        consultations.consultation_fee,
        consultations.consultation_type,
        consultations.status,
        IFNULL((SELECT cust_name FROM customer WHERE customer.id = consultations.client_id), 0) AS customer, 
        IFNULL((SELECT full_name FROM users WHERE users.id = consultations.lawyer_id), 0) AS lawyer_name
      FROM
        ' . $this->table . ' 
      WHERE 
        consultations.title != ""
      ORDER BY
        consultations.consultation_date DESC';
    
    // Prepare statement
    $stmt = $this->conn->prepare($query);
    
    // Bind id
    $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
    
    // Execute query
    $stmt->execute();
    
    return $stmt;
}


    public function create() {
      // Create Query
      $query = 'INSERT INTO consultations SET
          title = :title,
          client_id = :client_id,
          lawyer_id = :lawyer_id,
          case_id = :case_id,
          consultation_date = :consultation_date,
          duration = :duration,
          consultation_notes = :consultation_notes,
          consultation_fee = :consultation_fee,
          consultation_type = :consultation_type,
          status = :status';
  
      // Prepare Statement
      $stmt = $this->conn->prepare($query);
  
      // Clean data
      $this->title = htmlspecialchars(strip_tags($this->title));
      $this->client_id = htmlspecialchars(strip_tags($this->client_id));
      $this->lawyer_id = htmlspecialchars(strip_tags($this->lawyer_id));
      $this->case_id = htmlspecialchars(strip_tags($this->case_id));
      $this->consultation_date = htmlspecialchars(strip_tags($this->consultation_date));
      $this->duration = htmlspecialchars(strip_tags($this->duration));
      $this->consultation_notes = htmlspecialchars(strip_tags($this->consultation_notes));
      $this->consultation_fee = htmlspecialchars(strip_tags($this->consultation_fee));
      $this->consultation_type = htmlspecialchars(strip_tags($this->consultation_type));
      $this->status = htmlspecialchars(strip_tags($this->status));
  
      // Bind data
      $stmt->bindParam(':title', $this->title);
      $stmt->bindParam(':client_id', $this->client_id);
      $stmt->bindParam(':lawyer_id', $this->lawyer_id);
      $stmt->bindParam(':case_id', $this->case_id);
      $stmt->bindParam(':consultation_date', $this->consultation_date);
      $stmt->bindParam(':duration', $this->duration);
      $stmt->bindParam(':consultation_notes', $this->consultation_notes);
      $stmt->bindParam(':consultation_fee', $this->consultation_fee);
      $stmt->bindParam(':consultation_type', $this->consultation_type);
      $stmt->bindParam(':status', $this->status);
  
      // Execute query
      if($stmt->execute()) {
          return true;
      }
  
      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);
  
      return false;
  }
  


  // Update cases
  public function update() {
    // Create Query
    $query = 'UPDATE consultations
    SET
    client_id = :client_id,
    title = :title,
    lawyer_id = :lawyer_id,
    case_id = :case_id,
    consultation_date = :consultation_date,
    duration = :duration,
    consultation_notes = :consultation_notes,
    consultation_fee = :consultation_fee,
    consultation_type = :consultation_type,
    status = :status
    WHERE id = :id';

    // Prepare Statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->id = htmlspecialchars(strip_tags($this->id));
    $this->title = htmlspecialchars(strip_tags($this->title));
    $this->client_id = htmlspecialchars(strip_tags($this->client_id));
    $this->lawyer_id = htmlspecialchars(strip_tags($this->lawyer_id));
    $this->case_id = htmlspecialchars(strip_tags($this->case_id));
    $this->consultation_date = htmlspecialchars(strip_tags($this->consultation_date));
    $this->duration = htmlspecialchars(strip_tags($this->duration));
    $this->consultation_notes = htmlspecialchars(strip_tags($this->consultation_notes));
    $this->consultation_fee = htmlspecialchars(strip_tags($this->consultation_fee));
    $this->consultation_type = htmlspecialchars(strip_tags($this->consultation_type));
    $this->status = htmlspecialchars(strip_tags($this->status));

    // Bind data
    $stmt->bindParam(':id', $this->id);
    $stmt->bindParam(':title', $this->title);
    $stmt->bindParam(':client_id', $this->client_id);
    $stmt->bindParam(':lawyer_id', $this->lawyer_id);
    $stmt->bindParam(':case_id', $this->case_id);
    $stmt->bindParam(':consultation_date', $this->consultation_date);
    $stmt->bindParam(':duration', $this->duration);
    $stmt->bindParam(':consultation_notes', $this->consultation_notes);
    $stmt->bindParam(':consultation_fee', $this->consultation_fee);
    $stmt->bindParam(':consultation_type', $this->consultation_type);
    $stmt->bindParam(':status', $this->status);

    // Execute query
    if($stmt->execute()) {
        return true;
    }

    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;
}


  // Delete Category
  public function delete() {
    // Create query
    $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

    // Prepare Statement
    $stmt = $this->conn->prepare($query);

    // clean data
    $this->id = htmlspecialchars(strip_tags($this->id));

    // Bind Data
    $stmt-> bindParam(':id', $this->id);

    // Execute query
    if($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: $s.\n", $stmt->error);

    return false;
    }
  }

   
 