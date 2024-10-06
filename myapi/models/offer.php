<?php
  class Offer {
    // DB Stuff
    private $conn;
    private $table = 'offer';

    // Properties
    public $id;
    public $title;
    public $dailyTime;
    public $hourCount;
    public $price;
    public $price_note; 
    public $start;
    public $sectionId;
    public $shortDescr;
    public $teacher;
    public $imgUrl;
    
    public $ordering;
    public $discountLbl; 
    public $newLbl;
     public $status;
    
    public $serviceId;
    
  
    public $ptid;
    public $serv_desc;
    public $serv_price;
    public $serv_type;
    public $list_ordering;
    public $serv_shortDescr;
    public $serv_id;
   

    public $price2;
    public $price1;


    
    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get doctors
    public function read() {
      // Create query
      $query = 'SELECT
        id,
        title,
        dailyTime,
        hourCount,
        price,
        price_note, 
        start,
        sectionId,
        shortDescr,
        teacher,
        imgUrl ,
        ordering,
        discountLbl,
        newLbl,
        status
      FROM
        ' . $this->table . '
      WHERE
        title !="" 
      ORDER BY
        id DESC';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }
//
public function read2($id) {
  // Create query
  $query = 'SELECT * FROM ' . $this->table . ' WHERE sectionId  = ' . $id . ' ORDER BY id DESC'; 

  // Prepare statement
  $stmt = $this->conn->prepare($query);

  // Execute query
  $stmt->execute();

  return $stmt;
}



    // Get Single Category
  public function read_single(){
    // Create query
    $query = 'SELECT
          id,
        title,
        dailyTime,
        hourCount,
        price,
        price_note,
        start,
        sectionId,
        shortDescr,
        teacher,
        imgUrl,
        ordering,
       discountLbl,
       newLbl,
       status
        FROM
          ' . $this->table . '
      WHERE id = ?
      LIMIT 0,1';

      //Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind id
      $stmt->bindParam(1, $this->id);

      // Execute query
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // set properties
      $this->id = $row['id'];
      $this->title = $row['title'];
      $this->dailyTime = $row['dailyTime'];
      $this->hourCount = $row['hourCount'];
      $this->price = $row['price'];
      $this->price = $row['price_note']; 
      $this->start = $row['start']; 
      $this->sectionId = $row['sectionId']; 
      $this->shortDescr = $row['shortDescr']; 
      $this->teacher = $row['teacher']; 
      $this->imgUrl = $row['imgUrl']; 
      $this->ordering = $row['ordering']; 
       $this->discountLbl = $row['discountLbl']; 
        $this->newLbl = $row['newLbl']; 
         $this->status = $row['status']; 
     
  }

///get group invoice with services only
  
  public function gorupServicesOnly(){
    // Create query
    $query = 'SELECT 
        invoice.id,
        invoice.title,
        invoice.dailyTime,
        invoice.hourCount,
        invoice.price,
        invoice.price_note, 
        invoice.start,
        invoice.sectionId,
        invoice.shortDescr,
        invoice.teacher,
        invoice.imgUrl,
        invoice.user_name,
        invoice.invo_type

        FROM
         ' . $this->table . ' 
        WHERE 
        invoice.invo_type = :invo_type AND invoice.price = :price 
        ORDER BY
        invoice.id ASC
        ';

      //Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind id
     
      $stmt->bindParam(':price',  $this->price, PDO::PARAM_STR);
      $stmt->bindParam(':invo_type', $this->invo_type, PDO::PARAM_STR); 

      // Execute query
      $stmt->execute();

      return $stmt ;
     
  }

      // Get group invoices of spacific doctor at date
      public function gorupDoctors(){
        // Create query
        $query = 'SELECT
            invoice.id,
            invoice.title,
            invoice.dailyTime,
            invoice.hourCount,
            invoice.price,
            invoice.price_note ,
            invoice.start,
            invoice.sectionId,
            invoice.shortDescr,
            invoice.teacher,
            invoice.imgUrl,
            invoice.user_name,
            invoice.invo_type, 
            services.list_ordering,
            services.id

            FROM
             ' . $this->table . ' 
            INNER JOIN  
            services ON invoice.id = services.ptid
            WHERE 
            invoice.price = :price AND services.serv_type = :serv_type AND services.serv_id = :serv_id
            ORDER BY
            invoice.id ASC
            ';
     
          //Prepare statement
          $stmt = $this->conn->prepare($query); 
          // Bind id 
          $stmt->bindParam(':price',  $this->price, PDO::PARAM_STR);
          $stmt->bindParam(':serv_type', $this->serv_type, PDO::PARAM_STR);
          $stmt->bindParam(':serv_id', $this->serv_id, PDO::PARAM_INT); 
          // Execute query
          $stmt->execute(); 
          return $stmt ; 
      }

      
/// get invoice with detail
public function getInvoiceDetails(){
  // Create query
  $query = 'SELECT
      invoice.id,
      invoice.title,
      invoice.dailyTime,
      invoice.hourCount,
      invoice.price,
      invoice.price_note, 
      invoice.start,
      invoice.sectionId,
      invoice.shortDescr,
      invoice.teacher,
      invoice.imgUrl,
      invoice.user_name,
      invoice.invo_type, 
      services.list_ordering,
      services.id ,
      services.ptid ,
      services.serv_desc ,
      services.serv_type ,
      services.serv_price ,
      services.serv_id ,
      invoice.pt_adress
       
      FROM
       ' . $this->table . ' 
      INNER JOIN  
      services ON invoice.id = services.ptid
      WHERE 
      invoice.id = :id';

    //Prepare statement
    $stmt = $this->conn->prepare($query);

    // Bind id 
    $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

    // Execute query
    $stmt->execute();

    return $stmt ;
   
}

  // Get group invoices of spacific doctor at date
  public function invoceInDate(){
    // Create query
    $query = 'SELECT
        invoice.id,
        invoice.title,
        invoice.dailyTime,
        invoice.hourCount,
        invoice.price,
        invoice.price_note, 
        invoice.start,
        invoice.sectionId,
        invoice.shortDescr,
        invoice.teacher,
        invoice.imgUrl,
        invoice.user_name,
        invoice.invo_type ,
        services.serv_price ,
        services.serv_id ,
        services.serv_desc

        FROM
         ' . $this->table . ' 
          INNER JOIN  
          services ON invoice.id = services.ptid 
        WHERE 
        invoice.price = :price AND services.serv_type = :serv_type
        ORDER BY
        invoice.id ASC
        '; 
      //Prepare statement
      $stmt = $this->conn->prepare($query); 
      // Bind id 
      $stmt->bindParam(':price',  $this->price, PDO::PARAM_STR); 
      $stmt->bindParam(':serv_type',  $this->serv_type, PDO::PARAM_STR); 
      // Execute query
      $stmt->execute(); 
      return $stmt ; 
  }


  // Get group invoices  
      public function invoceBetweenDate(){
        // Create query
        $query = 'SELECT
            invoice.id,
            invoice.title,
            invoice.dailyTime,
            invoice.hourCount,
            invoice.price,
            invoice.price_note, 
            invoice.start,
            invoice.sectionId,
            invoice.shortDescr,
            invoice.teacher,
            invoice.imgUrl,
            invoice.user_name,
            invoice.invo_type ,
            services.serv_price ,
            services.serv_id ,
            services.serv_desc 
            FROM
             ' . $this->table . '  
             INNER JOIN  
             services ON invoice.id = services.ptid 
            WHERE 
            invoice.price >= :price1 AND invoice.price <= :price2 AND services.serv_type = :serv_type
            ORDER BY
            invoice.id ASC
            ';
    
          //Prepare statement
          $stmt = $this->conn->prepare($query);
    
          // Bind id
         
          $stmt->bindParam(':price1',  $this->price1, PDO::PARAM_STR);
          $stmt->bindParam(':price2', $this->price2, PDO::PARAM_STR); 
          $stmt->bindParam(':serv_type',  $this->serv_type, PDO::PARAM_STR); 
    
          // Execute query
          $stmt->execute();
    
          return $stmt ;
         
      }


  // Create Category
  public function create() {
    // Create Query
    $query = 'INSERT INTO ' .
    $this->table . '
    SET   
     title = :title ,
     dailyTime = :dailyTime,
     hourCount = :hourCount, 
     price = :price,
     price_note = :price_note,  
     start = :start,
     sectionId = :sectionId,
     shortDescr = :shortDescr,
     teacher = :teacher,
     imgUrl = :imgUrl,
     ordering = :ordering, 
     discountLbl = :discountLbl,
     newLbl = :newLbl ,
     status = :status
     ';
     
       
  // Prepare Statement
  $stmt = $this->conn->prepare($query);

  // Clean data
  $this->title = htmlspecialchars(strip_tags($this->title));
  $this->dailyTime = htmlspecialchars(strip_tags($this->dailyTime));
  $this->hourCount = htmlspecialchars(strip_tags($this->hourCount));
  $this->price = htmlspecialchars(strip_tags($this->price));
  $this->price_note = htmlspecialchars(strip_tags($this->price_note)); 
  $this->start = htmlspecialchars(strip_tags($this->start));
  $this->sectionId = htmlspecialchars(strip_tags($this->sectionId));
  $this->shortDescr = htmlspecialchars(strip_tags($this->shortDescr));
  $this->teacher = htmlspecialchars(strip_tags($this->teacher));
  $this->imgUrl = htmlspecialchars(strip_tags($this->imgUrl)); 
  $this->ordering = htmlspecialchars(strip_tags($this->ordering)); 
  $this->discountLbl = htmlspecialchars(strip_tags($this->discountLbl)); 
  $this->newLbl = htmlspecialchars(strip_tags($this->newLbl)); 
  $this->status = htmlspecialchars(strip_tags($this->status)); 


   

  // Bind data
  $stmt-> bindParam(':title', $this->title);
  $stmt-> bindParam(':dailyTime', $this->dailyTime);
  $stmt-> bindParam(':hourCount', $this->hourCount);
  $stmt-> bindParam(':price', $this->price);
  $stmt-> bindParam(':price_note', $this->price_note); 
  $stmt-> bindParam(':start', $this->start);
  $stmt-> bindParam(':sectionId', $this->sectionId); 
  $stmt-> bindParam(':shortDescr', $this->shortDescr);
  $stmt-> bindParam(':teacher', $this->teacher);
  $stmt-> bindParam(':imgUrl', $this->imgUrl); 
 $stmt-> bindParam(':imgUrl', $this->imgUrl); 
  $stmt-> bindParam(':ordering', $this->ordering); 
   $stmt-> bindParam(':discountLbl', $this->discountLbl); 
    $stmt-> bindParam(':newLbl', $this->newLbl); 
     $stmt-> bindParam(':status', $this->status); 
  // Execute query
  if($stmt->execute()) {
    return true;
  }

  // Print error if something goes wrong
  printf("Error: $s.\n", $stmt->error); 
  return false;
  }

  // Update Category
  public function update() {
    // Create Query
     $query = 'UPDATE ' .
      $this->table . '
     SET
     title = :title , 
     dailyTime = :dailyTime,
     hourCount = :hourCount,
     price = :price,
     price_note = :price_note, 
     start = :start,
     sectionId = :sectionId,
     shortDescr = :shortDescr,
     teacher = :teacher,
     imgUrl = :imgUrl ,
     ordering = :ordering, 
     discountLbl = :discountLbl,
     newLbl = :newLbl ,
     status = :status
     WHERE
     id = :id';

  // Prepare Statement
   $stmt = $this->conn->prepare($query);

  // Clean data
   $this->id = htmlspecialchars(strip_tags($this->id));
   $this->title = htmlspecialchars(strip_tags($this->title));
   $this->dailyTime = htmlspecialchars(strip_tags($this->dailyTime));
   $this->hourCount = htmlspecialchars(strip_tags($this->hourCount));
   $this->price = htmlspecialchars(strip_tags($this->price));
   $this->price_note = htmlspecialchars(strip_tags($this->price_note)); 
   $this->start = htmlspecialchars(strip_tags($this->start));
   $this->sectionId = htmlspecialchars(strip_tags($this->sectionId));
   $this->shortDescr = htmlspecialchars(strip_tags($this->shortDescr));
   $this->teacher = htmlspecialchars(strip_tags($this->teacher));
   $this->imgUrl = htmlspecialchars(strip_tags($this->imgUrl)); 
   $this->ordering = htmlspecialchars(strip_tags($this->ordering)); 
  $this->discountLbl = htmlspecialchars(strip_tags($this->discountLbl)); 
  $this->newLbl = htmlspecialchars(strip_tags($this->newLbl)); 
  $this->status = htmlspecialchars(strip_tags($this->status)); 

  // Bind data
   $stmt-> bindParam(':id', $this->id); 
   $stmt-> bindParam(':title', $this->title);
   $stmt-> bindParam(':dailyTime', $this->dailyTime);
   $stmt-> bindParam(':hourCount', $this->hourCount);
   $stmt-> bindParam(':price', $this->price);
   $stmt-> bindParam(':price_note', $this->price_note); 
   $stmt-> bindParam(':start', $this->start);
   $stmt-> bindParam(':sectionId', $this->sectionId); 
   $stmt-> bindParam(':shortDescr', $this->shortDescr);
   $stmt-> bindParam(':teacher', $this->teacher);
   $stmt-> bindParam(':imgUrl', $this->imgUrl); 
    $stmt-> bindParam(':ordering', $this->ordering); 
   $stmt-> bindParam(':discountLbl', $this->discountLbl); 
   $stmt-> bindParam(':newLbl', $this->newLbl); 
   $stmt-> bindParam(':status', $this->status); 
 

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
