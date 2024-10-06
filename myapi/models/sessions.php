<?php
  class Sessions {
    // DB Stuff
    private $conn;
    private $table = 'sessions'; 
      // Unique identifier for the case
      public $id; // Unique identifier for each session
      public $lawyer_id; // ID of the lawyer attending the session
      public $session_title; // ID of the lawyer attending the session
      public $cust_id; // ID of the lawyer attending the session
      public $case_id; // ID of the case related to the session
      public $court_name; // Name of the court where the session will be held
      public $session_date; // Date of the session
      public $session_time; // Time of the session
      public $session_type; // Type of session (e.g., hearing, trial)
      public $opponent_name; // Name of the opponent in the session
      public $opponent_representative; // Representative of the opponent
      public $session_status; // Status of the session (e.g., scheduled, completed, postponed)
      public $session_result; // Summary or final result of the session
    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }


  /// get sessiion by id
  public function getCaseById() {
    // Create query
    $query = 'SELECT 
        cases.id, 
        cases.case_title,
        cases.client_id,
         sessions.cust_id,
         cases.case_type,
        cases.client_role,
        cases.service_classification,
        cases.branch,
        cases.court_name,
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

  public function getSessionById() {
    // Create query
    $query = 'SELECT 
        sessions.id, 
        sessions.lawyer_id,
        sessions.session_title,
        sessions.cust_id,
         sessions.case_id,
        sessions.court_name,
        sessions.session_date,
        sessions.session_time,
        sessions.session_type,
        sessions.opponent_name,
        sessions.opponent_representative,
        sessions.session_status,
        sessions.session_result,
        IFNULL((SELECT cust_name FROM customer WHERE customer.id = sessions.cust_id), 0) AS customer , 
        IFNULL((SELECT full_name  FROM users WHERE users.id = sessions.lawyer_id), 0) AS lawyer_name
      FROM
       ' . $this->table . ' 
      WHERE 
      sessions.id = :id AND sessions.session_title  != ""
      ORDER BY
      sessions.session_date DESC';

    // Prepare statement
    $stmt = $this->conn->prepare($query);
    // Bind session_id
    $stmt->bindParam(':id', $this->id, PDO::PARAM_INT); 
    // Execute query
    $stmt->execute();
    return $stmt;
}

  // get case in the range
  public function getSessionsInRange() {
    // Create query
    $query = 'SELECT 
         sessions.id, 
        sessions.session_title,
        sessions.lawyer_id,
       sessions.cust_id,
         sessions.case_id,
        sessions.court_name,
        sessions.session_date,
        sessions.session_time,
        sessions.session_type,
        sessions.opponent_name,
        sessions.opponent_representative,
        sessions.session_status,
        sessions.session_result,
        IFNULL((SELECT cust_name FROM customer WHERE customer.id = sessions.cust_id), 0) AS customer , 
        IFNULL((SELECT full_name  FROM users WHERE users.id = sessions.lawyer_id), 0) AS lawyer_name
      FROM
       ' . $this->table . '
        WHERE 
      sessions.session_title != ""
      ORDER BY
      session.id DESC
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

  public function getSessionsByCaseId() {
    // Create query
    $query = 'SELECT 
         sessions.id, 
        sessions.session_title,
        sessions.lawyer_id,
        sessions.cust_id,
        sessions.case_id,
        sessions.court_name,
        sessions.session_date,
        sessions.session_time,
        sessions.session_type,
        sessions.opponent_name,
        sessions.opponent_representative,
        sessions.session_status,
        sessions.session_result,
        IFNULL((SELECT cust_name FROM customer WHERE customer.id = sessions.cust_id), 0) AS customer , 
        IFNULL((SELECT full_name  FROM users WHERE users.id = sessions.lawyer_id), 0) AS lawyer_name
      FROM
       ' . $this->table . '
        WHERE 
       sessions.case_id = :case_id  AND    sessions.session_title != ""
      ORDER BY
      sessions.id DESC';

    // Prepare statement
    $stmt = $this->conn->prepare($query);
    // Bind startId and endId
    $stmt->bindParam(':case_id', $this->case_id, PDO::PARAM_INT);
    // Execute query
    $stmt->execute();
    return $stmt;
  }



    public function read(){
      // Create query
      $query = 'SELECT 
      sessions.id, 
        sessions.lawyer_id,
        sessions.cust_id,
        sessions.case_id,
        sessions.court_name,
        sessions.session_date,
        sessions.session_time,
        sessions.session_type,
        sessions.opponent_name,
        sessions.opponent_representative,
        sessions.session_status,
        sessions.session_result,
        IFNULL((SELECT cust_name FROM customer WHERE customer.id = sessions.cust_id), 0) AS customer , 
        IFNULL((SELECT full_name  FROM users WHERE users.id = sessions.lawyer_id), 0) AS lawyer_name
      FROM
       ' . $this->table . ' 
      WHERE 
      sessions.id = :id
      ORDER BY
      sessions.session_date DESC';
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
    $query = 'INSERT INTO sessions SET
        lawyer_id = :lawyer_id,
        case_id = :case_id,
        cust_id = :cust_id,
        court_name = :court_name,
        session_date = :session_date,
        session_time = :session_time,
        session_type = :session_type,
        session_title = :session_title,
        opponent_name = :opponent_name,
        opponent_representative = :opponent_representative,
        session_status = :session_status,
        session_result = :session_result';

    // Prepare Statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->lawyer_id = htmlspecialchars(strip_tags($this->lawyer_id));
    $this->case_id = htmlspecialchars(strip_tags($this->case_id));
    $this->cust_id = htmlspecialchars(strip_tags($this->cust_id));
    $this->court_name = htmlspecialchars(strip_tags($this->court_name));
    $this->session_date = htmlspecialchars(strip_tags($this->session_date));
    $this->session_time = htmlspecialchars(strip_tags($this->session_time));
    $this->session_type = htmlspecialchars(strip_tags($this->session_type));
    $this->session_title = htmlspecialchars(strip_tags($this->session_title));
    $this->opponent_name = htmlspecialchars(strip_tags($this->opponent_name));
    $this->opponent_representative = htmlspecialchars(strip_tags($this->opponent_representative));
    $this->session_status = htmlspecialchars(strip_tags($this->session_status));
    $this->session_result = htmlspecialchars(strip_tags($this->session_result));

    // Bind data
    $stmt->bindParam(':lawyer_id', $this->lawyer_id);
    $stmt->bindParam(':case_id', $this->case_id);
    $stmt->bindParam(':cust_id', $this->cust_id);
    $stmt->bindParam(':court_name', $this->court_name);
    $stmt->bindParam(':session_date', $this->session_date);
    $stmt->bindParam(':session_time', $this->session_time);
    $stmt->bindParam(':session_type', $this->session_type);
    $stmt->bindParam(':session_title', $this->session_title);
    $stmt->bindParam(':opponent_name', $this->opponent_name);
    $stmt->bindParam(':opponent_representative', $this->opponent_representative);
    $stmt->bindParam(':session_status', $this->session_status);
    $stmt->bindParam(':session_result', $this->session_result);

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
    $query = 'UPDATE sessions
    SET
    lawyer_id = :lawyer_id,
    case_id = :case_id,
    cust_id = :cust_id,
    court_name = :court_name,
    session_date = :session_date,
    session_time = :session_time,
    session_type = :session_type,
    session_title = :session_title,
    opponent_name = :opponent_name,
    opponent_representative = :opponent_representative,
    session_status = :session_status,
    session_result = :session_result
    WHERE id = :id';

    // Prepare Statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->id = htmlspecialchars(strip_tags($this->id));
    $this->lawyer_id = htmlspecialchars(strip_tags($this->lawyer_id));
    $this->case_id = htmlspecialchars(strip_tags($this->case_id));
    $this->cust_id = htmlspecialchars(strip_tags($this->cust_id));
    $this->court_name = htmlspecialchars(strip_tags($this->court_name));
    $this->session_date = htmlspecialchars(strip_tags($this->session_date));
    $this->session_time = htmlspecialchars(strip_tags($this->session_time));
    $this->session_type = htmlspecialchars(strip_tags($this->session_type));
    $this->session_title = htmlspecialchars(strip_tags($this->session_title));
    $this->opponent_name = htmlspecialchars(strip_tags($this->opponent_name));
    $this->opponent_representative = htmlspecialchars(strip_tags($this->opponent_representative));
    $this->session_status = htmlspecialchars(strip_tags($this->session_status));
    $this->session_result = htmlspecialchars(strip_tags($this->session_result));

    // Bind data
    $stmt->bindParam(':id', $this->id);
    $stmt->bindParam(':lawyer_id', $this->lawyer_id);
    $stmt->bindParam(':case_id', $this->case_id);
    $stmt->bindParam(':cust_id', $this->cust_id); 
    $stmt->bindParam(':court_name', $this->court_name);
    $stmt->bindParam(':session_date', $this->session_date);
    $stmt->bindParam(':session_time', $this->session_time);
    $stmt->bindParam(':session_type', $this->session_type);
    $stmt->bindParam(':session_title', $this->session_title);
    $stmt->bindParam(':opponent_name', $this->opponent_name);
    $stmt->bindParam(':opponent_representative', $this->opponent_representative);
    $stmt->bindParam(':session_status', $this->session_status);
    $stmt->bindParam(':session_result', $this->session_result);

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

   
 