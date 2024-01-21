<?php require "../config/config.php"; ?>
<?php

    class App {
        public $host = HOST;
        public $dbname = DBNAME;
        public $user = USER;
        public $pass = PASS;

        public $link;


        //create a constructor

        public function __construct()
        {
            $this->connect();
        }

        public function connect()
        {
            $this->link = new PDO("mysql:host=".$this->host.";dbname=".$this->dbname."",$this->user, $this->pass);

            if($this->link) {
                echo "db connection is working";
            }
        }

        // Select All
        public function selectAll($query)
        {
            $rows = $this->link->query($query);
            $rows->execute();

            $allRows = $rows->fetchAll(PDO::FETCH_OBJ);

            if($allRows) {
                return $allRows;
            }else{
                return false;
            }
        }

        // Select One row
        public function selectOne($query)
        {
            $row = $this->link->query($query);
            $row->execute();

            $singleRow = $row->fetch(PDO::FETCH_OBJ);

            if($singleRow) {
                return $singleRow;
            }else{
                return false;
            }
        }
    }

    $obj = new App;