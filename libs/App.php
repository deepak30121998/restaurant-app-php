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

            // if($this->link) {
            //     echo "db connection is working";
            // }
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

        // insert query
        public function insert($query, $arr, $path)
        {
            if($this->validate($arr) == "empty") {
                echo "<script>alert('one or more inputs are empty')</script>";
            } else{
                $insert_record = $this->link->prepare($query);
                $insert_record->execute($arr);

                echo "<script>window.location.href='".$path."'</script>";
            }
        }

        // validating Cart
        public function validateCart($q)
        {
            $row = $this->link->query($q);
            $row->execute();

            $count = $row->rowCount();
            return $count;
        }

        //update query
        public function update($query, $arr, $path)
        {
            if($this->validate($arr) == "empty") {
                echo "<script>alert('one or more inputs are empty')</script>";
            } else{
                $update_record = $this->link->prepare($query);
                $update_record->execute($arr);

                header("location: ".$path."");
            }
        }

        // delete query
        public function delete($query, $path)
        {
            $delete_record = $this->link->query($query);
            $delete_record->execute(); 

            echo "<script>window.location.href='".$path."'</script>";
        }

        public function validate($arr)
        {
            if(in_array("", $arr)) {
                return "empty";
            }
        }

        
        // register method
        public function register($query, $arr, $path)
        {
            // Validate input parameters
            if ($this->validate($arr) == "empty") {
                echo "<script>alert('One or more inputs are empty')</script>";
            } else {
                try {
                    // Prepare and execute the query
                    $register_user = $this->link->prepare($query);
                    $register_user->execute($arr);

                    // Redirect upon successful registration
                    header("location: " . $path);
                    exit; // Ensure that no further code is executed after the header is sent
                } catch (PDOException $e) {
                    // Handle database errors
                    echo "Database Error: " . $e->getMessage();
                }
            }
        }


        //login method
        public function login($query, $params, $path)
        {
            try {
                $stmt = $this->link->prepare($query);
                $stmt->execute();

                $fetch = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($stmt->rowCount() > 0) {

                    // Start session variables
                    $_SESSION['email'] = $fetch['email'];
                    $_SESSION['username'] = $fetch['username'];
                    $_SESSION['user_id'] = $fetch['id'];
                    
                    // Verify password
                    if (password_verify($params['password'], $fetch['password'])) {
                        header("location: " . APPURL. "");
                        exit(); 
                    } else {
                        echo "Incorrect password";
                    }
                } else {
                    echo "User not found";
                }
            } catch (PDOException $e) {
                // Handle database errors
                echo "Error: " . $e->getMessage();
            }
        }


        // Starting session
        public function startingSession()
        {
            session_start();
        }

        // validating sessions
        public function validateSession()
        {
            if(isset($_SESSION['user_id'])) {
                echo "<script>window.location.href='".APPURL."'</script>";
            }
        }

        
    }
