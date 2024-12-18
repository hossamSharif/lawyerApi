<?php
  class CaseFiles  {
    // DB Stuff
    private $conn;
    private $table = 'casefiles'; 

    public $id;
    public $case_id;
    public $user_id;
    public $file_name;
    public $file_size;
    public $file_url;
    public $file_notes;
    public $uploaded_at;
    public $category;


      public  $startrange ;

      //end range
      public  $endrange ;
    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }


  /// get sessiion by id
  

public function getCaseFileById() {
    // Create query
    $query = 'SELECT 
        casefiles.id, 
        casefiles.case_id, 
        casefiles.user_id,
        casefiles.file_name,
        casefiles.file_size,
        casefiles.file_url,
        casefiles.file_notes,
        casefiles.uploaded_at,
        caesefiles.category, 
        IFNULL((SELECT full_name FROM users WHERE users.id = casefiles.user_id), 0) AS user_name
      FROM
        ' . $this->table . ' 
      WHERE 
        casefiles.id = :id
      ORDER BY
        casefiles.uploaded_at DESC';

    // Prepare statement
    $stmt = $this->conn->prepare($query);
    
    // Bind case_file_id
    $stmt->bindParam(':id', $this->id, PDO::PARAM_INT); 
    
    // Execute query
    $stmt->execute();
    
    return $stmt;
}



public function getCaseFilesInRange() {
  // Create query
  $query = 'SELECT 
      casefiles.id, 
      casefiles.case_id, 
      casefiles.user_id,
      casefiles.file_name,
      casefiles.file_size,
      casefiles.file_url,
      casefiles.file_notes,
      casefiles.uploaded_at,
      caesefiles.category, 
      IFNULL((SELECT full_name FROM users WHERE users.id = casefiles.user_id), 0) AS user_name
    FROM
      ' . $this->table . '
    ORDER BY
      casefiles.id DESC
      WHERE 
    casefiles.case_id = :case_id AND casefiles.category = :category
    LIMIT :startrange, :endrange';

  // Prepare statement
  $stmt = $this->conn->prepare($query);
  
  // Bind start range and end range
  $stmt->bindParam(':startrange', $this->startrange, PDO::PARAM_INT); 
  $stmt->bindParam(':endrange', $this->endrange, PDO::PARAM_INT); 
  $stmt->bindParam(':case_id', $this->case_id, PDO::PARAM_INT); 
  
  // Execute query
  $stmt->execute();
  
  return $stmt;
}


public function getCaseFilesByCaseId() {
  // Create query
  $query = 'SELECT 
      casefiles.id, 
      casefiles.case_id, 
      casefiles.user_id,
      casefiles.file_name,
      casefiles.file_size,
      casefiles.file_url,
      casefiles.file_notes,
      casefiles.uploaded_at,
      casefiles.category, 
      IFNULL((SELECT full_name FROM users WHERE users.id = casefiles.user_id), 0) AS user_name
    FROM
      ' . $this->table . '
    WHERE 
      casefiles.case_id = :case_id AND casefiles.category = :category
    ORDER BY
      casefiles.id DESC';

  // Prepare statement
  $stmt = $this->conn->prepare($query);
  
  // Bind case_id
  $stmt->bindParam(':case_id', $this->case_id, PDO::PARAM_INT);
  $stmt->bindParam(':category', $this->category, PDO::PARAM_STR);
  
  // Execute query
  $stmt->execute();
  
  return $stmt;
}



public function read() {
  // Create query
  $query = 'SELECT 
      casefiles.id, 
      casefiles.case_id, 
      casefiles.user_id,
      casefiles.file_name,
      casefiles.file_size,
      casefiles.file_url,
      casefiles.file_notes,
      casefiles.uploaded_at,
      caesefiles.category, 
      IFNULL((SELECT full_name FROM users WHERE users.id = casefiles.user_id), 0) AS user_name
    FROM
      ' . $this->table . ' 
       WHERE 
    casefiles.category = :category
    ORDER BY
      casefiles.uploaded_at DESC';
  
  // Prepare statement
  $stmt = $this->conn->prepare($query);
  $stmt->bindParam(':category', $this->category, PDO::PARAM_STR);
  // Execute query
  $stmt->execute();
  
  return $stmt;
}


public function create() {
  // Create Query
  $query = 'INSERT INTO caseFiles SET
      case_id = :case_id,
      user_id = :user_id,
      file_name = :file_name,
      file_size = :file_size,
      file_url = :file_url,
      file_notes = :file_notes,
      uploaded_at = :uploaded_at ,
      category = :category';

  // Prepare Statement
  $stmt = $this->conn->prepare($query);

  // Clean data
  $this->case_id = htmlspecialchars(strip_tags($this->case_id));
  $this->user_id = htmlspecialchars(strip_tags($this->user_id));
  $this->file_name = htmlspecialchars(strip_tags($this->file_name));
  $this->file_size = htmlspecialchars(strip_tags($this->file_size));
  $this->file_url = htmlspecialchars(strip_tags($this->file_url));
  $this->file_notes = htmlspecialchars(strip_tags($this->file_notes));
  $this->uploaded_at = htmlspecialchars(strip_tags($this->uploaded_at));
  $this->category = htmlspecialchars(strip_tags($this->category));

  // Bind data
  $stmt->bindParam(':case_id', $this->case_id);
  $stmt->bindParam(':user_id', $this->user_id);
  $stmt->bindParam(':file_name', $this->file_name);
  $stmt->bindParam(':file_size', $this->file_size);
  $stmt->bindParam(':file_url', $this->file_url);
  $stmt->bindParam(':file_notes', $this->file_notes);
  $stmt->bindParam(':uploaded_at', $this->uploaded_at);
  $stmt->bindParam(':category', $this->category);

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
    $query = 'UPDATE caseFiles
    SET
    case_id = :case_id,
    user_id = :user_id,
    file_name = :file_name,
    file_size = :file_size,
    file_url = :file_url,
    file_notes = :file_notes,
    uploaded_at = :uploaded_at,
    category = :category
    WHERE id = :id';

    // Prepare Statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->id = htmlspecialchars(strip_tags($this->id));
    $this->case_id = htmlspecialchars(strip_tags($this->case_id));
    $this->user_id = htmlspecialchars(strip_tags($this->user_id));
    $this->file_name = htmlspecialchars(strip_tags($this->file_name));
    $this->file_size = htmlspecialchars(strip_tags($this->file_size));
    $this->file_url = htmlspecialchars(strip_tags($this->file_url));
    $this->file_notes = htmlspecialchars(strip_tags($this->file_notes));
    $this->uploaded_at = htmlspecialchars(strip_tags($this->uploaded_at));
    $this->category = htmlspecialchars(strip_tags($this->category));

    // Bind data
    $stmt->bindParam(':id', $this->id);
    $stmt->bindParam(':case_id', $this->case_id);
    $stmt->bindParam(':user_id', $this->user_id);
    $stmt->bindParam(':file_name', $this->file_name);
    $stmt->bindParam(':file_size', $this->file_size);
    $stmt->bindParam(':file_url', $this->file_url);
    $stmt->bindParam(':file_notes', $this->file_notes);
    $stmt->bindParam(':uploaded_at', $this->uploaded_at);
    $stmt->bindParam(':category', $this->category);

    // Execute query
    if($stmt->execute()) {
        return true;
    }

    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;
 }


//// create multi record 
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

   
 