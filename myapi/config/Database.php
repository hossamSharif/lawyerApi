   <?php 
  class Database {
   // DB Params
    //private $host = 'localhost';
    //private $db_name = 'aljouryc_erp';
    // private $username = 'aljouryc_hossam';
   // private $password = 'Hossam1990@';
    //private $conn;
 
   // public function connect() {
     // $this->conn = null;

      //try {  
        //$this->conn = new PDO('mysql:host=' . $this->host . ';port=2083;dbname=' . $this->db_name, $this->username, $this->password);
      //  $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //  } catch(PDOException $e) {
    //    echo 'Connection Error: ' . $e->getMessage();
     // }


    //  return $this->conn;


      private $host = 'localhost';
          private $db_name = 'lawyer';
          private $username = 'root';
          private $password = '';
          private $conn;
     
         public function connect() {
          $this->conn = null;
    
            try {  
             $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
              $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
              echo 'Connection Error: ' . $e->getMessage();
            }
            return $this->conn;     
  }     
  }                                                