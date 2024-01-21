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
    }

    $obj = new App;