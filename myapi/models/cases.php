<?php
  class Cases {
    // DB Stuff
    private $conn;
    private $table = 'cases'; 
      // Unique identifier for the case
      public $id;
      
  
      // Title of the case
      public $case_title;
  
      // Client's unique identifier
      public $client_id;
  
      // Type of the case
      public $case_type;
  
      // Role of the client in the case
      public $client_role;
  
      // Classification of the service
      public $service_classification;
  
      // Branch handling the case
      public $branch;
  
       // Name of the court
       public $court_id;
      // Name of the court
      public $court_name;
      public $status_name;
      public $status_color;
  
      // Name of the opponent
      public $opponent_name;
  
      // Unique identifier for the opponent
      public $opponent_id;
  
      // Representative of the opponent
      public $opponent_representative;
  
      // Date when the case was opened
      public $case_open_date;
  
      // Deadline for the case
      public $deadline;
  
      // Type of billing for the case
      public $billing_type;
  
      // Type of claim in the case
      public $claim_type;
  
      // Value of work hour
      public $work_hour_value;
  
      // Estimated work hours for the case
      public $estimated_work_hours;
  
      // Status of the case
      public $case_status;
  
      // Constraint ID (Najz system)
      public $constraintId_najz;
  
      // Archive ID (Najz system)
      public $archive_id_najz;
  
      // Case ID (Najz system)
      public $caseId_najz;
  
      // Classification of the case (Najz system)
      public $case_classification_najz;
  
      // Date when the case was opened (Najz system)
      public $case_open_date_najz;
  
      // Documents related to the case
      public $case_docs;
  
      // Requests made by the plaintiff
      public $Plaintiff_Requests;
  
      // Status of the case (Najz system)
      public $case_status_najz;
  
      // Subject of the case
      public $case_subject;

      // start range
      public  $startrange ;

      //end range
      public  $endrange ;
 
      //for delete ony
      public $case_id;
    // Constructor with DB

    public $searchTerm ;

    public function __construct($db) {
      $this->conn = $db;
    }


/// get case by id
public function getCaseById() {
  // Create query
  $query = 'SELECT 
      cases.id, 
      cases.case_title,
      cases.client_id,
      cases.case_type,
      cases.client_role,
      cases.service_classification,
      cases.branch,
      cases.court_id,
      cases.opponent_name,
      cases.opponent_id,
      cases.opponent_representative,
      cases.case_open_date,
      cases.deadline,
      cases.billing_type,
      cases.claim_type,
      cases.work_hour_value,
      cases.estimated_work_hours,
      cases.case_status,
      cases.constraintId_najz,
      cases.archive_id_najz,
      cases.caseId_najz,
      cases.case_classification_najz,
      cases.case_open_date_najz,
      cases.Plaintiff_Requests,
      cases.case_status_najz,
      cases.case_subject,
      IFNULL((SELECT status_name FROM case_status WHERE case_status.id = cases.case_status), 0) AS status_name,
      IFNULL((SELECT status_color FROM case_status WHERE  case_status.id = cases.case_status), 0) AS status_color,
      IFNULL((SELECT court_name FROM courts WHERE courts.id = cases.court_id), 0) AS court_name,
      IFNULL((SELECT cust_name FROM customer WHERE customer.id = cases.client_id), 0) AS client_name,
      -- (SELECT JSON_ARRAYAGG(JSON_OBJECT("name", users.full_name, "id", users.id)) 
      --  FROM caselawyers 
      --  JOIN users ON users.id = caselawyers.user_id 
      --  WHERE caselawyers.case_id = cases.id) AS team
       (SELECT GROUP_CONCAT(JSON_OBJECT("name", users.full_name, "id", users.id)) 
       FROM caselawyers 
       JOIN users ON users.id = caselawyers.user_id 
       WHERE caselawyers.case_id = cases.id) AS team
    FROM
     ' . $this->table . ' 
    WHERE 
    cases.id = :id  AND cases.case_title != ""
    ORDER BY
    cases.case_open_date DESC';

  // Prepare statement
  $stmt = $this->conn->prepare($query);
  // Bind id
  $stmt->bindParam(':id', $this->id, PDO::PARAM_INT); 
  // Execute query
  $stmt->execute();
  return $stmt;
}

/// get case by id
public function getCaseBySearchTerm() {
  // Create query
  $query = 'SELECT 
      cases.id, 
      cases.case_title,
      cases.client_id,
      cases.case_type,
      cases.client_role,
      cases.service_classification,
      cases.branch,
      cases.court_id,
      cases.opponent_name,
      cases.opponent_id,
      cases.opponent_representative,
      cases.case_open_date,
      cases.deadline,
      cases.billing_type,
      cases.claim_type,
      cases.work_hour_value,
      cases.estimated_work_hours,
      cases.case_status,
      cases.constraintId_najz,
      cases.archive_id_najz,
      cases.caseId_najz,
      cases.case_classification_najz,
      cases.case_open_date_najz,
      cases.Plaintiff_Requests,
      cases.case_status_najz,
      cases.case_subject,
      IFNULL((SELECT status_name FROM case_status WHERE case_status.id = cases.case_status), 0) AS status_name,
      IFNULL((SELECT status_color FROM case_status WHERE  case_status.id = cases.case_status), 0) AS status_color,
     IFNULL((SELECT court_name FROM courts WHERE courts.id = cases.court_id), 0) AS court_name,
      IFNULL((SELECT cust_name FROM customer WHERE customer.id = cases.client_id), 0) AS client_name,
      -- (SELECT JSON_ARRAYAGG(JSON_OBJECT("name", users.full_name, "id", users.id)) 
      --  FROM caselawyers 
      --  JOIN users ON users.id = caselawyers.user_id 
      --  WHERE caselawyers.case_id = cases.id) AS team
       (SELECT GROUP_CONCAT(JSON_OBJECT("name", users.full_name, "id", users.id)) 
       FROM caselawyers 
       JOIN users ON users.id = caselawyers.user_id 
       WHERE caselawyers.case_id = cases.id) AS team
    FROM
     ' . $this->table . ' 
    WHERE 
    cases.case_title LIKE :searchTerm  AND cases.case_title != ""
    ORDER BY
    cases.case_open_date DESC';

  // Prepare statement
  $stmt = $this->conn->prepare($query);
  // Bind id
  $stmt->bindParam(':searchTerm', $this->searchTerm, PDO::PARAM_STR); 
  // Execute query
  $stmt->execute();
  return $stmt;
}



// get case in the range
public function getCasesInRange() {
  // Create query
  $query = 'SELECT 
      cases.id, 
      cases.case_title,
      cases.client_id,
      cases.case_type,
      cases.client_role,
      cases.service_classification,
      cases.branch,
      cases.court_id,
      cases.opponent_name,
      cases.opponent_id,
      cases.opponent_representative,
      cases.case_open_date,
      cases.deadline,
      cases.billing_type,
      cases.claim_type,
      cases.work_hour_value,
      cases.estimated_work_hours,
      cases.case_status,
      cases.constraintId_najz,
      cases.archive_id_najz,
      cases.caseId_najz,
      cases.case_classification_najz,
      cases.case_open_date_najz,
      cases.Plaintiff_Requests,
      cases.case_status_najz,
      cases.case_subject,
      IFNULL((SELECT status_name FROM case_status WHERE case_status.id = cases.case_status), 0) AS status_name,
      IFNULL((SELECT status_color FROM case_status WHERE  case_status.id = cases.case_status), 0) AS status_color,
     IFNULL((SELECT court_name FROM courts WHERE courts.id = cases.court_id), 0) AS court_name,
      IFNULL((SELECT cust_name FROM customer WHERE customer.id = cases.client_id), 0) AS client_name,
      (SELECT GROUP_CONCAT(JSON_OBJECT("full_name", users.full_name, "id", users.id)) 
       FROM caselawyers 
       JOIN users ON users.id = caselawyers.user_id 
       WHERE caselawyers.case_id = cases.id) AS team
    FROM
     ' . $this->table . '  
      WHERE 
      cases.case_title != ""
    ORDER BY
    cases.id DESC
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
      cases.id, 
      cases.case_title,
      cases.client_id,
      cases.case_type,
      cases.client_role,
      cases.service_classification,
      cases.branch,
      cases.court_id,
      cases.opponent_name,
      cases.opponent_id,
      cases.opponent_representative,
      cases.case_open_date,
      cases.deadline,
      cases.billing_type,
      cases.claim_type,
      cases.work_hour_value,
      cases.estimated_work_hours,
      cases.case_status,
      cases.constraintId_najz,
      cases.archive_id_najz,
      cases.caseId_najz,
      cases.case_classification_najz,
      cases.case_open_date_najz,
      cases.Plaintiff_Requests,
      cases.case_status_najz,
      cases.case_subject,
      IFNULL((SELECT status_name FROM case_status WHERE case_status.id = cases.case_status), 0) AS status_name,
      IFNULL((SELECT status_color FROM case_status WHERE  case_status.id = cases.case_status), 0) AS status_color,
       IFNULL((SELECT court_name FROM courts WHERE courts.id = cases.court_id), 0) AS court_name,
      IFNULL((SELECT cust_name FROM customer WHERE customer.id = cases.client_id), 0) AS client_name,
      (SELECT GROUP_CONCAT(JSON_OBJECT("name", users.full_name, "id", users.id)) 
       FROM caselawyers 
       JOIN users ON users.id = caselawyers.user_id 
       WHERE caselawyers.case_id = cases.id) AS team
       FROM
     ' . $this->table . '
       WHERE 
      cases.case_title != ""
      ORDER BY
      cases.id DESC  
          ';
        //Prepare statement
        $stmt = $this->conn->prepare($query);
        // Bind pay_id
        // $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT); 
        // $stmt->bindParam(':phone', $this->phone, PDO::PARAM_INT); 
        //  $stmt->bindParam(':yearId', $this->yearId, PDO::PARAM_INT); 
        // Execute query
        $stmt->execute();
    
        return $stmt ;
       
    }

  // Create cases
  public function create() {
    // Create Query
    $query = 'INSERT INTO cases
    SET
    case_title = :case_title,
    client_id = :client_id,
    case_type = :case_type,
    client_role = :client_role,
    service_classification = :service_classification,
    branch = :branch,
    court_id = :court_id,
    opponent_name = :opponent_name,
    opponent_id = :opponent_id,
    opponent_representative = :opponent_representative,
    case_open_date = :case_open_date,
    deadline = :deadline,
    billing_type = :billing_type,
    claim_type = :claim_type,
    work_hour_value = :work_hour_value,
    estimated_work_hours = :estimated_work_hours,
    case_status = :case_status,
    constraintId_najz = :constraintId_najz,
    archive_id_najz = :archive_id_najz,
    caseId_najz = :caseId_najz,
    case_classification_najz = :case_classification_najz,
    case_open_date_najz = :case_open_date_najz,
    case_docs = :case_docs,
    Plaintiff_Requests = :Plaintiff_Requests,
    case_status_najz = :case_status_najz,
    case_subject = :case_subject';

    // Prepare Statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->case_title = htmlspecialchars(strip_tags($this->case_title));
    $this->client_id = htmlspecialchars(strip_tags($this->client_id));
    $this->case_type = htmlspecialchars(strip_tags($this->case_type));
    $this->client_role = htmlspecialchars(strip_tags($this->client_role));
    $this->service_classification = htmlspecialchars(strip_tags($this->service_classification));
    $this->branch = htmlspecialchars(strip_tags($this->branch));
    $this->court_id = htmlspecialchars(strip_tags($this->court_id));
    $this->opponent_name = htmlspecialchars(strip_tags($this->opponent_name));
    $this->opponent_id = htmlspecialchars(strip_tags($this->opponent_id));
    $this->opponent_representative = htmlspecialchars(strip_tags($this->opponent_representative));
    $this->case_open_date = htmlspecialchars(strip_tags($this->case_open_date));
    $this->deadline = htmlspecialchars(strip_tags($this->deadline));
    $this->billing_type = htmlspecialchars(strip_tags($this->billing_type));
    $this->claim_type = htmlspecialchars(strip_tags($this->claim_type));
    $this->work_hour_value = htmlspecialchars(strip_tags($this->work_hour_value));
    $this->estimated_work_hours = htmlspecialchars(strip_tags($this->estimated_work_hours));
    $this->case_status = htmlspecialchars(strip_tags($this->case_status));
    $this->constraintId_najz = htmlspecialchars(strip_tags($this->constraintId_najz));
    $this->archive_id_najz = htmlspecialchars(strip_tags($this->archive_id_najz));
    $this->caseId_najz = htmlspecialchars(strip_tags($this->caseId_najz));
    $this->case_classification_najz = htmlspecialchars(strip_tags($this->case_classification_najz));
    $this->case_open_date_najz = htmlspecialchars(strip_tags($this->case_open_date_najz));
    $this->case_docs = htmlspecialchars(strip_tags($this->case_docs));
    $this->Plaintiff_Requests = htmlspecialchars(strip_tags($this->Plaintiff_Requests));
    $this->case_status_najz = htmlspecialchars(strip_tags($this->case_status_najz));
    $this->case_subject = htmlspecialchars(strip_tags($this->case_subject));

    // Bind data
    $stmt->bindParam(':case_title', $this->case_title);
    $stmt->bindParam(':client_id', $this->client_id);
    $stmt->bindParam(':case_type', $this->case_type);
    $stmt->bindParam(':client_role', $this->client_role);
    $stmt->bindParam(':service_classification', $this->service_classification);
    $stmt->bindParam(':branch', $this->branch);
    $stmt->bindParam(':court_id', $this->court_id);
    $stmt->bindParam(':opponent_name', $this->opponent_name);
    $stmt->bindParam(':opponent_id', $this->opponent_id);
    $stmt->bindParam(':opponent_representative', $this->opponent_representative);
    $stmt->bindParam(':case_open_date', $this->case_open_date);
    $stmt->bindParam(':deadline', $this->deadline);
    $stmt->bindParam(':billing_type', $this->billing_type);
    $stmt->bindParam(':claim_type', $this->claim_type);
    $stmt->bindParam(':work_hour_value', $this->work_hour_value);
    $stmt->bindParam(':estimated_work_hours', $this->estimated_work_hours);
    $stmt->bindParam(':case_status', $this->case_status);
    $stmt->bindParam(':constraintId_najz', $this->constraintId_najz);
    $stmt->bindParam(':archive_id_najz', $this->archive_id_najz);
    $stmt->bindParam(':caseId_najz', $this->caseId_najz);
    $stmt->bindParam(':case_classification_najz', $this->case_classification_najz);
    $stmt->bindParam(':case_open_date_najz', $this->case_open_date_najz);
    $stmt->bindParam(':case_docs', $this->case_docs);
    $stmt->bindParam(':Plaintiff_Requests', $this->Plaintiff_Requests);
    $stmt->bindParam(':case_status_najz', $this->case_status_najz);
    $stmt->bindParam(':case_subject', $this->case_subject);

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
    $query = 'UPDATE ' . $this->table . '
    SET
    case_title = :case_title,
    client_id = :client_id,
    case_type = :case_type,
    client_role = :client_role,
    service_classification = :service_classification,
    branch = :branch,
    court_id = :court_id,
    opponent_name = :opponent_name,
    opponent_id = :opponent_id,
    opponent_representative = :opponent_representative,
    case_open_date = :case_open_date,
    deadline = :deadline,
    billing_type = :billing_type,
    claim_type = :claim_type,
    work_hour_value = :work_hour_value,
    estimated_work_hours = :estimated_work_hours,
    case_status = :case_status,
    constraintId_najz = :constraintId_najz,
    archive_id_najz = :archive_id_najz,
    caseId_najz = :caseId_najz,
    case_classification_najz = :case_classification_najz,
    case_open_date_najz = :case_open_date_najz,
    case_docs = :case_docs,
    Plaintiff_Requests = :Plaintiff_Requests,
    case_status_najz = :case_status_najz,
    case_subject = :case_subject
    WHERE id = :id';

    // Prepare Statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->id = htmlspecialchars(strip_tags($this->id));
    $this->case_title = htmlspecialchars(strip_tags($this->case_title));
    $this->client_id = htmlspecialchars(strip_tags($this->client_id));
    $this->case_type = htmlspecialchars(strip_tags($this->case_type));
    $this->client_role = htmlspecialchars(strip_tags($this->client_role));
    $this->service_classification = htmlspecialchars(strip_tags($this->service_classification));
    $this->branch = htmlspecialchars(strip_tags($this->branch));
    $this->court_id = htmlspecialchars(strip_tags($this->court_id));
    $this->opponent_name = htmlspecialchars(strip_tags($this->opponent_name));
    $this->opponent_id = htmlspecialchars(strip_tags($this->opponent_id));
    $this->opponent_representative = htmlspecialchars(strip_tags($this->opponent_representative));
    $this->case_open_date = htmlspecialchars(strip_tags($this->case_open_date));
    $this->deadline = htmlspecialchars(strip_tags($this->deadline));
    $this->billing_type = htmlspecialchars(strip_tags($this->billing_type));
    $this->claim_type = htmlspecialchars(strip_tags($this->claim_type));
    $this->work_hour_value = htmlspecialchars(strip_tags($this->work_hour_value));
    $this->estimated_work_hours = htmlspecialchars(strip_tags($this->estimated_work_hours));
    $this->case_status = htmlspecialchars(strip_tags($this->case_status));
    $this->constraintId_najz = htmlspecialchars(strip_tags($this->constraintId_najz));
    $this->archive_id_najz = htmlspecialchars(strip_tags($this->archive_id_najz));
    $this->caseId_najz = htmlspecialchars(strip_tags($this->caseId_najz));
    $this->case_classification_najz = htmlspecialchars(strip_tags($this->case_classification_najz));
    $this->case_open_date_najz = htmlspecialchars(strip_tags($this->case_open_date_najz));
    $this->case_docs = htmlspecialchars(strip_tags($this->case_docs));
    $this->Plaintiff_Requests = htmlspecialchars(strip_tags($this->Plaintiff_Requests));
    $this->case_status_najz = htmlspecialchars(strip_tags($this->case_status_najz));
    $this->case_subject = htmlspecialchars(strip_tags($this->case_subject));

    // Bind data
    $stmt->bindParam(':id', $this->id);
    $stmt->bindParam(':case_title', $this->case_title);
    $stmt->bindParam(':client_id', $this->client_id);
    $stmt->bindParam(':case_type', $this->case_type);
    $stmt->bindParam(':client_role', $this->client_role);
    $stmt->bindParam(':service_classification', $this->service_classification);
    $stmt->bindParam(':branch', $this->branch);
    $stmt->bindParam(':court_id', $this->court_id);
    $stmt->bindParam(':opponent_name', $this->opponent_name);
    $stmt->bindParam(':opponent_id', $this->opponent_id);
    $stmt->bindParam(':opponent_representative', $this->opponent_representative);
    $stmt->bindParam(':case_open_date', $this->case_open_date);
    $stmt->bindParam(':deadline', $this->deadline);
    $stmt->bindParam(':billing_type', $this->billing_type);
    $stmt->bindParam(':claim_type', $this->claim_type);
    $stmt->bindParam(':work_hour_value', $this->work_hour_value);
    $stmt->bindParam(':estimated_work_hours', $this->estimated_work_hours);
    $stmt->bindParam(':case_status', $this->case_status);
    $stmt->bindParam(':constraintId_najz', $this->constraintId_najz);
    $stmt->bindParam(':archive_id_najz', $this->archive_id_najz);
    $stmt->bindParam(':caseId_najz', $this->caseId_najz);
    $stmt->bindParam(':case_classification_najz', $this->case_classification_najz);
    $stmt->bindParam(':case_open_date_najz', $this->case_open_date_najz);
    $stmt->bindParam(':case_docs', $this->case_docs);
    $stmt->bindParam(':Plaintiff_Requests', $this->Plaintiff_Requests);
    $stmt->bindParam(':case_status_najz', $this->case_status_najz);
    $stmt->bindParam(':case_subject', $this->case_subject);

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

   
 